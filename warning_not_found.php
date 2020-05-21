<?PHP 
include_once('header.php');  
slack_general('Enter Information ('.$_COOKIE['invite'].')','md-petition');
$qX = "select * from website_text where id = '5'";
$rX = $petition->query($qX);
$dX = mysqli_fetch_array($rX);
?>
<script>document.title = "MEPS - Warning Not Found";</script>
<div class='row'>
 <div class='col-sm-10' style='text-align:center;'><h1><?PHP echo $dX['text_title'];?></h1></div>
</div>
<div class='row'>
 <div class='col-sm-10' style='text-align:center;'><h2><?PHP echo $dX['text_block'];?></h2></div>
</div>
<?PHP include_once('footer.php');
