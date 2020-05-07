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
 if ($d[$field] == $pass){
  $available .= "<div class='row'>
  <div class='col-sm-2'><input type='radio' id='petition' name='petition' value='$d2[petition_id]'> </div>
  <div class='col-sm-6'>$d2[petition_name]</div>
  <div class='col-sm-4'>$field == $pass</div>
    </div>";
 }else{
  $available .= "<div class='row'>
  <div class='col-sm-2'> </div>
  <div class='col-sm-6'>$d2[petition_name]</div>
  <div class='col-sm-4'>$field != $pass</div>
    </div>";
  
 }
 
}



?>
<div class='row'>
 <div class='col-sm-12'> You Are also eligible to sign each of these petitions [location name] </div>
</div>

<?PHP echo $available;?>

  <div class='row'>
    <div class='col-sm-12'>  <button type="button" class="btn btn-success">Next</button> <div>
   </div>


<?PHP include_once('footer.php');
