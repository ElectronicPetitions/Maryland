<?php
include_once('/var/www/secure.php'); 

$id = $_GET['id'];
$q = "select * from signatures where id = '$id' ";
$r = $petition->query($q);
$d = mysqli_fetch_array($r);

$DOB    = $d['date_of_birth'];
$SIGNED = $d['date_time_signed'];
$PETITION_ID = $d['petition_id'];
$signed_name_as = $d['signed_name_as'];

if ($_COOKIE['pVTRID'] != $d['VTRID']){
 die('Error #294');
}

$q2 = "select * from VoterList where VTRID = '$d[VTRID]' ";
$r2 = $petition->query($q2);
$d2 = mysqli_fetch_array($r2);
 $FIRSTNAME         = $d2['FIRSTNAME'];
 $MIDDLENAME        = $d2['MIDDLENAME'];
 $LASTNAME          = $d2['LASTNAME'];
 $ADDRESS           = $d2['ADDRESS'];
 $RESIDENTIALCITY   = $d2['RESIDENTIALCITY'];
 $COUNTY            = $d2['COUNTY'];
 $RESIDENTIALZIP5   = $d2['RESIDENTIALZIP5'];
 $full_name         = "$FIRSTNAME $MIDDLENAME $LASTNAME";
 $address           = "$ADDRESS $RESIDENTIALCITY $RESIDENTIALZIP5";
 
$contact_phone            = $d2['contact_phone'];

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

if ( $COUNTY == 'Baltimore City'){
  // City Checkbox
  imagettftext($jpg_image, 50, 0, 115, 365, $black, $font_path, 'X');
}else{
  // County on Petition
  imagettftext($jpg_image, 50, 0, 220, 260, $black, $font_path, str_replace('County','',$COUNTY) );
}

// name
imagettftext($jpg_image, 50, 0, 350, 1070, $black, $font_path, $full_name);
// signed
imagettftext($jpg_image, 70, 0, 400, 1180, $black, $font_path_sig, $signed_name_as);
// address
imagettftext($jpg_image, 50, 0, 400, 1300, $black, $font_path, $address);

// date of birth 
if($DOB != ''){
 imagettftext($jpg_image, 50, 0, 1900, 1070, $black, $font_path, date('m     d     Y',strtotime($DOB)));
}
// date signed
imagettftext($jpg_image, 50, 0, 1900, 1200, $black, $font_path, date('m     d     Y',strtotime($SIGNED)));


// name
imagettftext($jpg_image, 40, 0, 100, 2880, $black, $font_path, $_COOKIE['pNAME']);
// address
imagettftext($jpg_image, 40, 0, 100, 2975, $black, $font_path, $_COOKIE['pADDRESS1']);
// city state zip
imagettftext($jpg_image, 40, 0, 100, 3065, $black, $font_path, $_COOKIE['pADDRESS2']);
// phone
imagettftext($jpg_image, 40, 0, 100, 3160, $black, $font_path, $_COOKIE['pPHONE']);
// signed
imagettftext($jpg_image, 70, 0, 1290, 3160, $black, $font_path_sig, $signed_name_as);
// date signed
imagettftext($jpg_image, 50, 0, 2150, 3160, $black, $font_path, date('m / d / y',strtotime($SIGNED)));



// Send Image to Browser
imagejpeg($jpg_image);

// Clear Memory
imagedestroy($jpg_image);
?>
