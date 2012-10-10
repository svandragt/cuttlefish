Write-Host
Write-Host "Carbon Powershell Script"
Write-Host

[Environment]::CurrentDirectory = $PWD


if (! $args) {
    Write-Host "The following arguments are supported:"
    Write-Host "    deploy          deploy to site"
    Write-Host "        <keyword>   using <keyword> settings"
    Write-Host
    exit
}

Function load_settings( $settings_file) {
    if (Test-Path $settings_file) {
        $settings = Import-Clixml -Path $settings_file
        $settings.Keys | % { New-Variable -Name $_ -Value $settings[$_]}
        return $settings
    }
    Write-Host $settings_file
}

Function save_settings($settings, $settings_file) {
    Write-Host $settings_file
    Export-Clixml -InputObject $settings -Path $settings_file
}


Function deploy ($a) {
    $settings = $null

    if ($a[1] -ne $null)  {
        $settings = @{}
        $settings_file = [IO.Path]::GetTempPath() + 'carbon_' + $a[1] + '.xml';
        $settings = load_settings $settings_file
    }

    if ($settings ){
        $server      = $settings.Get_Item('server')
        $username    = $settings.Get_Item('username')
        $path        = $settings.Get_Item('path')
        $fingerprint = $settings.Get_Item('fingerprint')
        $winscp_dll  = $settings.Get_Item('winscp_dll')
        write-host "Using"
        write-host "    server:         $server"
        write-host "    username:       $username"
        write-host "    path:           $path"
        write-host "    fingerprint:    $fingerprint"
        write-host 
    } else {
        $settings = @{}
        $keyword     = Read-Host "Enter keyword for recall"
        $server      = Read-Host "Enter server"
        $username    = Read-Host "Enter username"
        $path        = Read-Host "Enter destination path"
        $fingerprint = Read-Host "Enter SshHostKeyFingerprint"
        $settings.Add("server", $server)
        $settings.Add("username", $username)
        $settings.Add("path", $path)
        $settings.Add("fingerprint", $fingerprint)
        $settings_file = [IO.Path]::GetTempPath() + 'carbon_' + $keyword + '.xml';
        Write-host $settings_file
        save_settings $settings $settings_file
    }


    try
    {
        # Load WinSCP .NET assembly

        if (!$winscp_dll) {
            $winscp_dll_default = "C:\Program Files (x86)\WinSCP\WinSCP.dll"
            if (Test-Path $winscp_dll_default) {
                $winscp_dll = $winscp_dll_default
            } else {
                $winscp_dll = Read-Host "Enter path to WinSCP.dll"        
            }
            $settings.Add("winscp_dll", $winscp_dll)
            save_settings $settings $settings_file
        }

        [Reflection.Assembly]::LoadFrom($winscp_dll)
        $password = Read-Host "Enter password"  -AsSecureString

     
        # Setup session options
        $sessionOptions = New-Object WinSCP.SessionOptions
        $sessionOptions.Protocol = [WinSCP.Protocol]::Sftp
        $sessionOptions.HostName = $server
        $sessionOptions.UserName = $username
        $sessionOptions.Password = [Runtime.InteropServices.Marshal]::PtrToStringAuto(
    [Runtime.InteropServices.Marshal]::SecureStringToBSTR($password))
        $sessionOptions.SshHostKeyFingerprint = $fingerprint
     
        $session = New-Object WinSCP.Session

     
        try
        {

            

            # Connect
            $session.Open($sessionOptions)
     
            # Upload files
            $transferOptions = New-Object WinSCP.TransferOptions
            $transferOptions.TransferMode = [WinSCP.TransferMode]::Automatic
     
            $transferResult = $session.RemoveFiles("$path/*")
            $transferResult = $session.PutFiles("$PWD\cache\*", "$path/", $FALSE, $transferOptions)

        }
        finally
        {
            # Disconnect, clean up
            $session.Dispose()
        }
     
        exit 0
    }
    catch [Exception]
    {
        Write-Host "ERROR : " + $_.Exception.Message
        exit 1
    }
}


$command = $args[0]
$output  = & $command $args[0..($args.Length - 1)]

[Environment]::CurrentDirectory = $PWD
