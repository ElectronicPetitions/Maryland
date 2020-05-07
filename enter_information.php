<?PHP
if (isset($_POST)){
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
  //header('Location: is_the_information_correct.php');
}
include_once('header.php');
?>

<form method='POST'>
  
  <div class='col-sm-12' style='height:100px; text-align:center;'><h3>Please enter your Name and ZIP Code as it appears on your Maryland Voter Registration</h3></div>
  
  <div class='col-sm-6' style='height:50px; text-align:center;'><h3>First Name</h3></div>
  
  <div class='col-sm-6' style='height:50px; text-align:center;'><h3>Last Name</h3></div>
  
  <div class='col-sm-6' style='height:50px; text-align:center;'><input name='web_first_name'> </div>
  
  <div class='col-sm-6' style='height:50px; text-align:center;'><input name='web_last_name'> </div>
  
  <div class='col-sm-6' style='height:50px; text-align:center;'><h3>House Number</h3></div>
  
  <div class='col-sm-6' style='height:50px; text-align:center;'><h3>ZIP Code</h3></div>
  
  <div class='col-sm-6' style='height:50px; text-align:center;'><input name='web_house_number'> </div>
  
  <div class='col-sm-6' style='height:50px; text-align:center;'><input name='web_zip_code'> </div>
  
  <div class='col-sm-12' style='height:50px; text-align:center;'><button type="submit" class="btn btn-success">Next</button></div>

  <div class='col-sm-12' style='height:50px; text-align:center;'><button type="reset" class="btn btn-warning">Clear</button></div>

</form>

<?PHP include_once('footer.php');
