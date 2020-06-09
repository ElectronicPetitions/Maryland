<?PHP 
if (isset($_GET['debug'])){
  if ($_GET['debug'] == 'on'){ 
    setcookie("debug", 'on'); 
    header('Location: index.php'); 
  } 
  if ($_GET['debug'] == 'off'){ 
    setcookie("debug", 'off'); 
    header('Location: index.php'); 
  }
}  
global $time_on_site;
if (empty($_COOKIE['start_time'])){
  setcookie("start_time", time());
  $time_on_site = 0;
}else{
  $now  = time();
  $time_on_site = $now - $_COOKIE['start_time']; 
}
?>
<!DOCTYPE html>
<html lang="en">  
<head>
  <meta property="og:url"           content="http://md-petition.com/index.php" />
  <meta property="og:type"          content="website" />
  <meta property="og:title"         content="Maryland Electronic Petition Software" />
  <meta property="og:description"   content="Socially Distant Petitions" />
  <meta property="og:image"         content="http://md-petition.com/files/maryland-flag-graphic.png" />
  
  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-165887820-1"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-165887820-1');
  </script>
  <?PHP 
  include_once('/var/www/secure.php'); //outside webserver
  include_once('slack.php');
  ?>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <title>MEPS - Maryland Eletronic Petition Software</title>
<style>
input:focus {
  background-color: lightblue;
}
 .click_me{
   height:50px; 
   width:100px;
  }
  .not_me{
   height:72px; 
  }
</style>
</head>
<body>
  <div class="container-fluid">
    <?PHP  
    if ($_COOKIE['invite'] != ''){ 
      $invite = $petition->real_escape_string($_COOKIE['invite']);
      $q = "select * from petitions where web_short_name = '$invite'";
      $r = $petition->query($q);
      $d = mysqli_fetch_array($r);
      echo "<div class='row'><div class='col-sm-10' style='text-align:center;'><h1 style='text-align:center; background-color:$d[web_color];'>$d[petition_name]</h1></div></div>";
      if ($d['social_phone'] != ''){
        echo "<div class='row'><div class='col-sm-10' style='text-align:center;'><h3 style='text-align:center; background-color:$d[web_color];'>Support: <a href='tel:".$d['social_phone']."'>".$d['social_phone']."</a> <a href='mailto:".$d['social_email']."'>".$d['social_email']."</a></h3></div></div>";
      }
      } 
    ?>
