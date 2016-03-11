Write-Host
Write-Host "Carbon Powershell Script"

[Environment]::CurrentDirectory = $PWD

if ($document -eq $null) {
    $Global:TempDir = [System.IO.Path]::GetTempPath()
    $Global:document = New-Object -ComObject msxml2.ServerXMLHTTP
    $Global:hostname = ''
    $Global:loggedin = 0
    $Global:passwords = @{}
    $Global:deployment_keyword = ''
}


if (! $args) {
    Write-Host "The following arguments are supported:"
    Write-Host "    login          login to admin"
    Write-Host "        <hostname> to <host>/admin"
    Write-Host "    draft          create draft"
    Write-Host "    generate       generate static site"
    Write-Host "    deploy         deploy to live"
    Write-Host "        <preset>   using <preset> settings"
    Write-Host "    gdeploy        generate + deploy"
    Write-Host "    clear_cache    empty cache"
    Write-Host
    exit
}

Function gdeploy($a) {
    generate
    deploy $a
}

Function deploy ($a) {
    $settings = @{}

    if ($a[1] -ne $null)  {
        # load and apply settings
        $Global:deployment_keyword = $a[1]
        $settings_file = [IO.Path]::GetTempPath() + 'carbon_' + $a[1] + '.xml';
        if (Test-Path $settings_file) {
            $settings = Import-Clixml -Path $settings_file
            $settings.Keys | % { New-Variable -Name $_ -Value $settings[$_]}
            Write-Host "Loading $settings_file ..."        
            Write-host         


            $server         = $settings.Get_Item('server')
            $username       = $settings.Get_Item('username')
            $path           = $settings.Get_Item('path')
            $fingerprint_pt = $settings.Get_Item('fingerprint') 
            $fingerprint    = $fingerprint_pt | ConvertTo-SecureString
            $winscp_dll     = $settings.Get_Item('winscp_dll')
            $host_from      = $settings.Get_Item('host_from')
            $host_to        = $settings.Get_Item('host_to')
            write-host "Using"
            write-host "    server:         $server"
            write-host "    username:       $username"
            write-host "    path:           $path"
            write-host 
            write-host "    Replacing:      '$host_from' to '$host_to' "
        } else {
            Write-Host "Settings-file $settings_file does not exist."
        }
        Write-host         
    }
    else {
        # ask and save settings
        $keyword     = Read-Host "Enter preset name"
        $server      = Read-Host "Enter server"
        $username    = Read-Host "Enter username"
        $path        = Read-Host "Enter destination path"
        $fingerprint = Read-Host "Enter SSH host key fingerprint" -AsSecureString
        $host_from   = Read-Host "Enter SEARCH hostname"
        $host_to     = Read-Host "Enter REPLACE hostname"
        $secure_fingerprint = $fingerprint | ConvertFrom-SecureString
        $settings.Add("server", $server)
        $settings.Add("username", $username)
        $settings.Add("path", $path)
        $settings.Add("fingerprint", $secure_fingerprint)
        $settings.Add("host_from", $host_from)
        $settings.Add("host_to", $host_to)
        $settings_file = [IO.Path]::GetTempPath() + 'carbon_' + $keyword + '.xml';
        Export-Clixml -InputObject $settings -Path $settings_file
    }

    # copy and search replace hostname
    Mkdir $TempDir\carbon -force
    $temp_path = resolve-path "$TempDir\carbon"
    $source_path = resolve-path "$PWD\cache"
    Remove-Item $temp_path\* -recurse

    # Copy-Item $source_path $temp_path -recurse -force
    Copy-Item $source_path\* $temp_path -recurse
    # exit

    $files=get-childitem $temp_path\* -rec -include *.htm*,*.css,*.js | where { ! $_.PSIsContainer }
    foreach ($file in $files) {
        (Get-Content $file.PSPath) | 
        Foreach-Object {$_ -replace "$host_from", "$host_to"} | 
        Set-Content $file.PSPath
    }


    Try
    {
        # Load WinSCP .NET assembly
        if (!$winscp_dll) {
            $winscp_dll_default = "C:\Program Files (x86)\WinSCP\WinSCP.dll"
            if (Test-Path $winscp_dll_default) {
                $winscp_dll = $winscp_dll_default
            } else {
                Write-Host "The WinSCP .NET assembly WinSCP.dll is required so Carbon can upload your site. More info: http://winscp.net/eng/docs/library"
                Write-Host

                $winscp_dll = Read-Host "Enter path to WinSCP.dll"        
            }
            $settings.Add("winscp_dll", $winscp_dll)
            Export-Clixml -InputObject $settings -Path $settings_file
        }

        [Reflection.Assembly]::LoadFrom($winscp_dll)
        if ($passwords.Get_Item($deployment_keyword) -eq $null) {
            $password = Read-Host "Enter password"  -AsSecureString
            $Global:passwords.Add($deployment_keyword, $password)
        } else {
            $password = $passwords.Get_Item($deployment_keyword)
        }
     
        # Setup session options
        $sessionOptions = New-Object WinSCP.SessionOptions
        $sessionOptions.Protocol = [WinSCP.Protocol]::Sftp
        $sessionOptions.HostName = $server
        $sessionOptions.UserName = $username
        $sessionOptions.Password = [Runtime.InteropServices.Marshal]::PtrToStringAuto(
            [Runtime.InteropServices.Marshal]::SecureStringToBSTR($password)
        )
        $sessionOptions.SshHostKeyFingerprint = [Runtime.InteropServices.Marshal]::PtrToStringAuto(
            [Runtime.InteropServices.Marshal]::SecureStringToBSTR($fingerprint)
        )
     
        $session = New-Object WinSCP.Session
     
        # Upload files
        Try
        {
            $session.Open($sessionOptions)
            $transferOptions = New-Object WinSCP.TransferOptions
            $transferOptions.TransferMode = [WinSCP.TransferMode]::Automatic
     
            $transferResult = $session.RemoveFiles("$path/*")
            $transferResult = $session.PutFiles("$temp_path\*", "$path/", $FALSE, $transferOptions)

        }
        Finally
        {
            # Disconnect, clean up
            $session.Dispose()
        }
     
        # Demove temporary files
        Write-host "Done"

    }
    Catch [Exception]
    {
        Write-Host "ERROR : " + $_.Exception.Message
        Write-host "Aborted"

    }
    Remove-Item $temp_path\* -recurse
}


Function login ($a) {
    if ($a[1] -ne $null)  {
        $password = Read-Host "Enter admin password"  -AsSecureString
        $password_plain = [Runtime.InteropServices.Marshal]::PtrToStringAuto(
                [Runtime.InteropServices.Marshal]::SecureStringToBSTR($password)
            )
        $Global:hostname = $a[1]
        $url = "http://" + $hostname + '/admin'
        $postline = "password=" + $password_plain

        # Create COM object, open a connection to www.somewhere.com,
        # and set the header type
        $document.open("POST", $url, $false)
        $document.setRequestHeader("Content-Type", "application/x-www-form-urlencoded")
     
        # Create the necessary login and report information from the parms we passed
     
        # Login to Markit with the information we passed above
        $document.send($postline)
     
        # Check to see if we have a document matching the parms we passed
        $response = $document.getResponseHeader("Content-Type")
     
        # // return the text of the web page
        if ($document.status -eq 200) {
            $Global:loggedin = 1
            Write-Host $document.status  "logged in"        
        } 
        else {
            Write-Host $document.status           
        }
    }
    else {
        Write-Host "Add hostname"

    }
    
}

Function logout() {
    $Global:document = $null
    $Global:loggedin = $null
    $Global:hostname = $null
    $Global:passwords.Remove($deployment_keyword)
    $Global:deployment_keyword = $null
    $Global:TempDir = $null
    Write-host "logged out"
}

Function generate () {
    if ($loggedin -eq 1)  {
        $url = "http://" + $hostname + '/admin/generate'

        # Create COM object, open a connection to www.somewhere.com,
        # and set the header type
        $document.open("GET", $url, $false)
        $document.send()
     
        # // return the text of the web page
        if ($document.status -eq 200) {
            Write-Host "Generated"
        }
        else {
            Write-Host $document.status
        }
    }
    else {
        Write-Host "Not logged in."
    }
}

Function clear_cache() {
    if ($loggedin -eq 1)  {
        $url = "http://" + $hostname + '/admin/clear_cache'

        # Create COM object, open a connection to www.somewhere.com,
        # and set the header type
        $document.open("GET", $url, $false)
        $document.send()
     
        # // return the text of the web page
        if ($document.status -eq 200) {
            Write-Host "Cleared"
        }
        else {
            Write-Host $document.status
        }
    }
    else {
        Write-Host "Not logged in."
    }
}

Function draft ($a) {
    if ($loggedin -eq 1)  {

        $url = "http://" + $hostname + '/admin/draft'

        # Create COM object, open a connection to www.somewhere.com,
        # and set the header type
        $document.open("GET", $url, $false)
        $document.SetRequestHeader("Accept-Charset", "utf-8;q=1.0")
        $document.send()
     
        # // return the text of the web page
        if ($document.status -eq 200) {
            $tempFile = [IO.Path]::GetTempFileName() + ".md"
            $Utf8NoBomEncoding = New-Object System.Text.UTF8Encoding($False)
            [System.IO.File]::WriteAllLines($tempFile, $document.responseText, $Utf8NoBomEncoding)

            start $tempFile
        }
        else {
            Write-Host $document.status
        }    
    }
    else {
        Write-Host "Not logged in."
    }

  
    
}

$command = $args[0]
$output  = & $command $args[0..($args.Length - 1)]

[Environment]::CurrentDirectory = $PWD
