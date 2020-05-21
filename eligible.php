<?PHP 
ob_start();
include_once('header.php'); 
$head = ob_get_clean();
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
$q = "select * from VoterList where LASTNAME = '$web_last_name' and FIRSTNAME = '$web_first_name' and HOUSE_NUMBER = '$web_house_number' and RESIDENTIALZIP5 = '$web_zip_code'";
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
$q2 = "SELECT * FROM petitions";
$r2 = $petition->query($q2);
while($d2 = mysqli_fetch_array($r2)){
 $checked = '';
 $field = $d2['eligibleVoterListField'];
 $pass = $d2['eligibleVoterListEquals'];
 $q4 = "select * from signatures where VTRID = '$VTRID' and petition_id = '$d2[petition_id]' and signature_status <> 'removed' ";
 $r4 = $petition->query($q4);
 $d4 = mysqli_fetch_array($r4);
  if ($d4['id'] > 0){
    slack_general($VTRID.' Already Signed '.$d2[petition_id].' ('.$_COOKIE['invite'].')','md-petition');
  }
  /*
if ($d4['id'] > 0){
  $available .= "<div class='row' style='background-color:lightyellow;'>
  <div class='col-sm-3'>Already Signed, <a target='_Blank' href='soft_copy.php?id=$d4[id]'>View</a> or <a href='?remove=$d4[id]'>Remove</a></div>
  <div class='col-sm-6'>$d2[petition_name]</div>
  <div class='col-sm-3'>$field == $pass</div>
    </div>"; 
 }else */
  
  if($d[$field] == $pass){
   $checked = ''; 
   if($_COOKIE['invite'] != '' && strtoupper($_COOKIE['invite']) == strtoupper($d2['web_short_name'])){
     $checked = 'checked';
   }else{
     $checked = '';
   }
  $available .= "<div class='row' style='background-color:lightgreen;'>
  <div class='col-sm-3'><input type='radio' id='petition' name='petition' value='$d2[petition_id]' $checked > </div>
  <div class='col-sm-6'>$d2[petition_name]</div>
  <div class='col-sm-3'>$field == $pass</div>
    </div>";
  
   if($_COOKIE['invite'] != '' && strtoupper($_COOKIE['invite']) == strtoupper($d2['web_short_name'])){
     $available .= '<script>document.getElementById("form").submit();</script>';
   }
 }else{
   $checked = '';
   if($_COOKIE['invite'] != '' && strtoupper($_COOKIE['invite']) == strtoupper($d2['web_short_name'])){
     $checked = 'checked';
   }else{
     $checked = '';
   }
  $available .= "<div class='row' style='background-color:#ffcccb;'>
  <div class='col-sm-3'>"; if ($d2['eligibleVoterListEnforce'] == 'NO'){ $available .="<input type='radio' id='petition' name='petition' value='$d2[petition_id]' $checked >"; }else{ $available .= "Constituents Only"; } $available .= "</div>
  <div class='col-sm-6'>$d2[petition_name]</div>
  <div class='col-sm-3'>$field != $pass</div>
    </div>"; 
   if($_COOKIE['invite'] != '' && strtoupper($_COOKIE['invite']) == strtoupper($d2['web_short_name'])){
     $available .= '<script>document.getElementById("form").submit();</script>';
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
  <div class='row'>
    <div class='col-sm-1' style='height:100px; text-align:center;'><h1><?PHP echo $d['text_title'];?></h1><h2><?PHP echo $d['text_block'];?></h2></div>
  </div>

  <div class='row'>
    <div class='col-sm-2'><h3>Pick One</h3></div>
    <div class='col-sm-6'><h3>Petition Name</h3></div>
    <div class='col-sm-2'><h3>Requirements</h3></div>
  </div>

  <?PHP echo $available;?>

  <div class='row'>
    <div class='col-sm-10' style='height:100px; text-align:center;'><button type="submit" class="btn btn-success btn-lg btn-block">Next</button><div>
  </div>
      
     
      
</form>

<?PHP include_once('footer.php');
