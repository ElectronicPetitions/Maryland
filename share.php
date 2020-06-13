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
 <?PHP
 $q2 = "SELECT * FROM petitions where admin_status = 'approved'";
 $r2 = $petition->query($q2);
 while($d2 = mysqli_fetch_array($r2)){
   $link = "?invite=$d2[web_short_name]";
   if ($d2['landing_page'] != ''){
    $link = $d2['landing_page']; 
   }
  echo "<tr>
  <td align='center'><small>$d2[petition_name]<small><br> Constituents of $d2[eligibleVoterListField] $d2[eligibleVoterListEquals]</td>
  <td><div class=\"fb-share-button\" 
     data-href=\"https://www.md-petition.com/$link\" 
     data-layout=\"button\" data-size=\"large\">
   </div></td>
   <td>
   <a class=\"twitter-share-button\"
  href=\"https://twitter.com/intent/tweet\"
  data-size=\"large\"
  data-text=\"Can you spare a minute to sign $d2[petition_name]\"
  data-url=\"https://www.md-petition.com/$link\">
Tweet</a>
   </td>
   <td><input type='text' size='50' value='https://www.md-petition.com/$link' id='$d2[web_short_name]'><button onclick='myFunction(\"$d2[web_short_name]\")'>Copy Link</button></td>
   <td><a href='printable_qr_code.php?short=$d2[web_short_name]'><img src='https://www.md-petition.com/qrcode.php?s=qrl&d=https://www.md-petition.com/$link'></a></td>
   </tr>";
 }
  ?>
 </table>
</center>
<?PHP include_once('footer.php');
