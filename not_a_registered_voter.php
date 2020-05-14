<?PHP include_once('header.php'); 
$qX = "select * from website_text where id = '3'";
 $rX = $petition->query($qX);
 $dX = mysqli_fetch_array($rX);?>
<script>document.title = "MEPS - How to Register?";</script>
<div class='col-sm-12' style='height:75px; text-align:center;'><h3><?PHP echo $dX['text_title'];?></h3><p><?PHP echo $dX['text_block'];?></p></div>

<div class='col-sm-12' style='height:50px; text-align:center;'><button type="button" class="btn btn-success" onclick="window.location.href='https://voterservices.elections.maryland.gov/OnlineVoterRegistration/InstructionsStep1'">You Can Register Online Here</button></div>

<div class='col-sm-12' style='height:50px; text-align:center;'><small>https://voterservices.elections.maryland.gov/OnlineVoterRegistration/InstructionsStep1</small></div>

<?PHP include_once('footer.php');
