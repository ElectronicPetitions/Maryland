<?php
// imagettftext ( resource $image , float $size , float $angle , int $x , int $y , int $color , string $fontfile , string $text ) 
// x how far from left
// y how far from top
include_once('/var/www/secure.php'); 
$id = $_COOKIE['pID'];
$q = "select * from petitions where petition_id = '$id'";
$r = $petition->query($q);
$d = mysqli_fetch_array($r);
$hide_county = $d['hide_county_on_petition'];
$offset_x = $d['offset_x_cords'];
$offset_y = $d['offset_y_cords'];
$offset_x_circulator = $d['offset_x_cords_circulator'];
$offset_y_circulator = $d['offset_y_cords_circulator'];

  $petition_party_line1 = $d['petition_party_line1'];
  $petition_party_line2 = $d['petition_party_line2'];
  $petition_party_line3 = $d['petition_party_line3'];
  $petition_party_line4 = $d['petition_party_line4'];


// For unverified petitions we need to rebuild the data
// trim the cookie, test and then build with web form data

$county = $_COOKIE['pCOUNTY'];
if (trim($_COOKIE['pCOUNTY']) == ''){
  $county = ucwords($_COOKIE['web_county']);
}

$name = $_COOKIE['pNAME'];
if (trim($_COOKIE['pNAME']) == ''){
 $name = strtoupper($_COOKIE['web_first_name'].' '.$_COOKIE['web_middle_name'].' '.$_COOKIE['web_last_name']);
}

// street address
$address1 = $_COOKIE['pADDRESS1'];
if (trim($_COOKIE['pADDRESS1']) == ''){
  $address1 = strtoupper($_COOKIE['web_house_number'].' '.$_COOKIE['web_street_name']);
}
// city state zip
$address2 = $_COOKIE['pADDRESS2'];
if (trim($_COOKIE['pADDRESS2']) == 'MD'){
  $address2 = strtoupper($_COOKIE['web_city']).', MD '.$_COOKIE['web_zip_code'];
}  
$full_address = $_COOKIE['pADDRESS'];
if (trim($_COOKIE['pADDRESS']) == ''){
  $full_address = $address1.' '.$address2;
}
$phone = $_COOKIE['pPHONE'];

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

if ($hide_county == 'NO'){
  if ( $county == 'Baltimore City' || $_COOKIE['debug'] == 'on'){
    // City Checkbox
    $cord = $d['text_cord_cityX'];
    $array = explode(",",$cord);
    $debug = "$id : $cord : $array[0]";
    imagettftext($jpg_image, $array[0], $array[1], $array[2], $array[3], $black, $font_path, 'X');
  }else{
    // County on Petition
    $cord = $d['text_cord_county'];
    $array = explode(",",$cord);
    imagettftext($jpg_image, $array[0], $array[1], $array[2], $array[3], $black, $font_path, str_replace('County','',$county) );
  }
}

// Party Information
imagettftext($jpg_image, 50, 0, 200, 580, $black, $font_path, $petition_party_line1 );
imagettftext($jpg_image, 50, 0, 700, 700, $black, $font_path, $petition_party_line2 );
imagettftext($jpg_image, 50, 0, 340, 790, $black, $font_path, $petition_party_line3 );
imagettftext($jpg_image, 50, 0, 340, 870, $black, $font_path, $petition_party_line4 );



// name
imagettftext($jpg_image, 50, 0, 350+$offset_x, 1070+$offset_y, $black, $font_path, $name);
//imagettftext($jpg_image, 50, 0, 350, 1070, $black, $font_path, $debug);

// address
imagettftext($jpg_image, 50, 0, 400+$offset_x, 1300+$offset_y, $black, $font_path,  $full_address);
// date of birth 
if($DOB != ''){
 imagettftext($jpg_image, 50, 0, 1900+$offset_x, 1070+$offset_y, $black, $font_path, date('m     d     Y',strtotime($DOB)));
}
// date signed
//imagettftext($jpg_image, 50, 0, 1900, 1200, $black, $font_path, date('m     d     Y',strtotime($SIGNED)));


// name
imagettftext($jpg_image, 40, 0, 100+$offset_x_circulator, 2880+$offset_y_circulator, $black, $font_path, $name);
// address
imagettftext($jpg_image, 40, 0, 100+$offset_x_circulator, 2975+$offset_y_circulator, $black, $font_path, $address1);
// city state zip
imagettftext($jpg_image, 40, 0, 100+$offset_x_circulator, 3065+$offset_y_circulator, $black, $font_path, $address2);
// phone
imagettftext($jpg_image, 40, 0, 100+$offset_x_circulator, 3160+$offset_y_circulator, $black, $font_path, $phone);

// date signed
//imagettftext($jpg_image, 40, 0, 2150, 3150, $black, $font_path, date('m / d / y',strtotime($SIGNED)));


// Send Image to Browser
imagejpeg($jpg_image);

// Clear Memory
imagedestroy($jpg_image);





?>
