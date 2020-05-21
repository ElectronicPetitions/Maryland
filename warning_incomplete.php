<?PHP 
include_once('header.php');  
slack_general('warning_incomplete.php ('.$_COOKIE['invite'].')','md-petition');
$qX = "select * from website_text where id = '4'";
$rX = $petition->query($qX);
$dX = mysqli_fetch_array($rX);
?>
<script>document.title = "MEPS - Warning Incomplete";</script>
  <div class='col-sm-12' style='height:100px; text-align:center;'><h2><?PHP echo $dX['text_title'];?></h2></div>

  <div class='col-sm-12' style='height:100px; text-align:center;'>
    <?PHP echo $dX['text_block'];?>
  </div>

<?PHP include_once('footer.php');
