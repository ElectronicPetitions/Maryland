<?PHP 
$title = 'MEPS - Invite Links';
include_once('header.php');
slack_general('Share Links Loaded ('.$_COOKIE['invite'].')','md-petition');
$q = "select * from website_text where id = '8'";
$r = $petition->query($q);
$d = mysqli_fetch_array($r);
?>
<script>document.title = "<?PHP echo $title;?>";</script>
<div class='col-sm-12' style='height:100px; text-align:center;'><h2><?PHP echo $d['text_title'];?></h2><p><?PHP echo $d['text_block'];?></p></div>


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

 <table border="1" cellpadding="2" cellspacing="0">
 <?PHP
 $q2 = "SELECT * FROM petitions";
 $r2 = $petition->query($q2);
 while($d2 = mysqli_fetch_array($r2)){
  echo "<tr>
  <td align='center'><small>$d2[petition_name]<small></td>
  <td><div class=\"fb-share-button\" 
     data-href=\"http://md-petition.com/index.php?invite=$d2[web_short_name]\" 
     data-layout=\"button_count\">
   </div></td>
   <td><a target='_Blank' href='http://md-petition.com/?invite=$d2[web_short_name]'>http://md-petition.com/?invite=$d2[web_short_name]</a></td>
   <td><input type='text' value='http://md-petition.com/?invite=$d2[web_short_name]' id='$d2[web_short_name]'><button onclick='myFunction($d2[web_short_name])'>Copy Link</button></td>
   </tr>";
 }
  ?>
 </table>

<?PHP include_once('footer.php');
