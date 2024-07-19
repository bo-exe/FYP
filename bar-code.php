<?php
require 'vendor/autoload.php';

use Zend\Barcode\Barcode;

function generateBarcode($barcodeText, $barcodeFilePath)
{
    // Generate barcode
    $barcodeOptions = ['text' => $barcodeText, 'barcode' => 'code128'];
    $rendererOptions = [];

    // Create barcode image
    $barcodeImage = Barcode::factory('code128', 'image', $barcodeOptions, $rendererOptions)->draw();

    // Save barcode image to file
    imagepng($barcodeImage, $barcodeFilePath);
    imagedestroy($barcodeImage);
    echo "Barcode image saved to $barcodeFilePath";
}

// Example usage
$barcodeText = '1234567890';
$barcodeFilePath = 'barcode.png';
generateBarcode($barcodeText, $barcodeFilePath);
?>