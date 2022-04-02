<?php
$serachValue = "";
        // create curl resource
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

        $headers = [
            
            'Content-Type: application/json',
            'ConsistencyLevel: eventual',
            'Authorization: Bearer ' . $AuthResponse->{'access_token'},
            'ExpiresOn:' .  $AuthResponse->{'expires_in'}
        ];

        //print_r($headers);

        $CurlGetDevices = curl_init();

        $searchURL = "https://graph.microsoft.com/v1.0/users/";
          
        if(isset($_GET['search']) ) {
            $serachValue = htmlspecialchars($_GET['search'], ENT_QUOTES);

            //$serachValue = str_replace($serachValue, "", "%20");
            $searchURL = "https://graph.microsoft.com/v1.0/users/?\$search=\"displayName:" . $serachValue . "\"%20OR%20\"userPrincipalName:" . $serachValue . "\"&\$select=displayName,id,mail,city,companyName,country,officeLocation,onPremisesSamAccountName,onPremisesDomainName";
        }

        curl_setopt($CurlGetDevices, CURLOPT_URL, $searchURL);
        curl_setopt($CurlGetDevices, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($CurlGetDevices, CURLOPT_PROXY, '185.46.212.98');
        curl_setopt($CurlGetDevices, CURLOPT_PROXYPORT, '80');
        curl_setopt($CurlGetDevices, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($CurlGetDevices, CURLOPT_HTTPHEADER, $headers);

        $CurlDeviceOutput = curl_exec($CurlGetDevices);

        $users = json_decode($CurlDeviceOutput);
        //print_r($CurlDeviceOutput);
        
        //$response->total = count($devices->value);
        //$response->totalNotFiltered = count($devices->value);
        //$response->rows = $devices->value;
        $responseArray = array();

        foreach ($users->value as $key => $value) {
            if (!is_null($value->onPremisesDomainName)){


                $response = new StdClass();
                $response->displayName = $value->displayName;
                $response->mail = $value->mail;
                $response->country = $value->country;
                $response->onPremisesSamAccountName = $value->onPremisesSamAccountName;
                $domain = explode(".", $value->onPremisesDomainName);
                $response->onPremisesDomainName = $domain[0];

                array_push($responseArray, $response);
            }
        }

        //print_r(json_encode($response->value));
        print_r(json_encode($responseArray));
        //print_r(json_encode($devices));
        //print_r($CurlDeviceOutput);
        curl_close($CurlGetDevices);

        
        

?>