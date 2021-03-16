<html lang="en">  
<head>
  <meta property="og:url"           content="https://www.md-petition.com/printable_qr_code.php" />
  <meta property="og:type"          content="website" />
  <meta property="og:title"         content="Maryland Electronic Petition Software" />
  <meta property="og:description"   content="Socially Distant Petitions" />
  <meta property="og:image"         content="http://md-petition.com/files/maryland-flag-graphic.png" />
 
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
  include_once('slack.php');
  ?>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <title>Printable QR Code Invite</title>
  <style>
    h1 { text-align:center; }
    h2 { text-align:center; }
    h3 { text-align:center; }
  </style>
  </head>
  <body>
     <div class='container-fluid'>
    
<?PHP
$short = $_GET['short'];
$q2 = "SELECT * FROM petitions where web_short_name = '$short'";
$r2 = $petition->query($q2);
$d2 = mysqli_fetch_array($r2);
$link = "?invite=$d2[web_short_name]";
if ($d2['landing_page'] != ''){
  $link = $d2['landing_page']; 
}
echo "
      <div class='row'>
        <div class='col-sm-12'>
          <h1>$d2[petition_name]</h1>
        </div>
      </div>
      
      <div class='row'>
        <div class='col-sm-12'>
          <img class='img-responsive' style='width:100%;' src='https://www.md-petition.com/qrcode.php?s=qrl&d=https://www.md-petition.com/$link'>
        </div>
      </div>
      
      <div class='row'>
        <div class='col-sm-12'>
          <h3>https://www.md-petition.com/$link</h3>
        </div>
      </div>
";
?>
    </div>
</body>
