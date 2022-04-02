<?php 

if(isset($_GET['run']))
{
    //print_r(str_replace("\\", '\\\\', GetCurrentUser()));
    print_r(GetCurrentUser());
}


function GetCurrentUser()
{
    $PowerShellUserScript = "..\PowerShell\Get-AzureADUser.ps1";
    $Currentuser = $_SERVER['AUTH_USER'];

    if (filter_var($Currentuser, FILTER_VALIDATE_EMAIL)) {
        $unsanitized = sprintf('powershell.exe -NonInteractive -NoProfile -ExecutionPolicy Bypass -File "%s" -search "%s" -type "%s"', $PowerShellUserScript,  $Currentuser, "Azure");
        $UserADInfo = json_decode(shell_exec($unsanitized));

        return $UserADInfo;
    }
    else{

        $UserName = explode("\\", $Currentuser);
        $unsanitized = sprintf('powershell.exe -NonInteractive -NoProfile -ExecutionPolicy Bypass -File "%s" -search "%s" -type "%s"', $PowerShellUserScript,  $UserName[1], "Ad");
        $UserADInfo = json_decode(shell_exec($unsanitized));

        return $UserADInfo;   
    }
}


function SerachUser($user)
{
    $PowerShellUserScript = "..\PowerShell\Get-AzureADUser.ps1";

    if (filter_var($user, FILTER_VALIDATE_EMAIL)) {
        $unsanitized = sprintf('powershell.exe -NonInteractive -NoProfile -ExecutionPolicy Bypass -File "%s" -search "%s" -type "%s"', $PowerShellUserScript,  $user, "Azure");
        $UserADInfo = json_decode(shell_exec($unsanitized));

        return $UserADInfo;
    }
    else{

        $unsanitized = sprintf('powershell.exe -NonInteractive -NoProfile -ExecutionPolicy Bypass -File "%s" -search "%s" -type "%s"', $PowerShellUserScript,  $user, "Ad");
        $UserADInfo = json_decode(shell_exec($unsanitized));

        return $UserADInfo;  
    } 
}


?>