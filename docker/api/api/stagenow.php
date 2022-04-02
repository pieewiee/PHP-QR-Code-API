<?php

function generateRandomString($length = 25) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

    include('phpqrcode/qrlib.php');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        $Content = file_get_contents('php://input');

        $obj = json_decode($Content);
        $FileName =  $obj->{'FileName'};
        #$FileContent =  base64_decode($obj->{'content'});
        $DownloadLink =  $obj->{'DownloadLink'};
        $method =  $obj->{'method'};
        $AndroidVersion =  $obj->{'Version'};

    
        if ($method == "copy")
        {
            #$NewFileName = generateRandomString(64) . ".wldep";
            #file_put_contents($NewFileName, $FileContent);
            $base = "NJ50AAAAmjoFAGUBcAJxL3NkY2FyZC90ZXN0LnppcAB6AXxodHRwczovL3FyLm5ldGdldHZwbi5kZS9kb3dubG9hZC53bGRlcAA=";
            $base = base64_decode($base);

            if ($FileName == "sap_index.html")
            {
                $base = str_replace("/sdcard/test.zip", "/sdcard/android/data/com.symbol.enterprisebrowserBI/" . $FileName, $base);
            }

            if (strpos($FileName, '.db') !== false)
            {
                $base = str_replace("/sdcard/test.zip", "/enterprise/device/settings/datawedge/autoimport/datawedge.db", $base);
            }


            if ($FileName == "config.xml")
            {
                
                $base = str_replace("/sdcard/test.zip", "/sdcard/android/data/com.symbol.enterprisebrowserBI/" . $FileName . '.xml', $base);
            }
            
        
            if ($AndroidVersion == "Android 8")
            {
                $base = str_replace("/sdcard/test.zip", "/sdcard/Android/data/com.wavelink.Velocity/files/" . $FileName , $base);
            }
            if ($AndroidVersion == "Android 10")
            {
                $base = str_replace("/sdcard/test.zip", "/sdcard/Android/data/com.wavelink.Velocity/files/" . $FileName , $base);
            }


            
            $base = str_replace("https://qr.netgetvpn.de/download.wldep", $DownloadLink, $base);
            #$base = "4t:epq/sdcard/test.zipz|https://qr.netgetvpn.de/download.wldep";
            $encoded = base64_encode($base);
            $hex = "0101" . bin2hex($encoded);
    
    
            $strcode='';
            for ($i=0; $i < strlen($hex)-1; $i+=2)
            {
            $strcode .= chr(hexdec($hex[$i].$hex[$i+1]));
            }

            QRCode::png($strcode);

        }
        if ($method == "delete")
        {

            $base = "LL50AAAAmjoFAGUEhC9zZGNhcmQvdGVzdC56aXAA";
            $base = base64_decode($base);
        
            if ($AndroidVersion == "Android 8")
            {
                //$base = str_replace("/sdcard/test.zip", "/sdcard/com.wavelink.Velocity/" . $FileName . '.wldep', $base);
                $base = str_replace("/sdcard/test.zip", "/sdcard/Android/data/com.wavelink.Velocity/files/" . $FileName, $base);
            }
            if ($AndroidVersion == "Android 10")
            {
                $base = str_replace("/sdcard/test.zip", "/sdcard/Android/data/com.wavelink.Velocity/files/" . $FileName, $base);
            }
            #$base = "4t:epq/sdcard/test.zipz|https://qr.netgetvpn.de/download.wldep";
            $encoded = base64_encode($base);
            $hex = "0101" . bin2hex($encoded);
    
            #print_r($hex);
    
            $strcode='';
            for ($i=0; $i < strlen($hex)-1; $i+=2)
            {
            $strcode .= chr(hexdec($hex[$i].$hex[$i+1]));
            }
            QRCode::png($strcode);
        }
        exit;
    }


    if(isset($_GET['content'])) {
        $Content = $_GET['content'];
        // outputs image directly into browser, as PNG stream
        //$Content = 'Read the documentation';

        $base = "YP50AAAAChcFAh8ACwAwACgA2AAAAJo6BQBlAXACcS9zZGNhcmQvSEVfRlVMTF9VUERBVEVfMDEtMzAtMDQuMDAtT0ctVTAwLVNURC56aXAAegF8aHR0cHM6Ly9kb3dubG9hZHMuemVicmEuY29tL2NvbnRlbnQvZGFtL3plYnJhX25ld19pYS9lbi11cy9zb2Z0d2FyZS9vcGVyYXRpbmctc3lzdGVtL2hlbGlvcy9IRV9GVUxMX1VQREFURV8xMC0xNi0xMC4wMC1RRy1VMDAtU1RELUhFTC0wNC56aXAAAAAKFwUCHwELADAAKADYAAAA/c8HAmUIZi9zZGNhcmQvSEVfRlVMTF9VUERBVEVfMDEtMzAtMDQuMDAtT0ctVTAwLVNURC56aXAA";
        $base = base64_decode($base);
    

        //$base = str_replace("/sdcard/test.zip", "/sdcard/com.wavelink.Velocity/" . $FileName . '.wldep', $base);
        $base = str_replace("https://downloads.zebra.com/content/dam/zebra_new_ia/en-us/software/operating-system/helios/HE_FULL_UPDATE_10-16-10.00-QG-U00-STD-HEL-04.zip", $Content, $base);


        #$base = "4t:epq/sdcard/test.zipz|https://qr.netgetvpn.de/download.wldep";
        $encoded = base64_encode($base);
        $hex = "0101" . bin2hex($encoded);

        #print_r($hex);

        $strcode='';
        for ($i=0; $i < strlen($hex)-1; $i+=2)
        {
        $strcode .= chr(hexdec($hex[$i].$hex[$i+1]));
        }
        QRCode::png($strcode);
    
    } 
    else {
        $Content = 'Read the documentation';
        QRCode::png($Content);
    }

?>
