<?php
    // outputs image directly into browser, as PNG stream
    include('phpqrcode/qrlib.php');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $Content = file_get_contents('php://input');
        print_r($Content);
        #QRCode::png($Content);
        exit;
    }

    if(isset($_GET['content'])) {
        $Content = $_GET['content'];
        QRCode::png($Content);
    } 
    else {
        $Content = 'Read the documentation';
        QRCode::png($Content);
    }
?>
