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
  imagettftext($jpg_image, 50, 0, 220, 260, $black, $font_path, str_replace('County','',$_COOKIE['pCOUNTY']) );
}

// name
imagettftext($jpg_image, 50, 0, 350, 1070, $black, $font_path, $_COOKIE['pNAME']);

// address
imagettftext($jpg_image, 50, 0, 400, 1300, $black, $font_path,  $_COOKIE['pADDRESS']);
// date of birth 
if($DOB != ''){
 imagettftext($jpg_image, 50, 0, 1900, 1070, $black, $font_path, date('m     d     Y',strtotime($DOB)));
}
// date signed
imagettftext($jpg_image, 50, 0, 1900, 1200, $black, $font_path, date('m     d     Y',strtotime($SIGNED)));


// name
imagettftext($jpg_image, 40, 0, 50, 3050, $black, $font_path_sig, $signed_name_as);
// address
imagettftext($jpg_image, 40, 0, 50, 3100, $black, $font_path_sig, $ADDRESS);
// city state zip
imagettftext($jpg_image, 40, 0, 50, 3120, $black, $font_path_sig, "$RESIDENTIALCITY MD $RESIDENTIALZIP5");
// phone
imagettftext($jpg_image, 40, 0, 50, 3150, $black, $font_path_sig, '111-222-3333');
// signed
imagettftext($jpg_image, 40, 0, 1290, 3150, $black, $font_path_sig, $signed_name_as);
// date signed
imagettftext($jpg_image, 40, 0, 2150, 3150, $black, $font_path, date('m / d / y',strtotime($SIGNED)));


// Send Image to Browser
imagejpeg($jpg_image);

// Clear Memory
imagedestroy($jpg_image);
?>
