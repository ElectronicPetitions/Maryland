<?PHP 
if (isset($_GET['invite'])){
  setcookie("invite", $_GET['invite']);
  header('Location: index.php');
}
$title = 'MEPS - Are you Registered?';
if ($_COOKIE['invite'] != ''){
 $title = 'MEPS ('.strtoupper($_COOKIE['invite']).') - Are you Registered?'; 
}
include_once('header.php');
slack_general('Home Page Loaded','md-petition');
 $q = "select * from website_text where id = '1'";
 $r = $petition->query($q);
 $d = mysqli_fetch_array($r);
?>
  <script>document.title = "<?PHP echo $title;?>";</script>
  <div class='col-sm-12' style='height:100px; text-align:center;'><h2><?PHP echo $d['text_title'];?></h2><p><?PHP echo $d['text_block'];?></p></div>
  
  <div class='col-sm-6' style='height:100px; text-align:center;'><button type="button" class="btn btn-success btn-lg btn-block" onclick="window.location.href='enter_information.php'">YES</button></div>
  
  <div class='col-sm-6' style='height:100px; text-align:center;'><button type="button" class="btn btn-danger btn-lg btn-block" onclick="window.location.href='not_a_registered_voter.php'">NO</button> </div>
  
<?PHP include_once('footer.php');
