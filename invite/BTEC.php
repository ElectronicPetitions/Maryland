<?PHP 
include_once('header.php');
setcookie("invite", "BTEC", time()+3600, "/"); // we use this later
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
  presign(); // requires db connection
  $q = "select * from petitions where petition_id = '3'";
  $r = $petition->query($q);
  $d = mysqli_fetch_array($r);
  include_once('../slack.php');
  ?>
  <meta property="og:url"           content="https://www.md-petition.com/invite/BTEC.php" />
  <meta property="og:type"          content="website" />
  <meta property="og:title"         content="<?PHP echo $d['tab_name'];?>" />
  <meta property="og:description"   content="Maryland Electronic Petition Software - Socially Distant Petitions" />
  <meta property="og:image"         content="https://www.md-petition.com/files/BTEC.png" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <title><?PHP echo $d['tab_name'];?></title>
</head>
<body style='background-color:<?PHP echo $d['web_color'];?>;'>
<div class="container-fluid">
<?PHP
slack_general('BTEC Home Page Loaded ('.$_COOKIE['invite'].')','md-petition');
?>
<div class='row'>
  <div class='col-sm-12' style='text-align:center;'><h1><?PHP echo $d['text_title'];?></h1></div>
 </div> 
 <div class='row'>
  
   <?PHP if ($d['petition_jpg_page2'] != ''){ ?>
    <div class="row">
      <div class='col-sm-6'><center><img alt='BTEC Logo' class="img-responsive" alt="<?PHP echo $d['text_title'];?>" src="<?PHP echo $d['logo_url'];?>"><h2><?PHP echo $d['text_block'];?></h2></center></div>
      <div class='col-sm-4'><img alt='Amendment Text' class="img-responsive" src='../<?PHP echo $d['petition_jpg_page2'];?>'></div>
    </div>
  <?PHP }else{ ?>
      <div class='col-sm-12'><center><img class="img-responsive" alt="<?PHP echo $d['text_title'];?>" src="<?PHP echo $d['logo_url'];?>"><h2><?PHP echo $d['text_block'];?></h2></center></div>
 
   <?PHP } ?>
  </div>
  
<div class='row'>
  <div class='col-sm-12' style='text-align:center;'><button type="button" class="btn btn-success btn-lg btn-block" onclick="window.location.href='../enter_information.php'"><img alt='Click Here to Continue' style='height:50px; width:100px;' src="../files/click_here.gif"> SIGN <?PHP echo $d['petition_name'];?></button></div>
 </div> 
  
  
  
 <div class='row'>
  <div class='col-sm-6' style='text-align:right;'>Phone</div>
  <div class='col-sm-6' style='text-align:left;'><?PHP echo $d['social_phone'];?></div>
 </div>
 <div class='row'>
  <div class='col-sm-6' style='text-align:right;'>E-Mail</div>
  <div class='col-sm-6' style='text-align:left;'><?PHP echo $d['social_email'];?></div>
 </div>
 <div class='row'>
  <div class='col-sm-6' style='text-align:right;'>Website</div>
  <div class='col-sm-6' style='text-align:left;'><?PHP echo $d['social_website'];?></div>
 </div>
   <div class='row'>
  <div class='col-sm-6' style='text-align:right;'>Facebook</div>
  <div class='col-sm-6' style='text-align:left;'><?PHP echo $d['social_facebook'];?></div>
 </div>
 <div class='row'>
  <div class='col-sm-6' style='text-align:right;'>Twitter</div>
  <div class='col-sm-6' style='text-align:left;'><?PHP echo $d['social_twitter'];?></div>
 </div>
  
<div id="fb-root"></div>
  <script>(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.0";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));</script>
  
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
  
 <div class='row'>
  <div class='col-sm-12' style='text-align:center;'><center>
 <table border="1" cellpadding="2" cellspacing="0">
 <tr>
  <td><div class="fb-share-button" 
     data-href="https://www.md-petition.com/invite/BTEC.php" 
     data-layout="box_count" data-size="large">
   </div></td>
   <td><input type='text' size='50' value='https://www.md-petition.com/invite/BTEC.php' id='BTEC'><button onclick='myFunction("BTEC")'>Copy Link</button></td>
    <td><a href='../printable_qr_code.php?short=BTEC'><img alt='QR Code Invite' src='https://www.md-petition.com/qrcode.php?s=qrl&d=https://www.md-petition.com/invite/BTEC.php'></a></td>
  </tr>
 </table></center>
</div>
</div>
 
 
 
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
