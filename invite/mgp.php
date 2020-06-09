<?PHP 
setcookie("invite", "mgp", time()+3600, "/"); // we use this later
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
  <?PHP 
  include_once('/var/www/secure.php'); //outside webserver
  $q = "select * from petitions where petition_id = '1'";
  $r = $petition->query($q);
  $d = mysqli_fetch_array($r);
  include_once('../slack.php');
  ?>
  <meta property="og:url"           content="https://www.md-petition.com/invite/mgp.php" />
  <meta property="og:type"          content="website" />
  <meta property="og:title"         content="<?PHP echo $d['tab_name'];?>" />
  <meta property="og:description"   content="Maryland Electronic Petition Software - Socially Distant Petitions" />
  <meta property="og:image"         content="https://www.md-petition.com/files/MDGREENS_FB_SHARE.PNG" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <title><?PHP echo $d['tab_name'];?></title>
</head>
<body style='background-color:<?PHP echo $d['web_color'];?>;'>
<div class="container-fluid">
<?PHP
slack_general('MGP Home Page Loaded ('.$_COOKIE['invite'].')','md-petition');
?>

<div class='row'>
  <div class='col-sm-10' style='text-align:center;'><h1><?PHP echo $d['text_title'];?></h1><h2 style='text-align:left;'><?PHP echo $d['text_block'];?></h2></div>
</div> 
  <div class='row'>
    <div class='col-sm-10' style='text-align:center;'><h3>If you need assistance, please contact:</h3></div>
  </div> 
 <?PHP if ($d['social_phone'] != ''){ ?> 
 <div class='row'>
  <div class='col-sm-5' style='text-align:right;'>Phone</div>
  <div class='col-sm-5' style='text-align:left;'><?PHP echo $d['social_phone'];?></div>
 </div>
 <?PHP } ?>
  <?PHP if ($d['social_email'] != ''){ ?> 
 <div class='row'>
  <div class='col-sm-5' style='text-align:right;'>E-Mail</div>
  <div class='col-sm-5' style='text-align:left;'><?PHP echo $d['social_email'];?></div>
 </div>
  <?PHP } ?>
  <?PHP if ($d['social_website'] != ''){ ?> 
 <div class='row'>
  <div class='col-sm-5' style='text-align:right;'>Website</div>
  <div class='col-sm-5' style='text-align:left;'><?PHP echo $d['social_website'];?></div>
 </div>
  <?PHP } ?>
   <?PHP if ($d['social_facebook'] != ''){ ?> 
   <div class='row'>
  <div class='col-sm-5' style='text-align:right;'>Facebook</div>
  <div class='col-sm-5' style='text-align:left;'><?PHP echo $d['social_facebook'];?></div>
 </div>
  <?PHP } ?>
   <?PHP if ($d['social_twitter'] != ''){ ?> 
 <div class='row'>
  <div class='col-sm-5' style='text-align:right;'>Twitter</div>
  <div class='col-sm-5' style='text-align:left;'><?PHP echo $d['social_twitter'];?></div>
 </div>
   <?PHP } ?>
<div class='row'>
  <div class='col-sm-10' style='text-align:center;'><button type="button" class="btn btn-success btn-lg btn-block" onclick="window.location.href='../enter_information.php'"><img class='click_me' src="../files/click_here.gif"> CLICK HERE TO BEGIN - SIGN <?PHP echo $d['petition_name'];?></button></div>
 </div> 
  
 <div class='row'>
  <div class='col-sm-10' style='text-align:center;'> <img class="img-responsive" alt="<?PHP echo $d['text_title'];?>" src="<?PHP echo $d['logo_url'];?>"></div>
 </div>
  
<div id="fb-root"></div>
  <script>(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.0";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));</script>
  
  <script>window.twttr = (function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0],
    t = window.twttr || {};
  if (d.getElementById(id)) return t;
  js = d.createElement(s);
  js.id = id;
  js.src = "https://platform.twitter.com/widgets.js";
  fjs.parentNode.insertBefore(js, fjs);

  t._e = [];
  t.ready = function(f) {
    t._e.push(f);
  };

  return t;
}(document, "script", "twitter-wjs"));</script>
  <script>
  function myFunction(short_code) {
  /* Get the text field */
  var copyText = document.getElementById(short_code);

  /* Select the text field */
  copyText.select();
  copyText.setSelectionRange(0, 99999); /*For mobile devices*/

  /* Copy the text inside the text field */
  document.execCommand("copy");

  /* Alert the copied text */
  alert("Copied the Link: " + copyText.value);
}
</script>
  
 <center>
 <table border="1" cellpadding="2" cellspacing="0">
 <tr>
  <td><div class="fb-share-button" 
     data-href="https://www.md-petition.com/invite/mgp.php" 
     data-layout="box_count" data-size="large">
   </div></td>
   <td>
   <a class="twitter-share-button"
  href="https://twitter.com/intent/tweet"
  data-size="large"
  data-text="Can you spare a minute to sign <?PHP echo $d['petition_name'];?>"
  data-url="https://www.md-petition.com/invite/mgp.php">
     Tweet</a></td>
   <td><input type='text' size='50' value='http://md-petition.com/invite/mgp.php' id='mgp'><button onclick='myFunction("mgp")'>Copy Link</button></td>
   <td><a href='../printable_qr_code.php?short=<?PHP echo $d['web_short_name'];?>'><img src='https://www.md-petition.com/qrcode.php?s=qrl&d=https://www.md-petition.com/invite/mgp.php'></a></td>
   </tr>
 </table>
</center>
 
 
 
<?PHP
$copy = '&copy; 2020 Patrick McGuire';
?>
<div class='row'>
 <div class='col-sm-10' style='text-align:center;'><?PHP echo $copy;?></div>
</div>
  
  <div class='row'>
  <div class='col-sm-10' style='text-align:center;'>
   <?PHP if($_COOKIE['debug'] == 'on'){ ?> 
    <pre><?PHP print_r($_GET); ?></pre>
    <pre><?PHP print_r($_POST); ?></pre> 
    <pre><?PHP print_r($_COOKIE); ?></pre>
   <?PHP } ?>
  </div>
</div>

