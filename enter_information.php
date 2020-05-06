<?PHP
include_once('header.php');

// if found send to is_the_information_correct.php

// if not found send to warning_not_found.php

// if missing data send to warning_incomplete.php

?>

<form method='POST'>
  
  <div class='col-sm-12' style='height:100px; text-align:center;'><h3>Please enter your Name and ZIP Code as it appears on your Maryland Voter Registration</h3></div>
  
  <div class='col-sm-6' style='height:50px; text-align:center;'><h3>First Name</h3></div>
  
  <div class='col-sm-6' style='height:50px; text-align:center;'><h3>Last Name</h3></div>
  
  <div class='col-sm-6' style='height:50px; text-align:center;'><input> </div>
  
  <div class='col-sm-6' style='height:50px; text-align:center;'><input> </div>
  
  <div class='col-sm-6' style='height:50px; text-align:center;'><h3>House Number</h3></div>
  
  <div class='col-sm-6' style='height:50px; text-align:center;'><h3>ZIP Code</h3></div>
  
  <div class='col-sm-6' style='height:50px; text-align:center;'><input> </div>
  
  <div class='col-sm-6' style='height:50px; text-align:center;'><input> </div>
  
  <div class='col-sm-12' style='height:50px; text-align:center;'><button type="button" class="btn btn-success">Next</button></div>

</form>

<?PHP include_once('footer.php');
