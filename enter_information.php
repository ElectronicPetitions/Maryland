<?PHP
if (empty($_COOKIE['signature_status'])){
   setcookie("signature_status", 'unverified');
}
if (isset($_POST['web_first_name'])){
  $DOB='';
  if (isset($_POST['DOB'])){
    if ($_POST['DOB'] != ''){
     $DOB = $_POST['DOB'];
     setcookie("pDOB", $DOB);
    }
  }
  $web_first_name='';
  if (isset($_POST['web_first_name'])){
    if ($_POST['web_first_name'] != ''){
     $web_first_name = $_POST['web_first_name'];
     setcookie("web_first_name", $web_first_name);
    }
  }
  $web_last_name='';
  if (isset($_POST['web_last_name'])){
    if ($_POST['web_last_name'] != ''){
     $web_last_name = $_POST['web_last_name'];
     setcookie("web_last_name", $web_last_name);
    }
  }
  if(isset($_POST['web_last_name']) && isset($_POST['web_first_name'])){
     setcookie("web_name", $web_first_name.' '.$web_last_name); 
  }
  $web_house_number='';
  if (isset($_POST['web_house_number'])){
    if ($_POST['web_house_number'] != ''){
     $web_house_number = $_POST['web_house_number'];
     setcookie("web_house_number", $web_house_number);
    }
  }
  $web_zip_code='';
  if (isset($_POST['web_zip_code'])){
    if ($_POST['web_zip_code'] != ''){
     $web_zip_code = $_POST['web_zip_code'];
     setcookie("web_zip_code", $web_zip_code);
    }
  }
  $contact_phone='';
  if (isset($_POST['contact_phone'])){
    if ($_POST['contact_phone'] != ''){
     $contact_phone = $_POST['contact_phone'];
     setcookie("pPHONE", $contact_phone);
    }
  }
  header('Location: is_the_information_correct.php');
}
include_once('header.php');
 $qX = "select * from website_text where id = '2'";
 $rX = $petition->query($qX);
 $dX = mysqli_fetch_array($rX);
?>
<script>document.title = "MEPS - Enter Information";</script>
<form method='POST'>
  <div class='row'>
    <div class='col-sm-12' style='height:100px; text-align:center;'><h2><?PHP echo $dX['text_title'];?></h2><p><?PHP echo $dX['text_block'];?></p></div>
  </div>
  <div class='row'>
    <div class='col-sm-4' style='height:50px; text-align:center;'><h3>First Name</h3></div>
    <div class='col-sm-4' style='height:50px; text-align:center;'><h3>Last Name</h3></div>
    <div class='col-sm-4' style='height:50px; text-align:center;'><h3>Date of Birth</h3></div>
  </div>
  <div class='row'>
    <div class='col-sm-4' style='height:50px; text-align:center;'><input name='web_first_name'></div>
    <div class='col-sm-4' style='height:50px; text-align:center;'><input name='web_last_name'></div> 
    <div class='col-sm-4' style='height:50px; text-align:center;'><input name='DOB' type="date"></div>
    </div>
  <div class='row'>
    <div class='col-sm-4' style='height:50px; text-align:center;'><h3>House Number</h3></div>
    <div class='col-sm-4' style='height:50px; text-align:center;'><h3>ZIP Code</h3></div>
    <div class='col-sm-4' style='height:50px; text-align:center;'><h3>Phone Number</h3></div>
  </div>
  <div class='row'>
    <div class='col-sm-4' style='height:50px; text-align:center;'><input name='web_house_number' type='number'> </div>
    <div class='col-sm-4' style='height:50px; text-align:center;'><input name='web_zip_code' type='number'> </div>
    <div class='col-sm-4' style='height:50px; text-align:center;'><input name='contact_phone' type='tel'> </div>
  </div>
  <div class='row'>
    <div class='col-sm-6' style='height:50px; text-align:center;'><button type="reset" class="btn btn-warning btn-lg btn-block">Clear</button></div>
    <div class='col-sm-6' style='height:50px; text-align:center;'><button type="submit" class="btn btn-success btn-lg btn-block">Next</button></div>
  </div>
</form>
<?PHP include_once('footer.php');
