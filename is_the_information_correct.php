<?PHP
$web_first_name   = $_COOKIE['web_first_name'];
$web_last_name    = $_COOKIE['web_last_name'];
$web_house_number = $_COOKIE['web_house_number'];
$web_zip_code     = $_COOKIE['web_zip_code'];
$DOB              = $_COOKIE['pDOB'];
if ($web_first_name != '' && $web_last_name != '' && $web_house_number != '' && $web_zip_code != ''){
  // ok to check for records
}else{
  header('Location: warning_incomplete.php');
}
include_once('header.php'); 
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
  // set cookies for hard_copy.php
  setcookie("pCOUNTY", $COUNTY);
  setcookie("pNAME", "$FIRSTNAME $MIDDLENAME $LASTNAME");
  setcookie("pADDRESS", "$ADDRESS $RESIDENTIALCITY $RESIDENTIALZIP5");
}else{
   header('Location: warning_not_found.php');
}
?>
  <div class='row'>
    <div class='col-sm-12' style='height:100px; text-align:center;'><h2>Is this information correct?</h2></div>
  </div>
 <div class='row'>
  <div class='col-sm-6' style='height:50px; text-align:center;'>First Name</div><div class='col-sm-6' style='height:50px; text-align:center;'><?PHP echo $FIRSTNAME;?></div>
</div>
 <div class='row'>
  <div class='col-sm-6' style='height:50px; text-align:center;'>Middle Name </div><div class='col-sm-6' style='height:50px; text-align:center;'><?PHP echo $MIDDLENAME;?></div>
</div>
 <div class='row'>
  <div class='col-sm-6' style='height:50px; text-align:center;'>Last Name </div><div class='col-sm-6' style='height:50px; text-align:center;'><?PHP echo $LASTNAME;?></div>
</div>
 <div class='row'>
  <div class='col-sm-6' style='height:50px; text-align:center;'>Date of Birth </div><div class='col-sm-6' style='height:50px; text-align:center;'><?PHP echo $DOB;?></div>
</div>
 <div class='row'>
  <div class='col-sm-6' style='height:50px; text-align:center;'>Full Addresss </div><div class='col-sm-6' style='height:50px; text-align:center;'><?PHP echo $ADDRESS;?></div>
</div>
 <div class='row'>
  <div class='col-sm-2' style='height:50px; text-align:center;'>City</div><div class='col-sm-2'><?PHP echo $RESIDENTIALCITY;?></div>
  <div class='col-sm-2'>County</div><div class='col-sm-2'><?PHP echo $COUNTY;?></div>
  <div class='col-sm-2'>Zip</div><div class='col-sm-2'><?PHP echo $RESIDENTIALZIP5;?></div>
</div>
<div class='row'>
  <div class='col-sm-6' style='height:50px; text-align:center;'><button type="button" class="btn btn-success" onclick="window.location.href='eligible.php'">YES</button></div>
  <div class='col-sm-6' style='height:50px; text-align:center;'><button type="button" class="btn btn-danger" onclick="window.location.href='reset.php'">NO</button></div>
</div>
  
  
  
  
  
  


<?PHP include_once('footer.php');
