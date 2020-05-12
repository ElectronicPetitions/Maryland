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
$signed_name_as             = $_POST['signed_name_as'];
$date_of_birth              = $_COOKIE['pDOB'];
$signed_name_as_circulator  = $_POST['signed_name_as_circulator'];
$contact_phone              = $_COOKIE['pPHONE'];
$signature_status           = $_COOKIE['signature_status'];
$petition->query("insert into signatures (VTRID,ip_address,date_of_birth,date_time_signed,petition_id,signed_name_as,signed_name_as_circulator,contact_phone,signature_status) values ('$VTRID','$ip','$date_of_birth',NOW(),'$petition_id','$signed_name_as','$signed_name_as_circulator','$contact_phone','$signature_status')") or die(mysqli_error($petition));
header('Location: eligible.php');
