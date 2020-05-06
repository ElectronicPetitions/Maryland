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
      <li role='presentation' <?PHP if($_SERVER['SCRIPT_NAME'] == '/MarylandElectronicPetitionSignature/intro.php'){ echo "class='active'"; } ?> ><a>Step 1</a></li>
      <li role='presentation' <?PHP if($_SERVER['SCRIPT_NAME'] == '/MarylandElectronicPetitionSignature/not_a_registered_voter.php'){ echo "class='active'"; } ?> ><a>Step 2</a></li>
      <li role='presentation' <?PHP if($_SERVER['SCRIPT_NAME'] == '/MarylandElectronicPetitionSignature/enter_information.php'){ echo "class='active'"; } ?> ><a>Step 3</a></li>
      <li role='presentation' <?PHP if($_SERVER['SCRIPT_NAME'] == '/MarylandElectronicPetitionSignature/is_the_information_correct.php'){ echo "class='active'"; } ?> ><a>Step 4</a></li>
      <li role='presentation' <?PHP if($_SERVER['SCRIPT_NAME'] == '/MarylandElectronicPetitionSignature/petition.php'){ echo "class='active'"; } ?> ><a>Step 5</a></li>
      <li role='presentation' <?PHP if($_SERVER['SCRIPT_NAME'] == '/MarylandElectronicPetitionSignature/eligible.php'){ echo "class='active'"; } ?> ><a>Step 6</a></li>
      <li role='presentation' <?PHP if($_SERVER['SCRIPT_NAME'] == '/MarylandElectronicPetitionSignature/warning_incomplete.php'){ echo "class='active'"; } ?> ><a>Step 7</a></li>
      <li role='presentation'><a href="reset.php">Not [Name], Click Here</a></li>
    </ul>
