<?php

    include('phpqrcode/qrlib.php');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $Content = file_get_contents('php://input');
<<<<<<< HEAD:docker/api/index.php
    
        QRCode::png($Content);
=======
        print_r($Content);
        #QRCode::png($Content);
>>>>>>> parent of 8332461 (Update index.php):api/index.php
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
