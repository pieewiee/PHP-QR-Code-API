<?php

    include('phpqrcode/qrlib.php');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $Content = file_get_contents('php://input');
    
        QRCode::png($Content);
        exit;
    }


    if(isset($_GET['content'])) {
        $Content = $_GET['content'];
        // outputs image directly into browser, as PNG stream
        QRCode::png($Content);
    } 
    else {
        $Content = 'Read the documentation';
        QRCode::png($Content);
    }

?>
