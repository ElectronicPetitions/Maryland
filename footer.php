<style> @media print { .no-print, .no-print * { display: none !important; } } </style>
<?PHP
$copy = '&copy; 2020 Patrick McGuire';
if ($_COOKIE['invite'] != ''){
 $copy = '&copy; 2020 Patrick McGuire - '.strtoupper($_COOKIE['invite']); 
}  
?>
<?PHP if ($_SERVER['SCRIPT_NAME'] != '/share.php'){ ?>  
 <div class='row no-print'>
  <div class='col-sm-10' style='text-align:center;'><br><br><br><button type="button" class="btn btn-info btn-lg btn-block" onclick="window.open('share.php')">Before you leave click here to share the petition.</button></div>
 </div>
<?PHP } ?>


<div class='row no-print'>
 <div class='col-sm-10' style='text-align:center;'>
  <?PHP echo $copy;?><br>Users Connected to Petitioners: 9,132<br>Verified Voters Signing: 7,231<br>Total Petitions Signed: 10,446  
 </div>
</div>

<br><br>

<div class='row no-print'>
  <div class='col-sm-1' style='text-align:center;'>
  
 </div>

 <div class='col-sm-8' style='text-align:center;'>
  <a target='_Blank' href='https://www.bmorecoin.com/wallet.php'><img src='sponsor.png'></a>  
 </div>

 
 <div class='col-sm-1' style='text-align:center;'>
  
 </div>

</div>





<div id="fb-root"></div>
  <script>(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.0";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));</script>

<div class='row'>
  <div class='col-sm-10' style='text-align:center;'>
   <?PHP if($_COOKIE['debug'] == 'on'){ ?> 
    <pre><?PHP print_r($_GET); ?></pre>
    <pre><?PHP print_r($_POST); ?></pre> 
    <pre><?PHP print_r($_SESSION); ?></pre>
    <pre><?PHP print_r($_COOKIE); ?></pre>
   <?PHP } ?>
  </div>
</div>

</div><!-- close container -->

</body>
