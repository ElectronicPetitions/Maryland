<?PHP 
ob_start();
include_once('header.php'); 
$head = ob_get_clean();
$web_first_name   = $_COOKIE['web_first_name'];
$web_last_name    = $_COOKIE['web_last_name'];
$web_house_number = $_COOKIE['web_house_number'];
$web_zip_code     = $_COOKIE['web_zip_code'];
if ($web_first_name != '' && $web_last_name != '' && $web_house_number != '' && $web_zip_code != ''){
  // ok to check for records
}else{
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
}else{
   header('Location: warning_not_found.php');
}
echo $head;




$available='';
$q2 = "SELECT * FROM petitions";
$r2 = $petition->query($q2);
while($d2 = mysqli_fetch_array($r2)){
 $field = $d2['eligibleVoterListField'];
 $pass = $d2['eligibleVoterListEquals'];
 $q4 = "select * from signatures where VTRID = '$VTRID' and petition_id = '$d2[petition_id]' ";
 $r4 = $petition->query($q4);
 $d4 = mysqli_fetch_array($r4);
 if ($d4['id'] > 0){
  $available .= "<div class='row'>
  <div class='col-sm-2'><a target='_Blank' href='soft_copy.php?id=$d4[id]'>Already Signed - View</a> or <a target='_Blank' href='?remove=$d4[id]'>Remove</a></div>
  <div class='col-sm-6'><del>$d2[petition_name]</del></div>
  <div class='col-sm-4'>$field == $pass</div>
    </div>"; 
 }elseif($d[$field] == $pass){
   if($_COOKIE['invite'] != '' && strtoupper($_COOKIE['invite']) == strtoupper($d2['web_short_name'])){
     $checked = 'checked';
   }else{
     $checked = '';
   }
  $available .= "<div class='row'>
  <div class='col-sm-2'><input type='radio' id='petition' name='petition' value='$d2[petition_id]' $checked> </div>
  <div class='col-sm-6'>$d2[petition_name]</div>
  <div class='col-sm-4'>$field == $pass</div>
    </div>";
   if($_COOKIE['invite'] != '' && strtoupper($_COOKIE['invite']) == strtoupper($d2['web_short_name'])){
     $available .= '<script>document.getElementById("form").submit();</script>';
   }
 }else{
   if($_COOKIE['invite'] != '' && strtoupper($_COOKIE['invite']) == strtoupper($d2['web_short_name'])){
     $checked = 'checked';
   }else{
     $checked = '';
   }
  $available .= "<div class='row'>
  <div class='col-sm-2'><input type='radio' id='petition' name='petition' value='$d2[petition_id]' checked > </div>
  <div class='col-sm-6'><del>$d2[petition_name]</del></div>
  <div class='col-sm-4'>$field != $pass</div>
    </div>"; 
   if($_COOKIE['invite'] != '' && strtoupper($_COOKIE['invite']) == strtoupper($d2['web_short_name'])){
     $available .= '<script>document.getElementById("form").submit();</script>';
   }
 }
}
?>
<form method='POST' action='petition.php' id='form'>
  
  <div class='row'>
    <div class='col-sm-12' style='height:100px; text-align:center;'><h2>Active Petitions and Eligiblity Requirements to Sign.</h2></div>
  </div>

  <div class='row'>
    <div class='col-sm-2'><h3>Pick One</h3></div>
    <div class='col-sm-6'><h3>Petition Name</h3></div>
    <div class='col-sm-4'><h3>Requirements</h3></div>
  </div>

  <?PHP echo $available;?>

  <div class='row'>
    <div class='col-sm-12' style='height:100px; text-align:center;'><button type="submit" class="btn btn-success">Next</button><div>
  </div>
      
</form>

<?PHP include_once('footer.php');
