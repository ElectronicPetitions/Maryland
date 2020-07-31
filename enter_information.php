<?PHP
if (isset($_COOKIE['form_version'])){
  if ($_COOKIE['form_version'] == '2'){ 
   header('Location: enter_information_v2.php');
  } 
  if ($_COOKIE['form_version'] == '3'){ 
    header('Location: enter_information_v2.php'); 
  }  
}
if (empty($_COOKIE['signature_status'])){
   setcookie("signature_status", 'unverified');
}
if (isset($_POST['web_first_name'])){
  $email='';
  if (isset($_POST['email'])){
    if ($_POST['email'] != ''){
     $email = $_POST['email'];
     setcookie("email", $email);
    }
  }
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
slack_general('Enter Information ('.$_COOKIE['invite'].')','md-petition');
?>
   <link id="bsdp-css" href="files/bootstrap-datepicker3.min.css" rel="stylesheet">
   <script src="files/bootstrap-datepicker.min.js"></script>
  <?PHP
 $qX = "select * from website_text where id = '2'";
 $rX = $petition->query($qX);
 $dX = mysqli_fetch_array($rX);
?>
<script>document.title = "MEPS - Enter Information";</script>
<form method='POST'>
    
  <div class='row'>
    <div class='col-sm-10' style='text-align:center;'><h1><?PHP echo $dX['text_title'];?></h1><h2 style="margin:10px; padding:10px; background-color:lightyellow;"><?PHP echo $dX['text_block'];?></h2></div>
  </div>
   
      
  <div class='row'>
    <div class='col-sm-3' style='text-align:right;'><h2>E-Mail for Follow Up*</h2></div>
    <div class='col-sm-6' style='text-align:left;'><input class="form-control input-lg" name='email' oninvalid="this.setCustomValidity('Please enter an email address for follow up')" oninput="this.setCustomValidity('')" ></div>
    <div class='col-sm-1' style='text-align:center;'><button type="submit" class="btn btn-success btn-lg btn-block">↴</button></div>
  </div>  
     
  <div class='row'>
    <div class='col-sm-3' style='text-align:right;'><h2>First Name</h2></div>
    <div class='col-sm-6' style='text-align:left;'><input class="form-control input-lg" name='web_first_name' required oninvalid="this.setCustomValidity('Please enter only your first name')" oninput="this.setCustomValidity('')" ></div>
    <div class='col-sm-1' style='text-align:center;'><button type="submit" class="btn btn-success btn-lg btn-block">↴</button></div>
  </div>  
   
  <div class='row'>
     <div class='col-sm-3' style='text-align:right;'><h2>Last Name</h2></div>
     <div class='col-sm-6' style='text-align:left;'><input class="form-control input-lg" name='web_last_name' required oninvalid="this.setCustomValidity('Please enter only your last name')" oninput="this.setCustomValidity('')"></div>
     <div class='col-sm-1' style='text-align:center;'><button type="submit" class="btn btn-success btn-lg btn-block">↴</button></div>
  </div> 
   
  <div class='row'>
     <div class='col-sm-3' style='text-align:right;'><h2>Date of Birth</h2></div>
     <div class='col-sm-6'>
            <div class="input-group date">
              <span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span><input name='DOB' type="text" class="form-control input-lg" required oninvalid="this.setCustomValidity('Please enter your date of birth in the format month month slash day day slash year year year year')" oninput="this.setCustomValidity('')">
            </div>
         <script>
               var $d = jQuery.noConflict();
               $d('.input-group.date').datepicker({
                   format: "mm/dd/yyyy",
                   clearBtn: true
               });
         </script>
       </div>
     <div class='col-sm-1' style='text-align:center;'><button type="submit" class="btn btn-success btn-lg btn-block">↴</button></div>
  </div> 
  <div class='row'>
      <div class='col-sm-3' style='text-align:right;'><h2>Phone Number**</h2></div>
      <div class='col-sm-6' style='text-align:left;'><input class="form-control input-lg" id="contact_phone" name="contact_phone" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" required oninvalid="this.setCustomValidity('please enter your phone number with area code with hyphens like 1 2 3 dash 4 5 6 dash 7 8 9 0')" oninput="this.setCustomValidity('')"></div>
      <div class='col-sm-1' style='text-align:center;'><button type="submit" class="btn btn-success btn-lg btn-block">↴</div>
  </div>
  <div class='row'>
     <div class='col-sm-3' style='text-align:right; background-color:lightyellow;'><h3>Phone Format</h3></div>
     <div class='col-sm-6' style='text-align:left; background-color:lightyellow;'><h3>443-123-4567</h3></div>
     <div class='col-sm-1' style='text-align:center;'></div>
  </div>
  <div class='row'>
    <div class='col-sm-3' style='text-align:right;'><h2>Building Number</h2></div>
    <div class='col-sm-6' style='text-align:left;'><input class="form-control input-lg" name='web_house_number' type='number' required oninvalid="this.setCustomValidity('Please enter your house number without street name')" oninput="this.setCustomValidity('')"> </div>
    <div class='col-sm-1' style='text-align:center;'><button type="submit" class="btn btn-success btn-lg btn-block">↴</button></div>
  </div>  
  <div class='row'>
     <div class='col-sm-3' style='text-align:right; background-color:lightyellow;'><h3>House: 321 Here St.</h3></div>
     <div class='col-sm-6' style='text-align:left; background-color:lightyellow;'><h3>Use: 321</h3></div>
     <div class='col-sm-1' style='text-align:center;'></div>
  </div>
  <div class='row'>
     <div class='col-sm-3' style='text-align:right; background-color:lightyellow;'><h3>Apartment: 21 Here St. Apt 1323</h3></div>
     <div class='col-sm-6' style='text-align:left; background-color:lightyellow;'><h3>Use: 21</h3></div>
     <div class='col-sm-1' style='text-align:center;'></div>
  </div>  
  <div class='row'>
     <div class='col-sm-3' style='text-align:right;'><h2>ZIP Code</h2></div>
     <div class='col-sm-6' style='text-align:left;'><input class="form-control input-lg" name='web_zip_code' type='number' required oninvalid="this.setCustomValidity('Please enter your five digit zip code')" oninput="this.setCustomValidity('')"> </div>
     <div class='col-sm-1' style='text-align:center;'><button type="submit" class="btn btn-success btn-lg btn-block">↴</button></div>
  </div>
  <div class='row'>
     <div class='col-sm-3' style='text-align:right; background-color:lightyellow;'><h3>ZIP Code Format</h3></div>
     <div class='col-sm-6' style='text-align:left; background-color:lightyellow;'><h3>55555</h3></div>
     <div class='col-sm-1' style='text-align:center;'></div>
  </div> 
  <div class='row'>
     <div class='col-sm-10' style='text-align:center;'><button type="submit" class="btn btn-success btn-lg btn-block"><img alt='Click Here to Continue' class='click_me' src="files/click_here.gif">Next</button></div>
  </div>
  <div class='row'>
     <div class='col-sm-10' style='text-align:center;'><button type="reset" class="btn btn-warning btn-lg btn-block not_me">Clear</button></div>
  </div>
  <div class='row'>
     <div class='col-sm-10' style='text-align:center;'>* E-Mail is not required, and will only be used with the petitioners to reach you. It will never be sold.</div>
  </div>
     <div class='row'>
     <div class='col-sm-10' style='text-align:center;'>** PHONE NUMBER IS REQUIRED BY STATE OF MARYLAND. WE WILL NEVER USE YOUR PHONE NUMBER - NEVER CALL - NEVER FOR TEXT MESSAGES.</div>
  </div>
</form>

<?PHP include_once('footer.php');
