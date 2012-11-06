Write-Host
Write-Host "Carbon Powershell Script"
Write-Host

[Environment]::CurrentDirectory = $PWD
$TempDir = [System.IO.Path]::GetTempPath()


if (! $args) {
    Write-Host "The following arguments are supported:"
    Write-Host "    deploy         deploy to site"
    Write-Host "        <preset>   using <preset> settings"
    Write-Host
    exit
}

Function deploy ($a) {
    $settings = $null

    if ($a[1] -ne $null)  {
        # load and apply settings
        $settings = @{}
        $settings_file = [IO.Path]::GetTempPath() + 'carbon_' + $a[1] + '.xml';
        if (Test-Path $settings_file) {
            $settings = Import-Clixml -Path $settings_file
            $settings.Keys | % { New-Variable -Name $_ -Value $settings[$_]}
            Write-Host "Loading $settings_file ..."        
            Write-host         


            $server      = $settings.Get_Item('server')
            $username    = $settings.Get_Item('username')
            $path        = $settings.Get_Item('path')
            $fingerprint_pt = $settings.Get_Item('fingerprint') 
            $fingerprint = $fingerprint_pt | ConvertTo-SecureString
            $winscp_dll  = $settings.Get_Item('winscp_dll')
            $host_from   = $settings.Get_Item('host_from')
            $host_to     = $settings.Get_Item('host_to')
            write-host "Using"
            write-host "    server:         $server"
            write-host "    username:       $username"
            write-host "    path:           $path"
            write-host 
            write-host "    Replacing:      '$host_from' with '$host_to' in text files"
        } else {
            Write-Host "Settings-file $settings_file does not exist."
        }
        Write-host         
    }
    else {
        # ask and save settings
        $settings = @{}
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
    Copy-Item $PWD\cache\* $TempDir\carbon -recurse

    $files=get-childitem $TempDir\carbon\ * -rec -include *.htm*,*.css,*.js | where { ! $_.PSIsContainer }
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
        $password = Read-Host "Enter password"  -AsSecureString
     
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
            $transferResult = $session.PutFiles("$TempDir\carbon\*", "$path/", $FALSE, $transferOptions)

        }
        Finally
        {
            # Disconnect, clean up
            $session.Dispose()
        }
     
        # Demove temporary files
        Remove-Item $TempDir\carbon\* -recurse
        Write-host "Done"

        exit 0
    }
    Catch [Exception]
    {
        Write-Host "ERROR : " + $_.Exception.Message
        Write-host "Aborted"

        exit 1
    }
}


$command = $args[0]
$output  = & $command $args[0..($args.Length - 1)]

[Environment]::CurrentDirectory = $PWD
