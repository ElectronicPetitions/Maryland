<?php
// imagettftext ( resource $image , float $size , float $angle , int $x , int $y , int $color , string $fontfile , string $text ) 
// x how far from left
// y how far from top


//Set the Content Type
header('Content-type: image/jpeg');

// Create Image From Existing File -- going to have to make this a reqired size??? 2550x3300
$jpg_image = imagecreatefromjpeg('files/Green-Party-petition-1-page-001.jpg');

// Allocate A Color For The Text
$black = imagecolorallocate($jpg_image, 0, 0, 0);

// Set Path to Font File
$font_path = 'files/coolvetica rg.ttf';
$font_path_sig = 'files/Claston Script.ttf';

if ( $_COOKIE['pCOUNTY'] == 'Baltimore City'){
  // City Checkbox
  imagettftext($jpg_image, 50, 0, 115, 365, $black, $font_path, 'X');
}else{
  // County on Petition
  imagettftext($jpg_image, 50, 0, 220, 260, $black, $font_path, $_COOKIE['pCOUNTY']);
}

// Slot 1 on Petition
// name
imagettftext($jpg_image, 50, 0, 350, 1070, $black, $font_path, $_COOKIE['pNAME']);
// signed
imagettftext($jpg_image, 80, 0, 400, 1190, $black, $font_path_sig, $_COOKIE['pNAME']);
// address
imagettftext($jpg_image, 50, 0, 400, 1300, $black, $font_path,  $_COOKIE['pADDRESS']);
// date of birth 
imagettftext($jpg_image, 50, 0, 1800, 1070, $black, $font_path, $_COOKIE['pDOB']);
// date signed
imagettftext($jpg_image, 50, 0, 1800, 1200, $black, $font_path, date('M D Y'));



// Send Image to Browser
imagejpeg($jpg_image);

// Clear Memory
imagedestroy($jpg_image);
?>
