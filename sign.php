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
$signed_name_as             = $petition->real_escape_string($_POST['signed_name_as']);
$date_of_birth              = $petition->real_escape_string($_COOKIE['pDOB']);
$signed_name_as_circulator  = $petition->real_escape_string($_POST['signed_name_as_circulator']);
$contact_phone              = $petition->real_escape_string($_COOKIE['pPHONE']);
$signature_status           = $petition->real_escape_string($_COOKIE['signature_status']);

$petition->query("insert into signatures (VTRID,ip_address,date_of_birth,date_time_signed,petition_id,signed_name_as,signed_name_as_circulator,contact_phone,signature_status) values ('$VTRID','$ip','$date_of_birth',NOW(),'$petition_id','$signed_name_as','$signed_name_as_circulator','$contact_phone','$signature_status')") or die(mysqli_error($petition));
$last = $petition->insert_id;
setcookie("invite_used", $_COOKIE['invite']);
setcookie("invite", ""); // clear invite
//header('Location: eligible.php');
include_once('header.php'); 
slack_general('Warning Not Found ('.$_COOKIE['invite'].')','md-petition');
$qX = "select * from website_text where id = '9'";
$rX = $petition->query($qX);
$dX = mysqli_fetch_array($rX);
?>
<script>document.title = "MEPS - Petition Signed";</script>
<div class='row'>
 <div class='col-sm-10' style='text-align:center;'><h1><?PHP echo $dX['text_title'];?></h1></div>
</div>
<div class='row'>
 <div class='col-sm-10' style='text-align:center;'><h2><?PHP echo $dX['text_block'];?></h2></div>
</div>
<div class='row'>
 <div class='col-sm-10' style='text-align:center;'><button type="button" class="btn btn-success btn-lg btn-block" onclick="window.open('soft_copy.php?id=<?PHP echo $last;?>')">View and/or Print</button></div>
</div>
<div class='row'>
 <div class='col-sm-10' style='text-align:center;'><button type="button" class="btn btn-info btn-lg btn-block" onclick="window.location.href='elegible.php'">More Petitions</button></div>
</div>
<div class='row'>
 <div class='col-sm-10' style='text-align:center;'><button type="button" class="btn btn-danger btn-lg btn-block" onclick="window.location.href='reset.php'">Reset / Restart</button></div>
</div>
<?PHP 
include_once('footer.php');
