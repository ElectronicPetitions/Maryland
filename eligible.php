<?PHP 
ob_start();
include_once('header.php'); 
$head = ob_get_clean();
$VoterList_table   = $_COOKIE['VoterList_table'];
$web_first_name   = $_COOKIE['web_first_name'];
$web_last_name    = $_COOKIE['web_last_name'];
$web_house_number = $_COOKIE['web_house_number'];
$web_zip_code     = $_COOKIE['web_zip_code'];
if ($web_first_name != '' && $web_last_name != '' && $web_house_number != '' && $web_zip_code != ''){
  include_once('header.php'); 
  $web_first_name   = $petition->real_escape_string($web_first_name);
  $web_last_name    = $petition->real_escape_string($web_last_name);
  $web_house_number = $petition->real_escape_string($web_house_number);
  $web_zip_code     = $petition->real_escape_string($web_zip_code);
  $DOB              = $petition->real_escape_string($DOB);
  $PHONE            = $petition->real_escape_string($PHONE);
}else{
  // we should NEVER hit this page anymore
  header('Location: warning_incomplete.php');
}
$q = "select * from $VoterList_table where LASTNAME = '$web_last_name' and FIRSTNAME = '$web_first_name' and HOUSE_NUMBER = '$web_house_number' and RESIDENTIALZIP5 = '$web_zip_code'";
$r = $petition->query($q);
$d = mysqli_fetch_array($r);
if ($d['VTRID'] != ''){
   $VTRID      = $d['VTRID'];
   $FIRSTNAME  = $d['FIRSTNAME'];
   $MIDDLENAME = $d['MIDDLENAME'];
   $LASTNAME   = $d['LASTNAME'];
   $ADDRESS    = $d['ADDRESS'];
   $RESIDENTIALCITY   = $d['RESIDENTIALCITY'];
   $COUNTY            = $d['COUNTY'];
   $RESIDENTIALZIP5   = $d['RESIDENTIALZIP5'];
  slack_general('MATCH: eligible ('.$FIRSTNAME.' '.$LASTNAME.' '.$RESIDENTIALCITY.') ('.$_COOKIE['invite'].')','md-petition');
}else{
  slack_general('MISS: eligible ('.$web_first_name.' '.$web_last_name.' '.$PHONE.') ('.$_COOKIE['invite'].')','md-petition');
  header('Location: warning_not_found.php');
}

if (isset($_GET['remove'])){
  $id = $_GET['remove'];
  $q = "update signatures set signature_status = 'removed' where id = '$id'";
  $petition->query($q);
  slack_general('SQL: eligible ('.$q.') ('.$_COOKIE['invite'].')','md-petition');
  header('Location: eligible.php');
}

echo $head;


$available='';
$q2 = "SELECT * FROM petitions where admin_status = 'approved'";
$r2 = $petition->query($q2);
while($d2 = mysqli_fetch_array($r2)){
 $checked = '';
 $field = $d2['eligibleVoterListField'];
 $pass = $d2['eligibleVoterListEquals'];
 
$my_test = $d[$field];
  
  if($my_test == $pass){
    // good to go
   $checked = ''; 
   if($_COOKIE['invite'] != '' && strtoupper($_COOKIE['invite']) == strtoupper($d2['web_short_name'])){
     $checked = 'checked';
   }else{
     $checked = '';
   }
  $available .= "<div class='row'>
  <div class='col-sm-3' style='color: $d2[web_color_text]; background-color:$d2[web_color];'>&#8594;<input onclick='document.getElementById(\"form\").submit();' type='radio' id='petition' name='petition' value='$d2[petition_id]' $checked >&#8592;</div>
  <div class='col-sm-6' style='color: $d2[web_color_text]; background-color:$d2[web_color];'><h3>$d2[petition_name] <br> $field == $pass</h3></div>
  <div class='col-sm-1' style='color: $d2[web_color_text]; background-color:$d2[web_color];'><h3>$d2[eligibleVoterListEnforce]</h3></div>
    </div>";
  
   if($_COOKIE['invite'] != '' && strtoupper($_COOKIE['invite']) == strtoupper($d2['web_short_name'])){
     $available .= '<script>document.getElementById("form").submit();</script>';
   }
 }else{
    // not a eligable voter
   $checked = '';
   if($_COOKIE['invite'] != '' && strtoupper($_COOKIE['invite']) == strtoupper($d2['web_short_name'])){
     $checked = 'checked';
   }else{
     $checked = '';
   }
  $available .= "<div class='row'>
  <div class='col-sm-3' style='color: $d2[web_color_text]; background-color:$d2[web_color];'>"; if ($d2['eligibleVoterListEnforce'] == 'NO'){ $available .="&#8594;<input onclick='document.getElementById(\"form\").submit();' type='radio' id='petition' name='petition' value='$d2[petition_id]' $checked >&#8592;"; }else{ $available .= "<h3>Constituents Only</h3>"; } $available .= "</div>
  <div class='col-sm-6' style='color: $d2[web_color_text]; background-color:$d2[web_color];'><h3>$d2[petition_name] <br> $field != $pass ($my_test)</h3></div>
  <div class='col-sm-1' style='color: $d2[web_color_text]; background-color:$d2[web_color];'><h3>$d2[eligibleVoterListEnforce]</h3></div>
    </div>"; 
   if($d2['eligibleVoterListEnforce'] == 'NO' && $_COOKIE['invite'] != '' && strtoupper($_COOKIE['invite']) == strtoupper($d2['web_short_name']) ){
     $available .= '<script>document.getElementById("form").submit();</script>';
   }elseif($d2['eligibleVoterListEnforce'] == 'YES' && $_COOKIE['invite'] != '' && strtoupper($_COOKIE['invite']) == strtoupper($d2['web_short_name']) ){
     setcookie("invite", ""); // clear invite
     $error = "$field is not $pass it is $my_test";
     setcookie("invite_error", $error); // record error
     $available .= '<script>alert("'.$d2[eligibleVoterListWarning].'"); location.reload();</script>';
   }
 }
}
?>
<script>document.title = "MEPS - Select Petition";</script>
<form method='POST' action='petition.php' id='form'>
 <?PHP
 $q = "select * from website_text where id = '7'";
 $r = $petition->query($q);
 $d = mysqli_fetch_array($r);
 ?>
  <style>
  input[type=radio]{
    transform:scale(2);
  }
  </style>
  
  <div class='row'>
    <div class='col-sm-10' style='height:100px; text-align:center;'><h1><?PHP echo $d['text_title'];?></h1><h3><?PHP echo $d['text_block'];?></h3></div>
  </div>

  <div class='row'>
    <div class='col-sm-3'><h3>Pick One</h3></div>
    <div class='col-sm-6'><h3>Petition Name <br> Eligible</h3></div>
    <div class='col-sm-1'><h3>Locked</h3></div>
  </div>

  <?PHP echo $available;?>

  <div class='row'>
    <div class='col-sm-10'><button type="submit" class="btn btn-success btn-lg btn-block"><img class='click_me' src="files/click_here.gif">Next</button></div>
   </div>     
  <div class='row'>
    <div class='col-sm-10'><button type="button" class="btn btn-danger btn-lg btn-block" onclick="window.location.href='reset.php'">Reset / Restart</button></div>
  </div>    
      
</form>

<?PHP include_once('footer.php');
