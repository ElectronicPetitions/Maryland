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
$signed_name_as             = $petition->real_escape_string($_POST['signed_name_as']);
$date_of_birth              = $petition->real_escape_string($_COOKIE['pDOB']);
$signed_name_as_circulator  = $petition->real_escape_string($_POST['signed_name_as_circulator']);
$contact_phone              = $petition->real_escape_string($_COOKIE['pPHONE']);
$signature_status           = $petition->real_escape_string($_COOKIE['signature_status']);
$bot_check                  = $petition->real_escape_string($_SERVER['HTTP_USER_AGENT']);

$last = $_COOKIE['last'];
if ($last == '') {
    slack_general_admin("last petition cookie missing - directing to share",'md-petition-signed');
    header('Location: share.php');
}

include_once('header.php'); 
$qX = "select * from website_text where id = '9'";
$rX = $petition->query($qX);
$dX = mysqli_fetch_array($rX);
?>
<script>
    document.title = "MEPS - Petition Signed";
    alert("Petition Signed");
</script>
<div class='row'>
 <div class='col-sm-10' style='text-align:center;'><h1><?PHP echo $dX['text_title'];?></h1></div>
</div>
<div class='row'>
 <div class='col-sm-10' style='text-align:center;'><h2><?PHP echo $dX['text_block'];?></h2></div>
</div>
<div class='row'>
 <div class='col-sm-10' style='text-align:center;'><br><button type="button" class="btn btn-success btn-lg btn-block" onclick="window.open('printer.php?id=<?PHP echo $last;?>')">View and/or Print</button></div>
</div>
<div class='row'>
 <div class='col-sm-10' style='text-align:center;'><br><button type="button" class="btn btn-info btn-lg btn-block" onclick="window.location.href='eligible.php'">More Petitions</button></div>
</div>
<div class='row'>
 <div class='col-sm-10' style='text-align:center;'><br><button type="button" class="btn btn-danger btn-lg btn-block" onclick="window.location.href='reset.php'">Reset / Restart</button></div>
</div>
<?PHP 
include_once('footer.php');
