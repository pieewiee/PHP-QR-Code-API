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
        $FileContent =  base64_decode($obj->{'content'});
        $method =  $obj->{'method'};
        $AndroidVersion =  $obj->{'Version'};

    
        if ($method == "install")
        {
            $NewFileName = generateRandomString(64) . ".wldep";
            file_put_contents($NewFileName, $FileContent);
            $base = "NJ50AAAAmjoFAGUBcAJxL3NkY2FyZC90ZXN0LnppcAB6AXxodHRwczovL3FyLm5ldGdldHZwbi5kZS9kb3dubG9hZC53bGRlcAA=";
            $base = base64_decode($base);
            
        
            if ($AndroidVersion == "Android 8")
            {
                $base = str_replace("/sdcard/test.zip", "/sdcard/Android/data/com.wavelink.Velocity/files/" . $FileName . '.wldep', $base);
            }
            if ($AndroidVersion == "Android 10")
            {
                $base = str_replace("/sdcard/test.zip", "/sdcard/Android/data/com.wavelink.Velocity/files/" . $FileName . '.wldep', $base);
            }
            
            $base = str_replace("https://qr.netgetvpn.de/download.wldep", "https://qr.netgetvpn.de/" . $NewFileName, $base);
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
        if ($method == "remove")
        {

            $base = "LL50AAAAmjoFAGUEhC9zZGNhcmQvdGVzdC56aXAA";
            $base = base64_decode($base);
        
            if ($AndroidVersion == "Android 8")
            {
                //$base = str_replace("/sdcard/test.zip", "/sdcard/com.wavelink.Velocity/" . $FileName . '.wldep', $base);
                $base = str_replace("/sdcard/test.zip", "/sdcard/Android/data/com.wavelink.Velocity/files/" . $FileName . '.wldep', $base);
            }
            if ($AndroidVersion == "Android 10")
            {
                $base = str_replace("/sdcard/test.zip", "/sdcard/Android/data/com.wavelink.Velocity/files/" . $FileName . '.wldep', $base);
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
        $Content = 'Read the documentation';
        QRCode::png($Content);
    } 
    else {
        $Content = 'Read the documentation';
        QRCode::png($Content);
    }

?>
