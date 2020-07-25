<?php
include_once('/var/www/secure.php'); 
include_once('slack.php'); 
$id = intval($_GET['id']);
$q = "select * from signatures where id = '$id' ";
$r = $petition->query($q);
$d = mysqli_fetch_array($r);
$ip_address    = $d['ip_address'];
$DOB    = $d['date_of_birth'];
$SIGNED = $d['date_time_signed'];
$PETITION_ID = $d['petition_id'];
$VoterList_table = $d['VoterList_table'];
$signed_name_as = ucwords(strtolower($d['signed_name_as']));
$signed_name_as_circulator = ucwords(strtolower($d['signed_name_as_circulator']));
if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
    $ip = $_SERVER['REMOTE_ADDR'];
}
if ($ip != $d['ip_address']){
 slack_general('SECURITY INVALID: soft_copy.php '.$ip.' vs '.$d['ip_address'].' ('.$_COOKIE['invite'].')','md-petition');
 die('Error #294');
}

$q2 = "select * from $VoterList_table where VTRID = '$d[VTRID]' ";
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


$qX = "select * from petitions where petition_id = '$PETITION_ID'";
$rX = $petition->query($qX);
$dX = mysqli_fetch_array($rX);

$hide_county = $dX['hide_county_on_petition'];
$offset_x = $dX['offset_x_cords'];
$offset_y = $dX['offset_y_cords'];
$offset_x_circulator = $dX['offset_x_cords_circulator'];
$offset_y_circulator = $dX['offset_y_cords_circulator'];

// imagettftext ( resource $image , float $size , float $angle , int $x , int $y , int $color , string $fontfile , string $text ) 
// x how far from left
// y how far from top


//Set the Content Type
header('Content-type: image/jpeg');

// Create Image From Existing File -- going to have to make this a reqired size??? 2550x3300
$jpg_image = imagecreatefromjpeg($dX['petition_jpg']);

// Allocate A Color For The Text
$black = imagecolorallocate($jpg_image, 0, 0, 0);

// Set Path to Font File
$font_path = 'files/coolvetica rg.ttf';
$font_path_sig = 'files/Claston Script.ttf';

if ($hide_county == 'NO'){
 if ( $_COOKIE['pCOUNTY'] == 'Baltimore City'){
   // City Checkbox
   $cord = $dX['text_cord_cityX'];
   $array = explode(",",$cord);
   $debug = "$id : $cord : $array[0]";
   imagettftext($jpg_image, $array[0], $array[1], $array[2], $array[3], $black, $font_path, 'X');
 }else{
   // County on Petition
   $cord = $dX['text_cord_county'];
   $array = explode(",",$cord);
   imagettftext($jpg_image, $array[0], $array[1], $array[2], $array[3], $black, $font_path, str_replace('County','',$_COOKIE['pCOUNTY']) );
 }
}
// name
imagettftext($jpg_image, 50, 0, 350+$offset_x, 1070+$offset_y, $black, $font_path, $full_name);
// signed
imagettftext($jpg_image, 70, 0, 400+$offset_x, 1180+$offset_y, $black, $font_path_sig, $signed_name_as);
// address
imagettftext($jpg_image, 50, 0, 400+$offset_x, 1300+$offset_y, $black, $font_path, $address);

// date of birth 
if($DOB != ''){
 imagettftext($jpg_image, 50, 0, 1900+$offset_x, 1070+$offset_y, $black, $font_path, date('m     d     Y',strtotime($DOB)));
}
// date signed
imagettftext($jpg_image, 50, 0, 1900+$offset_x, 1200+$offset_y, $black, $font_path, date('m     d     Y',strtotime($SIGNED)));


// name
imagettftext($jpg_image, 40, 0, 100+$offset_x_circulator, 2880+$offset_y_circulator, $black, $font_path, $_COOKIE['pNAME']);
// address
imagettftext($jpg_image, 40, 0, 100+$offset_x_circulator, 2975+$offset_y_circulator, $black, $font_path, $_COOKIE['pADDRESS1']);
// city state zip
imagettftext($jpg_image, 40, 0, 100+$offset_x_circulator, 3065+$offset_y_circulator, $black, $font_path, $_COOKIE['pADDRESS2']);
// phone
imagettftext($jpg_image, 40, 0, 100+$offset_x_circulator, 3160+$offset_y_circulator, $black, $font_path, $_COOKIE['pPHONE']);
// signed
imagettftext($jpg_image, 70, 0, 1290+$offset_x_circulator, 3160+$offset_y_circulator, $black, $font_path_sig, $signed_name_as_circulator);
// date signed
imagettftext($jpg_image, 50, 0, 2150+$offset_x_circulator, 3160+$offset_y_circulator, $black, $font_path, date('m / d / y',strtotime($SIGNED)));



// Send Image to Browser
imagejpeg($jpg_image);

// Clear Memory
imagedestroy($jpg_image);
?>
