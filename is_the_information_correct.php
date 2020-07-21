<?PHP
$web_first_name   = $_COOKIE['web_first_name'];
$web_last_name    = $_COOKIE['web_last_name'];
$web_house_number = $_COOKIE['web_house_number'];
$web_zip_code     = $_COOKIE['web_zip_code'];
$DOB              = $_COOKIE['pDOB'];
$PHONE             = $_COOKIE['pPHONE'];
if ($web_first_name != '' && $web_last_name != '' && $web_house_number != '' && $web_zip_code != ''){
  include_once('header.php'); 
  $web_first_name   = $petition->real_escape_string($web_first_name);
  $web_last_name    = $petition->real_escape_string($web_last_name);
  $web_house_number = $petition->real_escape_string($web_house_number);
  $web_zip_code     = $petition->real_escape_string($web_zip_code);
  $DOB              = $petition->real_escape_string($DOB);
  $PHONE            = $petition->real_escape_string($PHONE);
}else{
  header('Location: warning_incomplete.php');
}

// V2 API - Remote
include_once('api/maryland_voter.php');
$month 	  		= date('m',strtotime($DOB));
$day 	  		  = date('d',strtotime($DOB));
$year     		= date('Y',strtotime($DOB));
$error = 'Based on what you entered, we were unable to find any information.';
$sbe_response = md_voter_lookup($web_first_name,$web_last_name,$month,$day,$year,$web_zip_code,'','');
$pos = strpos($sbe_response, $error);
if ($pos !== false) {
   slack_general_admin("Voter API v2 Fail: $error",'md-petition-api');
   //meps_mail('mdpetition@gmail.com',$sbe_response,'Voter API v2 Fail: '.$error);
}
$error2 = 'MISSING NAME';
$pos = strpos($sbe_response, $error2);
if ($pos !== false) {
   slack_general_admin("Voter API v2 Fail: $error2",'md-petition-api');
  // meps_mail('mdpetition@gmail.com',$sbe_response,'Voter API v2 Fail: '.$error2);
}
$error3 = 'My Voter Registration Record';
$pos = strpos($sbe_response, $error3);
if ($pos !== false) {
   slack_general_admin("Voter API v2 Success: $error3",'md-petition-api');
  // meps_mail('mdpetition@gmail.com',$sbe_response,'Voter API v2 Success: '.$error3);
}

// V1 API - Local
$q = "select * from VoterList where LASTNAME = '$web_last_name' and FIRSTNAME = '$web_first_name' and HOUSE_NUMBER = '$web_house_number' and RESIDENTIALZIP5 = '$web_zip_code'";
$r = $petition->query($q);
$d = mysqli_fetch_array($r);
if ($d['VTRID'] != ''){
   $VTRID      = $d['VTRID'];
   $FIRSTNAME  = $d['FIRSTNAME'];
   $MIDDLENAME = $d['MIDDLENAME'];
  if ($MIDDLENAME == ''){
    slack_general_admin("WARN: Blank Middle Name Detected",'md-petition-signed');
  }
   $LASTNAME   = $d['LASTNAME'];
    $pos = strpos($LASTNAME, '-');
    if ($pos !== false) {
         slack_general_admin("WARN: Hyphen in Last Name Detected",'md-petition-signed');
    } 
   $ADDRESS    = $d['ADDRESS'];
   $RESIDENTIALCITY   = $d['RESIDENTIALCITY'];
   $COUNTY            = $d['COUNTY'];
   $RESIDENTIALZIP5   = $d['RESIDENTIALZIP5'];
  // set cookies for hard_copy.php
  setcookie("pCOUNTY", $COUNTY);
  if ($MIDDLENAME == ''){
    setcookie("pNAME", "$FIRSTNAME $LASTNAME");
  }else{
    setcookie("pNAME", "$FIRSTNAME $MIDDLENAME $LASTNAME");
  }
  setcookie("pADDRESS", "$ADDRESS $RESIDENTIALCITY $RESIDENTIALZIP5");
  setcookie("pADDRESS1", "$ADDRESS");
  setcookie("pADDRESS2", "$RESIDENTIALCITY MD $RESIDENTIALZIP5");
  setcookie("pVTRID", $VTRID);
  setcookie("signature_status", 'verified');
  slack_general('MATCH: Is the information correct ('.$FIRSTNAME.' '.$LASTNAME.' '.$RESIDENTIALCITY.') ('.$_COOKIE['invite'].')','md-petition');
}else{
  slack_general('MISS: Is the information correct ('.$web_first_name.' '.$web_last_name.' '.$PHONE.') ('.$_COOKIE['invite'].')','md-petition');
   setcookie("signature_status", 'notfound');
   header('Location: warning_not_found.php');
}
$qX = "select * from website_text where id = '6'";
 $rX = $petition->query($qX);
 $dX = mysqli_fetch_array($rX);
?>
<script>document.title = "MEPS - Confirm information";</script>
<div class='row'>
    <div class='col-sm-10' style='text-align:center;'><h1><?PHP echo $dX['text_title'];?></h1><h2><?PHP echo $dX['text_block'];?></h2></div>
</div>
<div class='row'>
  <div class='col-sm-10'><button type="button" class="btn btn-success btn-lg btn-block" onclick="window.location.href='eligible.php'"><img alt='Click Here to Continue' class='click_me' src="files/click_here.gif">YES</button></div>
</div>
<div class='row'>
  <div class='col-sm-5' style='text-align:right;'><h2>First Name</h2></div>
  <div class='col-sm-5' style='text-align:left;'><h2><?PHP echo $FIRSTNAME;?></h2></div>
</div>
<div class='row'>
  <div class='col-sm-5' style='text-align:right;'><h2>Middle Name</h2></div>
  <div class='col-sm-5' style='text-align:left;'><h2><?PHP echo $MIDDLENAME;?><h2></div>
</div>
<div class='row'>
  <div class='col-sm-5' style='text-align:right;'><h2>Last Name</h2></div>
  <div class='col-sm-5' style='text-align:left;'><h2><?PHP echo $LASTNAME;?></h2></div>
</div>
<div class='row'>
  <div class='col-sm-5' style='text-align:right;'><h2>Date of Birth</h2></div>
  <div class='col-sm-5' style='text-align:left;'><h2><?PHP echo $DOB;?></h2></div>
</div>
<div class='row'>
  <div class='col-sm-5' style='text-align:right;'><h2>Full Addresss</h2></div>
  <div class='col-sm-5' style='text-align:left;'><h2><?PHP echo $ADDRESS;?></h2></div>
</div>
<div class='row'>
  <div class='col-sm-5' style='text-align:right;'><h2>Phone</h2></div>
  <div class='col-sm-5' style='text-align:left;'><h2><?PHP echo $PHONE;?></h2></div>
</div>
<div class='row'>
  <div class='col-sm-5' style='text-align:right;'><h2>City</h2></div>
  <div class='col-sm-5' style='text-align:left;'><h2><?PHP echo $RESIDENTIALCITY;?></h2></div>
</div>
<div class='row'> 
  <div class='col-sm-5' style='text-align:right;'><h2>County</h2></div>
  <div class='col-sm-5' style='text-align:left;'><h2><?PHP echo $COUNTY;?></h2></div>
</div>
<div class='row'>
  <div class='col-sm-5' style='text-align:right;'><h2>Zip</h2></div>
  <div class='col-sm-5' style='text-align:left;'><h2><?PHP echo $RESIDENTIALZIP5;?></h2></div>
</div>
<div class='row'>
  <div class='col-sm-10'><button type="button" class="btn btn-success btn-lg btn-block" onclick="window.location.href='eligible.php'"><img alt='Click Here to Continue' class='click_me' src="files/click_here.gif">YES</button></div>
</div>
<div class='row'>
  <div class='col-sm-10'><button type="button" class="btn btn-danger btn-lg btn-block not_me" onclick="window.location.href='reset.php'">NO</button></div>
</div>
  
<?PHP include_once('footer.php');
