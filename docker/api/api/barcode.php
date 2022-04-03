<?php


require 'vendor/autoload.php';
header('Content-type:image/png');


use jucksearm\barcode\Barcode;
use jucksearm\barcode\QRcode;
use jucksearm\barcode\Datamatrix;
use jucksearm\barcode\PDF417;

if(isset($_GET['content'])&& isset($_GET['type'])) {

    $string = file_get_contents("settings.json");
    $settings = json_decode($string, true);

    $scale = 4;
    $height = 150;
    $rotate = 0;
    $Codecolor = "000000";

    $D2size = "100";
    $D2level = "L";
    $D2margin = "1";
    if (isset($_GET['scale']) && is_numeric($_GET['scale'])) {
        $scale = intval($_GET['scale']);
    }
    if (isset($_GET['height']) && is_numeric($_GET['height'])) {
        $height = intval($_GET['height']);
    }
    if (isset($_GET['rotate']) && is_numeric($_GET['rotate'])) {
        $rotate = intval($_GET['rotate']);
    }
    if (isset($_GET['size']) && is_numeric($_GET['size'])) {
        $D2size = intval($_GET['size']);
    }
    if (isset($_GET['margin']) && is_numeric($_GET['margin'])) {
        $D2margin = intval($_GET['margin']);
    }
    if (isset($_GET['level'])) {
        $D2level = $_GET['level'];
    }
    if (isset($_GET['color'])) {
        $Codecolor = $_GET['color'];
    }

    $Content = $_GET['content'];
    $type = $_GET['type'];


    foreach ($settings["values"] as $key => $value) {
        if($value["codeType"] == $type)
        {
            if($type == "QRcode")
            {
                QRcode::png($Content, $emblem = null, $file = null, $level = $D2level, $size = $D2size, $margin = $D2margin, $color = $Codecolor);
                exit;
            }
        
            if($type == "Datamatrix")
            {
                Datamatrix::png($Content, $file = null, $size = $D2size, $margin = $D2margin, $color = $Codecolor);
                exit;
            }
        
            if($type == "PDF417")
            {
                PDF417::png($Content, $file = null, $size = $D2size, $margin = $D2margin, $color = $Codecolor);
                exit;
            }

        }
    }

    foreach ($settings["values"] as $key => $value) {
        if($value["value"] == $type)
        {

            Barcode::factory()
            ->setCode($Content)
            ->setType($type)
            ->setScale($scale)
            ->setHeight($height)
            ->setRotate($rotate)
            ->setColor($Codecolor)
            ->renderPNG();
            exit;

        }
    }





}

exit;


if(isset($_GET['content'])&& isset($_GET['type'])) {

    $widthFactor = 4;
    $height = 150;
    $color = [0, 0, 0];
    if (isset($_GET['widthFactor']) && is_numeric($_GET['widthFactor'])) {
        $widthFactor = intval($_GET['widthFactor']);
    }
    if (isset($_GET['height']) && is_numeric($_GET['height'])) {
        $height = intval($_GET['height']);
    }
    if (isset($_GET['color'])) {
        $color = $_GET['color'];
        try {
            $color = explode(",", $color);
            if (count($color) == 3) {
                foreach ($color as $key => $value) {
                    if (intval($value) >= 0 AND intval($value) <= 255) {
                    }
                    else{
                        $color = [0, 0, 0];
                    }
                }
            }
            else{
                $color = [0, 0, 0];
            }
        } catch (\Throwable $th) {
            $color = [0, 0, 0];
        }
    }

    $Content = $_GET['content'];
    $type = $_GET['type'];
    

    if($type == "TYPE_CODE_39")
    {
        $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
        echo $generator->getBarcode($Content, $generator::TYPE_CODE_39, $widthFactor, $height, $color);
    }    
    if($type == "TYPE_CODE_39_CHECKSUM")
    {
        $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
        echo $generator->getBarcode($Content, $generator::TYPE_CODE_39_CHECKSUM, $widthFactor, $height, $color);
    }    
    if($type == "TYPE_CODE_39E")
    {
        $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
        echo $generator->getBarcode($Content, $generator::TYPE_CODE_39E, $widthFactor, $height, $color);
    }    
    if($type == "TYPE_CODE_39E_CHECKSUM")
    {
        $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
        echo $generator->getBarcode($Content, $generator::TYPE_CODE_39E_CHECKSUM, $widthFactor, $height, $color);
    }    
    if($type == "TYPE_CODE_93")
    {
        $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
        echo $generator->getBarcode($Content, $generator::TYPE_CODE_93, $widthFactor, $height, $color);
    }    
    if($type == "TYPE_STANDARD_2_5")
    {
        $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
        echo $generator->getBarcode($Content, $generator::TYPE_STANDARD_2_5, $widthFactor, $height, $color);
    }    
    if($type == "TYPE_STANDARD_2_5_CHECKSUM")
    {
        $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
        echo $generator->getBarcode($Content, $generator::TYPE_STANDARD_2_5_CHECKSUM, $widthFactor, $height, $color);
    }    
    if($type == "TYPE_INTERLEAVED_2_5")
    {
        $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
        echo $generator->getBarcode($Content, $generator::TYPE_INTERLEAVED_2_5, $widthFactor, $height, $color);
    }    
    if($type == "TYPE_INTERLEAVED_2_5_CHECKSUM")
    {
        $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
        echo $generator->getBarcode($Content, $generator::TYPE_INTERLEAVED_2_5_CHECKSUM, $widthFactor, $height, $color);
    }    
    if($type == "TYPE_CODE_128")
    {
        $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
        echo $generator->getBarcode($Content, $generator::TYPE_CODE_128, $widthFactor, $height, $color);
    }    
    if($type == "TYPE_CODE_128_A")
    {
        $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
        echo $generator->getBarcode($Content, $generator::TYPE_CODE_128_A, $widthFactor, $height, $color);
    }    
    if($type == "TYPE_CODE_128_B")
    {
        $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
        echo $generator->getBarcode($Content, $generator::TYPE_CODE_128_B, $widthFactor, $height, $color);
    }    
    if($type == "TYPE_CODE_128_C")
    {
        $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
        echo $generator->getBarcode($Content, $generator::TYPE_CODE_128_C, $widthFactor, $height, $color);
    }    
    if($type == "TYPE_EAN_2")
    {
        $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
        echo $generator->getBarcode($Content, $generator::TYPE_EAN_2, $widthFactor, $height, $color);
    }    
    if($type == "TYPE_EAN_5")
    {
        $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
        echo $generator->getBarcode($Content, $generator::TYPE_EAN_5, $widthFactor, $height, $color);
    }    
    if($type == "TYPE_EAN_8")
    {
        $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
        echo $generator->getBarcode($Content, $generator::TYPE_EAN_8, $widthFactor, $height, $color);
    }    
    if($type == "TYPE_EAN_13")
    {
        $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
        echo $generator->getBarcode($Content, $generator::TYPE_EAN_13, $widthFactor, $height, $color);
    }    
    if($type == "TYPE_UPC_A")
    {
        $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
        echo $generator->getBarcode($Content, $generator::TYPE_UPC_A, $widthFactor, $height, $color);
    }    
    if($type == "TYPE_UPC_E")
    {
        $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
        echo $generator->getBarcode($Content, $generator::TYPE_UPC_E, $widthFactor, $height, $color);
    }    
    if($type == "TYPE_MSI")
    {
        $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
        echo $generator->getBarcode($Content, $generator::TYPE_MSI, $widthFactor, $height, $color);
    }    
    if($type == "TYPE_MSI_CHECKSUM")
    {
        $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
        echo $generator->getBarcode($Content, $generator::TYPE_MSI_CHECKSUM, $widthFactor, $height, $color);
    }    
    if($type == "TYPE_POSTNET")
    {
        $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
        echo $generator->getBarcode($Content, $generator::TYPE_POSTNET, $widthFactor, $height, $color);
    }    
    if($type == "TYPE_PLANET")
    {
        $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
        echo $generator->getBarcode($Content, $generator::TYPE_PLANET, $widthFactor, $height, $color);
    }    
    if($type == "TYPE_RMS4CC")
    {
        $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
        echo $generator->getBarcode($Content, $generator::TYPE_RMS4CC, $widthFactor, $height, $color);
    }    
    if($type == "TYPE_KIX")
    {
        $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
        echo $generator->getBarcode($Content, $generator::TYPE_KIX, $widthFactor, $height, $color);
    }    
    if($type == "TYPE_IMB")
    {
        $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
        echo $generator->getBarcode($Content, $generator::TYPE_IMB, $widthFactor, $height, $color);
    }    
    if($type == "TYPE_CODABAR")
    {
        $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
        echo $generator->getBarcode($Content, $generator::TYPE_CODABAR, $widthFactor, $height, $color);
    }    
    if($type == "TYPE_CODE_11")
    {
        $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
        echo $generator->getBarcode($Content, $generator::TYPE_CODE_11, $widthFactor, $height, $color);
    }    
    if($type == "TYPE_PHARMA_CODE")
    {
        $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
        echo $generator->getBarcode($Content, $generator::TYPE_PHARMA_CODE, $widthFactor, $height, $color);
    }    
    if($type == "TYPE_PHARMA_CODE_TWO_TRACKS")
    {
        $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
        echo $generator->getBarcode($Content, $generator::TYPE_PHARMA_CODE_TWO_TRACKS, $widthFactor, $height, $color);
    }

} 


?>
