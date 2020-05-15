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
</head>
<body>
  <div class="container">
    <ul class="nav nav-pills">
      <li role='presentation' <?PHP if($_SERVER['SCRIPT_NAME'] == '/MarylandElectronicPetitionSignature/admin/index.php'){ echo "class='active'"; } ?> ><a href="index.php">Admin Home</a></li>
      <?PHP if ($_COOKIE['level'] == 'admin'){  include_once('menu_admin.php'); } ?>
      <?PHP if ($_COOKIE['level'] == 'manager' || $_COOKIE['level'] == 'admin'){  include_once('menu_manager.php'); } ?>
      <?PHP if ($_COOKIE['level'] == 'user' || $_COOKIE['level'] == 'manager' || $_COOKIE['level'] == 'admin'){  include_once('menu_user.php'); } ?>
      <li role='presentation' <?PHP if($_SERVER['SCRIPT_NAME'] == '/MarylandElectronicPetitionSignature/admin/logout.php'){ echo "class='active'"; } ?> ><a href="logout.php">Log Out</a></li>	


      
      
       <li role='presentation' <?PHP if($_SERVER['SCRIPT_NAME'] == '/MarylandElectronicPetitionSignature/admin/manage_petitions.php'){ echo "class='active'"; } ?> ><a href="manage_petitions.php">Manage Petitions</a></li>
      
      <li role='presentation' <?PHP if($_SERVER['SCRIPT_NAME'] == '/MarylandElectronicPetitionSignature/admin/status.php'){ echo "class='active'"; } ?> ><a href="status.php">Voter Data File Status</a></li>
      
      <li role='presentation' <?PHP if($_SERVER['SCRIPT_NAME'] == '/MarylandElectronicPetitionSignature/admin/report.php'){ echo "class='active'"; } ?> ><a href="report.php">Reports</a></li>
      
      
      <li role='presentation' <?PHP if($_SERVER['SCRIPT_NAME'] == '/MarylandElectronicPetitionSignature/admin/new_admin.php'){ echo "class='active'"; } ?> ><a href="new_admin.php">new_admin</a></li>
      <li role='presentation' <?PHP if($_SERVER['SCRIPT_NAME'] == '/MarylandElectronicPetitionSignature/admin/new_admin.php'){ echo "class='active'"; } ?> ><a href="new_admin.php">manage admin</a></li>
      
      <li role='presentation' <?PHP if($_SERVER['SCRIPT_NAME'] == '/MarylandElectronicPetitionSignature/admin/new_user.php'){ echo "class='active'"; } ?> ><a href="new_user.php">new_user</a></li>
 <li role='presentation' <?PHP if($_SERVER['SCRIPT_NAME'] == '/MarylandElectronicPetitionSignature/admin/new_admin.php'){ echo "class='active'"; } ?> ><a href="new_admin.php">manage users</a></li>
      
      <li role='presentation' <?PHP if($_SERVER['SCRIPT_NAME'] == '/MarylandElectronicPetitionSignature/admin/new_admin.php'){ echo "class='active'"; } ?> ><a href="new_admin.php">New Petition</a></li>
     

      
      
      <li role='presentation' <?PHP if($_SERVER['SCRIPT_NAME'] == '/MarylandElectronicPetitionSignature/admin/backup.php'){ echo "class='active'"; } ?> ><a href="backup.php">backup</a></li>
      <li role='presentation' <?PHP if($_SERVER['SCRIPT_NAME'] == '/MarylandElectronicPetitionSignature/admin/restore.php'){ echo "class='active'"; } ?> ><a href="restore.php">restore</a></li>
      
      
      
     
    


      </ul>

