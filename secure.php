<?PHP
// Fill out and store This file in the directory outside webroot 
$host = '';
$user = '';
$pass = '';
$db_name = '';
$core = mysqli_connect($host,$user,$pass,$db_name) or die("Error " . mysqli_error($core));
global $twillo_account;
global $twillo_key;
$twillo_key = '';
$twillo_account = '';
global $arcgis_key;
$arcgis_key = '';
