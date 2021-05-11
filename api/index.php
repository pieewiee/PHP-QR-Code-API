<?php

    include('phpqrcode/qrlib.php');
    if(isset($_GET['content'])) {
        $Content = $_GET['content'];
    } else {
        $Content = 'Read the documentation';
    }
    // outputs image directly into browser, as PNG stream
    QRCode::png($Content);

?>