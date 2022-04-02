<?php

    include('phpqrcode/qrlib.php');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $Content = file_get_contents('php://input');
        
        $searchSSID = '/"android.app.extra.PROVISIONING_WIFI_SSID":".*",/i';
        $searchpassword = '/"android.app.extra.PROVISIONING_WIFI_PASSWORD":".*",/i';
        $searchSecType = '/"android.app.extra.PROVISIONING_WIFI_SECURITY_TYPE":".*",/i';
        $searchWifiHidden = '/"android.app.extra.PROVISIONING_WIFI_HIDDEN":".*",/i';
        $replace = '';
        $Content = preg_replace($searchSSID, $replace, $Content);
        $Content = preg_replace($searchpassword, $replace, $Content);
        $Content = preg_replace($searchSecType, $replace, $Content);
        $Content = preg_replace($searchWifiHidden, $replace, $Content);
        // outputs image directly into browser, as PNG stream

        QRCode::png($Content);
        exit;
    }


    if(isset($_GET['content'])) {
        $Content = $_GET['content'];
        // outputs image directly into browser, as PNG stream

        $searchSSID = '/"android.app.extra.PROVISIONING_WIFI_SSID":".*",/i';
        $searchpassword = '/"android.app.extra.PROVISIONING_WIFI_PASSWORD":".*",/i';
        $searchSecType = '/"android.app.extra.PROVISIONING_WIFI_SECURITY_TYPE":".*",/i';
        $searchWifiHidden = '/"android.app.extra.PROVISIONING_WIFI_HIDDEN":".*",/i';
        $replace = '';
        $Content = preg_replace($searchSSID, $replace, $Content);
        $Content = preg_replace($searchpassword, $replace, $Content);
        $Content = preg_replace($searchSecType, $replace, $Content);
        $Content = preg_replace($searchWifiHidden, $replace, $Content);

        QRCode::png($Content);
    } 
    else {
        $Content = 'Read the documentation';
        QRCode::png($Content);
    }

?>
