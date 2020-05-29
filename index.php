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
slack_general('Home Page Loaded ('.$_COOKIE['invite'].')','md-petition');
 $q = "select * from website_text where id = '1'";
 $r = $petition->query($q);
 $d = mysqli_fetch_array($r);
?>
<script>document.title = "<?PHP echo $title;?>";</script>
<div class='row'>
  <div class='col-sm-10' style='text-align:center;'><h1><?PHP echo $d['text_title'];?></h1><h2><?PHP echo $d['text_block'];?></h2></div>
 </div> 
<div class='row'>
  <div class='col-sm-5' style='text-align:center;'><button type="button" class="btn btn-success btn-lg btn-block" onclick="window.location.href='enter_information.php'">YES</button></div>
  <div class='col-sm-5' style='text-align:center;'><button type="button" class="btn btn-danger btn-lg btn-block" onclick="window.location.href='not_a_registered_voter.php'">NO</button></div>
 </div> 

<div class='row'>
  <div class='col-sm-10' style='text-align:center;'>We are hosting the following petitions: 
    <?PHP
    $q2 = "SELECT * FROM petitions where admin_status = 'approved'";
    $r2 = $petition->query($q2);
    while($d2 = mysqli_fetch_array($r2)){
      $link = "?invite=$d2[web_short_name]";
      if ($d2['landing_page'] != ''){
        $link = $d2['landing_page']; 
      }
      echo " <a href='https://www.md-petition.com/$link'>$d2[petition_name]</a> ";
    }
    ?>
  </div> 
</div>     
    
<?PHP 
include_once('footer.php'); 
