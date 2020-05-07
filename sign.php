<?PHP 
include_once('/var/www/secure.php'); 
$petition_id = $_COOKIE['pID'];
$VTRID = $_COOKIE['pVTRID'];
if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
    $ip = $_SERVER['REMOTE_ADDR'];
}
$date_of_birth = $_COOKIE['pDOB'];
$petition->query("insert into signatures (VTRID,ip_address,date_of_birth,date_time_signed,petition_id) values ('$VTRID','$ip','$date_of_birth',NOW(),'$petition_id')");
header('Location: eligible.php');
