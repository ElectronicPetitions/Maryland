<?PHP
$web_first_name   = $_COOKIE['web_first_name'];
$web_last_name    = $_COOKIE['web_last_name'];
$web_house_number = $_COOKIE['web_house_number'];
$web_zip_code     = $_COOKIE['web_zip_code'];
if ($web_first_name != '' && $web_last_name != '' && $web_house_number != '' && $web_zip_code != ''){
  // ok to check for records
}else{
  //header('Location: warning_incomplete.php');
}
include_once('header.php'); 
$q = "select VTRID from VoterList where LASTNAME = '$web_last_name' and FIRSTNAME = '$web_first_name' and HOUSE_NUMBER = '$web_house_number' and MAILINGZIP5 = '$web_zip_code'";
$r = $petition->query($q);
$d = mysqli_fetch_array($r);
if ($d['VTRID'] != ''){
   $VTRID = $d['VTRID'];
}else{
   //header('Location: warning_not_found.php');
}
?>
  <div class='row'>
    <div class='col-sm-12' style='height:100px; text-align:center;'><h2>Is this information correct? (<?PHP echo $VTRID.' - '.$q;?>)</h2></div>
  </div>
 <div class='row'>
  <div class='col-sm-6'>First Name </div><div class='col-sm-6'></div>
</div>
 <div class='row'>
  <div class='col-sm-6'>Middle Name </div><div class='col-sm-6'>Edward</div>
</div>
 <div class='row'>
  <div class='col-sm-6'>Last Name </div><div class='col-sm-6'>Smith</div>
</div>
 <div class='row'>
  <div class='col-sm-6'>Full Addresss </div><div class='col-sm-6'>1232 Roadly Ct.</div>
</div>
 <div class='row'>
  <div class='col-sm-2'>City</div><div class='col-sm-2'>Baltimore</div>
  <div class='col-sm-2'>County</div><div class='col-sm-2'>Baltimore City</div>
  <div class='col-sm-2'>Zip</div><div class='col-sm-2'>21204</div>
</div>
<div class='row'>
  <div class='col-sm-6'><button type="button" class="btn btn-success">YES</button></div>
  <div class='col-sm-6'><button type="button" class="btn btn-danger">NO</button></div>
</div>
  
  
  
  
  
  


<?PHP include_once('footer.php');
