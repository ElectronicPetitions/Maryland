<!DOCTYPE html>
<html lang="en">  
<head>
  <?PHP include_once('/var/www/secure.php'); //outside webserver ?>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <title>MEPS - Maryland Eletronic Petition Software</title>
</head>
<body>
  <div class="container">
    <ul class="nav nav-pills">
      <li role='presentation' <?PHP if($_SERVER['SCRIPT_NAME'] == '/MarylandElectronicPetitionSignature/admin/index.php'){ echo "class='active'"; } ?> ><a href="index.php">Admin Home</a></li>
      <li role='presentation' <?PHP if($_SERVER['SCRIPT_NAME'] == '/MarylandElectronicPetitionSignature/admin/status.php'){ echo "class='active'"; } ?> ><a href="status.php">Voter Data File Status</a></li>
      
      <li role='presentation' <?PHP if($_SERVER['SCRIPT_NAME'] == '/MarylandElectronicPetitionSignature/admin/logout.php'){ echo "class='active'"; } ?> ><a href="logout.php">Log Out</a></li>
    


      <li role='presentation' <?PHP if($_SERVER['SCRIPT_NAME'] == '/MarylandElectronicPetitionSignature/is_the_information_correct.php'){ echo "class='active'"; } ?> ><a href="is_the_information_correct.php">Is The Information Correct</a></li>
      <li role='presentation' <?PHP if($_SERVER['SCRIPT_NAME'] == '/MarylandElectronicPetitionSignature/petition.php'){ echo "class='active'"; } ?> ><a href="petition.php">Petition</a></li>
      <li role='presentation' <?PHP if($_SERVER['SCRIPT_NAME'] == '/MarylandElectronicPetitionSignature/eligible.php'){ echo "class='active'"; } ?> ><a href="eligible.php">Eligible Petitions</a></li>
      <li role='presentation' <?PHP if($_SERVER['SCRIPT_NAME'] == '/MarylandElectronicPetitionSignature/warning_incomplete.php'){ echo "class='active'"; } ?> ><a href="warning_incomplete.php">warning_incomplete</a></li>
      <li role='presentation' <?PHP if($_SERVER['SCRIPT_NAME'] == '/MarylandElectronicPetitionSignature/warning_not_found.php'){ echo "class='active'"; } ?> ><a href="warning_not_found.php">warning_not_found</a></li>
    </ul>

