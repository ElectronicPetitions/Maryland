<?PHP 
include_once('header.php'); 
slack_general('Not a registered voter ('.$_COOKIE['invite'].')','md-petition');
$qX = "select * from website_text where id = '3'";
$rX = $petition->query($qX);
$dX = mysqli_fetch_array($rX);?>
<script>document.title = "MEPS - How to Register?";</script>
<div class='row'>
 <div class='col-sm-10' style='text-align:center;'><h1><?PHP echo $dX['text_title'];?></h1><h2><?PHP echo $dX['text_block'];?></h2></div>
</div>
<div class='row'>
 <div class='col-sm-10' style='text-align:center;'><button type="button" class="btn btn-success btn-lg btn-block" onclick="window.location.href='https://voterservices.elections.maryland.gov/OnlineVoterRegistration/InstructionsStep1'">You Can Register Online Here</button></div>
</div>
<div class='row'>
 <div class='col-sm-10' style='text-align:center;'><h3>https://voterservices.elections.maryland.gov/OnlineVoterRegistration/InstructionsStep1</h3></div>
</div>
<?PHP include_once('footer.php');
