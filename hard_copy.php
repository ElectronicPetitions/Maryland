<?php
//Set the Content Type
header('Content-type: image/jpeg');

// Create Image From Existing File
$jpg_image = imagecreatefromjpeg('files/Green-Party-petition-1-page-001.jpg');

// Allocate A Color For The Text
$white = imagecolorallocate($jpg_image, 255, 255, 255);

// Set Path to Font File
$font_path = 'files/coolvetica rg.ttf';

// Set Text to Be Printed On Image
$text = "Sign My Name";

// Print Text On Image
imagettftext($jpg_image, 25, 0, 75, 300, $white, $font_path, $text);

// Send Image to Browser
imagejpeg($jpg_image);

// Clear Memory
imagedestroy($jpg_image);
?>
