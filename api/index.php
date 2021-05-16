<?php

    include('phpqrcode/qrlib.php');
    if(isset($_GET['content'])) {
        $Content = $_GET['content'];
        // outputs image directly into browser, as PNG stream
        QRCode::png($Content);
    } 

    if(isset($_POST["content"])) {
        // outputs image directly into browser, as PNG stream
        QRCode::png($Content);
    }
    
    elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        print_r($_POST["content"]);
    }
    else {
        $Content = 'Read the documentation';
        QRCode::png($Content);
    }



?>


$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, TRUE); //convert JSON into array