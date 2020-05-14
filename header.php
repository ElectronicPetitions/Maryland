<?PHP 
if ($_GET['debug'] == 'on'){ 
  setcookie("debug", 'on'); 
  header('Location: index.php'); 
} 
if ($_GET['debug'] == 'off'){ 
  setcookie("debug", 'off'); 
  header('Location: index.php'); 
} 
?>
<!DOCTYPE html>
<html lang="en">  
<head>
  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-165887820-1"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-165887820-1');
  </script>
  <?PHP include_once('/var/www/secure.php'); //outside webserver ?>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <title>MEPS - Maryland Eletronic Petition Software</title>
  <script type="text/javascript" src="https://platform-api.sharethis.com/js/sharethis.js#property=5ebd8dd47db58d0012e95fef&product=inline-share-buttons" async="async"></script>
</head>
<body>
  <div class="container">
    <ul class="nav nav-pills">
      <li role='presentation' <?PHP if($_SERVER['SCRIPT_NAME'] == '/MarylandElectronicPetitionSignature/index.php'){ echo "class='active'"; } ?> ><a href='index.php'>1: Are You Registered?</a></li>
      <li role='presentation' <?PHP if($_SERVER['SCRIPT_NAME'] == '/MarylandElectronicPetitionSignature/not_a_registered_voter.php'){ echo "class='active'"; } ?> ><a>2: How to Register?</a></li>
      <li role='presentation' <?PHP if($_SERVER['SCRIPT_NAME'] == '/MarylandElectronicPetitionSignature/enter_information.php'){ echo "class='active'"; } ?> ><a>3: Enter Information</a></li>
      <li role='presentation' <?PHP if($_SERVER['SCRIPT_NAME'] == '/MarylandElectronicPetitionSignature/is_the_information_correct.php'){ echo "class='active'"; } ?> ><a>4: Confirm Information</a></li>    
      <?PHP if ($_COOKIE['invite'] == ''){ ?>
        <li role='presentation' <?PHP if($_SERVER['SCRIPT_NAME'] == '/MarylandElectronicPetitionSignature/eligible.php'){ echo "class='active'"; } ?> ><a>5: Select Petition</a></li>
        <li role='presentation' <?PHP if($_SERVER['SCRIPT_NAME'] == '/MarylandElectronicPetitionSignature/petition.php'){ echo "class='active'"; } ?> ><a>6: Sign Petition</a></li>
      <?PHP }else{ ?>
        <li role='presentation' <?PHP if($_SERVER['SCRIPT_NAME'] == '/MarylandElectronicPetitionSignature/petition.php'){ echo "class='active'"; } ?> ><a>5: Sign <?PHP echo strtoupper($_COOKIE['invite']);?> Petition</a></li>
        <li role='presentation' <?PHP if($_SERVER['SCRIPT_NAME'] == '/MarylandElectronicPetitionSignature/eligible.php'){ echo "class='active'"; } ?> ><a>6: Select Next Petition</a></li>
      <?PHP } ?>
      
      <?PHP if ($_COOKIE['web_name'] != ''){ ?>
        <li role='presentation'><a href="reset.php">RESET</a></li>
      <?PHP } ?>
    </ul>
