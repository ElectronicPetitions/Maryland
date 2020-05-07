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
imagettftext($jpg_image, 50, 0, 150, 220, $black, $font_path, 'Baltimore');
// OR
// City Checkbox
imagettftext($jpg_image, 40, 0, 85, 350, $black, $font_path, 'X');





// Send Image to Browser
imagejpeg($jpg_image);

// Clear Memory
imagedestroy($jpg_image);
?>
