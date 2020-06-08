<?PHP 
include_once('/var/www/secure.php'); 
include_once('slack.php');
$petition_id = $_COOKIE['pID'];
$VTRID = $_COOKIE['pVTRID'];
if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
    $ip = $_SERVER['REMOTE_ADDR'];
}
function id2petition($id){
  global $petition;
  $q = "select petition_name from petitions where petition_id = '$id'";
  $r = $petition->query($q);
  $d = mysqli_fetch_array($r,MYSQLI_ASSOC);
  return $d['petition_name'];
}
$signed_name_as             = $petition->real_escape_string($_POST['signed_name_as']);
$date_of_birth              = $petition->real_escape_string($_COOKIE['pDOB']);
$signed_name_as_circulator  = $petition->real_escape_string($_POST['signed_name_as_circulator']);
$contact_phone              = $petition->real_escape_string($_COOKIE['pPHONE']);
$signature_status           = $petition->real_escape_string($_COOKIE['signature_status']);
$bot_check                  = $petition->real_escape_string($_SERVER['HTTP_USER_AGENT']);
global $time_on_site;
if (empty($_COOKIE['start_time'])){
  setcookie("start_time", time());
  $time_on_site = 0;
}else{
  $now  = time();
  $time_on_site = $now - $_COOKIE['start_time']; 
}
$petition->query("insert into signatures (bot_check,VTRID,ip_address,date_of_birth,date_time_signed,just_date,petition_id,signed_name_as,signed_name_as_circulator,contact_phone,signature_status) values ('$bot_check','$VTRID','$ip','$date_of_birth',NOW(),NOW(),'$petition_id','$signed_name_as','$signed_name_as_circulator','$contact_phone','$signature_status')") or die(mysqli_error($petition));
if($petition_id == '' || $petition_id == '0'){
    slack_general_admin("MISSING petition_id",'md-petition-signed'); 
    echo "<h1>AN ERROR HAS OCCURED - PLEASE TRY AGAIN <a href='reset.php'>HERE</a></h1>";   
    die();  // do not clear invite!!! 
}
slack_general_admin("$signed_name_as ".id2petition($petition_id),'md-petition-signed');

$last = $petition->insert_id;
setcookie("last", $last);
setcookie("invite_used", $_COOKIE['invite']);
setcookie("invite", ""); // clear invite

$q="SELECT ip_address, petition_id,VTRID, COUNT(*) as count FROM signatures where signature_status = 'verified' group by ip_address, petition_id, VTRID";
$r = $petition->query($q);
while($d = mysqli_fetch_array($r)){
  if ($d['count'] > 1){
    $msg = "*ALERT* https://www.md-petition.com/admin/abuse.php $d[ip_address] $d[VTRID] ".id2petition($d['petition_id'])." *$d[count]*"; 
    slack_general_admin($msg,'md-petition-signed');
  }
}
header('Location: sign.php');

?>
