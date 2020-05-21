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
slack_general('Entering Information','md-petition');
 $qX = "select * from website_text where id = '2'";
 $rX = $petition->query($qX);
 $dX = mysqli_fetch_array($rX);
?>
<script>document.title = "MEPS - Enter Information";</script>
<form method='POST'>
  
  <div class='row'>
    <div class='col-sm-10' style='text-align:center;'><h1><?PHP echo $dX['text_title'];?></h1><h2 style="margin:25px; padding25px; background-color:lightyellow;"><?PHP echo $dX['text_block'];?></h2></div>
  </div>
   
   
  <div class='row'>
    <div class='col-sm-3' style='text-align:right;'><h2>First Name</h2></div>
    <div class='col-sm-7' style='text-align:left;'><input class="form-control input-lg" name='web_first_name'></div>
  </div>  
   
  <div class='row'>
     <div class='col-sm-3' style='text-align:right;'><h2>Last Name</h2></div>
     <div class='col-sm-7' style='text-align:left;'><input class="form-control input-lg" name='web_last_name'></div> 
  </div> 
   
  <div class='row'>
     <div class='col-sm-3' style='text-align:right;'><h2>Date of Birth</h2></div>
     <div class='col-sm-7'>
            <div class="input-group date">
              <span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span><input name='DOB' type="text" class="form-control">
            </div>
         <script>
               var $d = jQuery.noConflict();
               $d('.input-group.date').datepicker({
                   format: "mm/dd/yyyy",
                   clearBtn: true
               });
         </script>
       </div>
   </div>
      
   <div class='row'>
      <div class='col-sm-3' style='text-align:right;'><h2>Phone Number</h2></div>
      <div class='col-sm-7' style='text-align:left;'><input class="form-control input-lg" name='contact_phone' type='tel'> </div>
  </div>
   
  <div class='row'>
    <div class='col-sm-3' style='text-align:right;'><h2>House Number</h2></div>
    <div class='col-sm-7' style='text-align:left;'><input class="form-control input-lg" name='web_house_number' type='number'> </div>
 </div>  
      
  <div class='row'>
     <div class='col-sm-3' style='text-align:right;'><h2>ZIP Code</h2></div>
     <div class='col-sm-7' style='text-align:left;'><input class="form-control input-lg" name='web_zip_code' type='number'> </div>
  </div>
   
   
  <div class='row'>
    <div class='col-sm-5' style='text-align:center;'><button type="reset" class="btn btn-warning btn-lg btn-block">Clear</button></div>
    <div class='col-sm-5' style='text-align:center;'><button type="submit" class="btn btn-success btn-lg btn-block">Next</button></div>
  </div>
   
</form>

<?PHP include_once('footer.php');
