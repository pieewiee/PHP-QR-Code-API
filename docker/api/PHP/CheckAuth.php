
<?php

function GetGraphToken()
{

    $CurlLogin = curl_init();
    $configobj = json_decode(file_get_contents('C:\CRIP_Scripts\config.json'));

    curl_setopt($CurlLogin, CURLOPT_URL, "https://login.microsoftonline.com/" . $configobj->{'TenantId'} . "/oauth2/v2.0/token");

    $post = [
        'tenant'        => $configobj->{'TenantId'},
        'client_id'     => $configobj->{'ClientId'},
        'scope'         => 'https://graph.microsoft.com/.default',
        'client_secret' => $configobj->{'ClientSecret'},
        'grant_type'    => 'client_credentials',
    ];

    curl_setopt($CurlLogin, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($CurlLogin, CURLOPT_PROXY, '185.46.212.98'); # Zscaler Proxy http://local-zscaler.boehringer.com
    curl_setopt($CurlLogin, CURLOPT_PROXYPORT, '80');
    curl_setopt($CurlLogin, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($CurlLogin, CURLOPT_POSTFIELDS, $post);

    $CurlLoginOutput = curl_exec($CurlLogin);
    try {
        $AuthResponse = json_decode($CurlLoginOutput);
    } catch (\Throwable $th) {
        exit;
    }

    curl_close($CurlLogin);

    $headersLogin = [
        
        'Content-Type: application/json',
        'Authorization: Bearer ' . $AuthResponse->{'access_token'},
        'ExpiresOn:' .  $AuthResponse->{'expires_in'}
    ];
    return $headersLogin;
}

function GetCurrentUser()
{
    $CurlLogin = curl_init();
        
    $Currentuser = $_SERVER['AUTH_USER'];


    if (isset($_SERVER['HTTP_X_MS_PROXY']))
    {
        


        $CurlGetUser = curl_init();
        

        curl_setopt($CurlGetUser, CURLOPT_URL, 'https://graph.microsoft.com/v1.0/users/' . $Currentuser . '?$select=onPremisesSamAccountName,onPremisesDomainName');
        curl_setopt($CurlGetUser, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($CurlGetUser, CURLOPT_PROXY, '185.46.212.98');
        curl_setopt($CurlGetUser, CURLOPT_PROXYPORT, '80');
        curl_setopt($CurlGetUser, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($CurlGetUser, CURLOPT_HTTPHEADER, GetGraphToken());

        $CurlDeviceOutput = curl_exec($CurlGetUser);
        
        $UserData = json_decode($CurlDeviceOutput);
        curl_close($CurlGetUser);

        $DomainFullArray = explode(".", $UserData->onPremisesDomainName);

        $DomainShort =  strtoupper($DomainFullArray[0]);


        //print_r($DomainShort . "\\" . $UserData->onPremisesSamAccountName);

        $data = new stdClass();
        
        //$data->User = $DomainShort . "\\" . $UserData->onPremisesSamAccountName;
        $data->Domain =  $DomainShort;
        $data->User =  $UserData->onPremisesSamAccountName;

        $data->photo = GetUserPic();


        $json_string = json_encode($data, JSON_PRETTY_PRINT);
        
        
        return $json_string;



    }else{
        //print_r($_SERVER['AUTH_USER']);


        $data = new stdClass();

        if(strpos($_SERVER['AUTH_USER'], "\\") === false){
            header("Location: https://inhas68849.eu.boehringer.com/Auth/LogOut");
            die();
        } 

        $user = explode( '\\', $_SERVER['AUTH_USER'] );

        
        $data->Domain =  $user[0];
        $data->User =  $user[1];

        $data->photo = GetUserPic();
        
        $json_string = json_encode($data, JSON_PRETTY_PRINT);
        return $json_string;



    }
}

function GetUserPrincipalName()
{

    //$currentUser = GetCurrentUser(GetGraphToken());
    $currentUser = $_SERVER['AUTH_USER'];

    //print_r($currentUser);
    $UserPrincipalName = "";


    if (filter_var($currentUser, FILTER_VALIDATE_EMAIL)) {
        $UserPrincipalName = $_SERVER['AUTH_USER'];;
    }
    else{
        $PowerShellUserScript = "C:\inetpub\SIPMGMT_PRD\PowerShell\Get-ADUser.ps1";
        $CurrentuserArray = explode("\\", $currentUser);

        $unsanitized = sprintf('powershell.exe -NonInteractive -NoProfile -ExecutionPolicy Bypass -File "%s" -SamAccountName "%s" -Domain "%s"', $PowerShellUserScript, $CurrentuserArray[1], $CurrentuserArray[0]);
        $UserADInfo = json_decode(shell_exec($unsanitized));
        $UserPrincipalName = $UserADInfo->UserPrincipalName;
    }

    //print_r($UserPrincipalName);

    return $UserPrincipalName;
}


function GetUserPic()
{

    $Currentuser = GetUserPrincipalName();



     $CurlGetUserPic = curl_init();

     curl_setopt($CurlGetUserPic, CURLOPT_URL, 'https://graph.microsoft.com/v1.0/users/' . $Currentuser . '/photos/48x48/$value');
     curl_setopt($CurlGetUserPic, CURLOPT_RETURNTRANSFER, 1);
     curl_setopt($CurlGetUserPic, CURLOPT_PROXY, '185.46.212.98');
     curl_setopt($CurlGetUserPic, CURLOPT_PROXYPORT, '80');
     curl_setopt($CurlGetUserPic, CURLOPT_SSL_VERIFYPEER, false);
     curl_setopt($CurlGetUserPic, CURLOPT_HTTPHEADER, GetGraphToken());
     $CurlPicOutput = curl_exec($CurlGetUserPic);
     curl_close($CurlGetUserPic);

     $UserPicBase64 =  base64_encode($CurlPicOutput);

     //$ResponseObj = new StdClass();
     //$ResponseObj->photo = $UserPicBase64;
     

     //return json_encode($ResponseObj);
     return $UserPicBase64;
    

}



?>