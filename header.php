<?PHP 
include_once('session.php');
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
if (isset($_GET['form_version'])){
  if ($_GET['form_version'] == '2'){ 
    setcookie("form_version", '2'); 
  } 
  if ($_GET['form_version'] == '3'){ 
    setcookie("form_version", '3'); 
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
  <meta property="og:url"           content="https://www.md-petition.com/index.php" />
  <meta property="og:type"          content="website" />
  <meta property="og:title"         content="Maryland Electronic Petition Software" />
  <meta property="og:description"   content="Socially Distant Petitions" />
  <meta property="fb:app_id"        content="3170466243046869" />
  <meta property="og:image"         content="http://www.md-petition.com/files/maryland-flag-graphic.png" />
  <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
  <link rel="manifest" href="/site.webmanifest">
  <script data-ad-client="ca-pub-2410355655106377" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '3170466243046869',
      cookie     : true,
      xfbml      : true,
      version    : 'v7.0'
    });
      
    FB.AppEvents.logPageView();   
      
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "https://connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
</script>
  
  <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-TY6C66ZWMX"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-TY6C66ZWMX');
</script>
  <?PHP 
  include_once('/var/www/secure.php'); //outside webserver
  presign(); // requires db connection
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
      echo "<div class='row'><div class='col-sm-10' style='text-align:center;'><h1 style='text-align:center; color:$d[web_color_text]; background-color:$d[web_color];'>$d[petition_name]</h1></div></div>";
      if ($d['social_phone'] != ''){
        echo "<div class='row'><div class='col-sm-10' style='text-align:center;'><h3 style='text-align:center; color:$d[web_color_text]; background-color:$d[web_color];'>Support: <a style='color:$d[web_color_text];' href='tel:".$d['social_phone']."'>".$d['social_phone']."</a> <a style='color:$d[web_color_text];' href='mailto:".$d['social_email']."'>".$d['social_email']."</a></h3></div></div>";
      }
      if ($d['social_email'] != '' && $d['social_phone'] == ''){
        echo "<div class='row'><div class='col-sm-10' style='text-align:center;'><h3 style='text-align:center; color:$d[web_color_text]; background-color:$d[web_color];'>Support: <a style='color:$d[web_color_text];' href='mailto:".$d['social_email']."'>".$d['social_email']."</a></h3></div></div>";
      }
      } 
    ?>
