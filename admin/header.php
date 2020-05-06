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
      <li role='presentation' <?PHP if($_SERVER['SCRIPT_NAME'] == '/MarylandElectronicPetitionSignature/admin/logout.php'){ echo "class='active'"; } ?> ><a href="logout.php">Log Out</a></li>
    </ul>
