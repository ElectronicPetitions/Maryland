<?php
// imagettftext ( resource $image , float $size , float $angle , int $x , int $y , int $color , string $fontfile , string $text ) 
// x how far from left
// y how far from top
include_once('/var/www/secure.php'); 
$id = $_COOKIE['pID'];
$q = "select * from petitions where id = '$id'";
$r = $petition->query($q);
$d = mysqli_fetch_array($r);

//Set the Content Type
header('Content-type: image/jpeg');

// Create Image From Existing File -- going to have to make this a reqired size??? 2550x3300
$JPG = $_COOKIE['pJPG'];
$jpg_image = imagecreatefromjpeg($JPG);

// Allocate A Color For The Text
$black = imagecolorallocate($jpg_image, 0, 0, 0);

// Set Path to Font File
$font_path = 'files/coolvetica rg.ttf';
$font_path_sig = 'files/Claston Script.ttf';


$DOB = $_COOKIE['pDOB'];
$SIGNED = date('Y-m-d');

//if ( $_COOKIE['pCOUNTY'] == 'Baltimore City'){
  // City Checkbox
  $cord = $d['text_cord_cityX'];
  $array = explode(",",$cord);
  $debug = "$id : $cord : $array[0]";
  imagettftext($jpg_image, $array[0], $array[1], $array[2], $array[3], $black, $font_path, 'X');
//}else{
  // County on Petition
  $cord = $d['text_cord_county'];
  $array = explode(",",$cord);
  imagettftext($jpg_image, $array[0], $array[1], $array[2], $array[3], $black, $font_path, str_replace('County','',$_COOKIE['pCOUNTY']) );
//}

// name
//imagettftext($jpg_image, 50, 0, 350, 1070, $black, $font_path, $_COOKIE['pNAME']);
imagettftext($jpg_image, 50, 0, 350, 1070, $black, $font_path, $debug);

// address
imagettftext($jpg_image, 50, 0, 400, 1300, $black, $font_path,  $_COOKIE['pADDRESS']);
// date of birth 
if($DOB != ''){
 imagettftext($jpg_image, 50, 0, 1900, 1070, $black, $font_path, date('m     d     Y',strtotime($DOB)));
}
// date signed
//imagettftext($jpg_image, 50, 0, 1900, 1200, $black, $font_path, date('m     d     Y',strtotime($SIGNED)));


// name
imagettftext($jpg_image, 40, 0, 100, 2880, $black, $font_path, $_COOKIE['pNAME']);
// address
imagettftext($jpg_image, 40, 0, 100, 2975, $black, $font_path, $_COOKIE['pADDRESS1']);
// city state zip
imagettftext($jpg_image, 40, 0, 100, 3065, $black, $font_path, $_COOKIE['pADDRESS2']);
// phone
imagettftext($jpg_image, 40, 0, 100, 3160, $black, $font_path, $_COOKIE['pPHONE']);

// date signed
//imagettftext($jpg_image, 40, 0, 2150, 3150, $black, $font_path, date('m / d / y',strtotime($SIGNED)));


// Send Image to Browser
imagejpeg($jpg_image);

// Clear Memory
imagedestroy($jpg_image);
?>
