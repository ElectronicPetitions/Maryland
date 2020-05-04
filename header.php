  <?PHP include_once('/var/www/secure.php'); //outside webserver ?>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<div class="container"><!--- Open Container -->
  
<ul class="nav nav-pills">

  <li role='presentation' <?PHP if($_SERVER['SCRIPT_NAME'] == '/MarylandElectronicPetitionSignature/intro.php'){ echo "class='active'"; } ?> ><a href="intro.php">Intro</a></li>
  <li role='presentation' <?PHP if($_SERVER['SCRIPT_NAME'] == '/MarylandElectronicPetitionSignature/not_a_registered_voter.php'){ echo "class='active'"; } ?> ><a href="not_a_registered_voter.php">Not a Registered Voter</a></li>
  <li role='presentation' <?PHP if($_SERVER['SCRIPT_NAME'] == '/MarylandElectronicPetitionSignature/enter_information.php'){ echo "class='active'"; } ?> ><a href="enter_information.php">Enter Information</a></li>
  <li role='presentation' <?PHP if($_SERVER['SCRIPT_NAME'] == '/MarylandElectronicPetitionSignature/is_the_information_correct.php'){ echo "class='active'"; } ?> ><a href="is_the_information_correct.php">Is The Information Correct</a></li>
  <li role='presentation' <?PHP if($_SERVER['SCRIPT_NAME'] == '/MarylandElectronicPetitionSignature/petition.php'){ echo "class='active'"; } ?> ><a href="petition.php">Petition</a></li>
  <li role='presentation' <?PHP if($_SERVER['SCRIPT_NAME'] == '/MarylandElectronicPetitionSignature/eligible.php'){ echo "class='active'"; } ?> ><a href="eligible.php">Eligible Petitions</a></li>

  
  </ul>
