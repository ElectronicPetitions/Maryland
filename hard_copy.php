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




// County on Petition
imagettftext($jpg_image, 50, 0, 220, 260, $black, $font_path, 'Baltimore');
// OR
// City Checkbox
imagettftext($jpg_image, 50, 0, 115, 365, $black, $font_path, 'X');

// Slot 1 on Petition
// name
imagettftext($jpg_image, 50, 0, 350, 1050, $black, $font_path, 'Patrick Michael McGuire');
// address
imagettftext($jpg_image, 50, 0, 350, 1350, $black, $font_path, '501 Spring Ave Lutherville 21093');
// date of birth
imagettftext($jpg_image, 50, 0, 1800, 1050, $black, $font_path, '02 09 1980');
// date signed
imagettftext($jpg_image, 50, 0, 1800, 1250, $black, $font_path, '05 07 2020');



// Send Image to Browser
imagejpeg($jpg_image);

// Clear Memory
imagedestroy($jpg_image);
?>
