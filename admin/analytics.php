<?PHP 



include_once('bots.php');
include_once('../slack.php');
include_once('security.php');
include_once('/var/www/secure.php'); //outside webserver
include_once('functions.php');

ob_start();

$sign_email = $_COOKIE['sign_email'];
if (isset($_GET['sign_email'])){
  // here we use it, if it shows up next run, we block
  $sign_email = $_GET['sign_email'];
  $_COOKIE['sign_email'] = $sign_email;
  setcookie("sign_email", $sign_email);
  
}

function js_redirect($page){ // now header - prep for full auto
  $base = 'https://www.md-petition.com/admin/';
  $url = $base.$page;
  $pos = strpos($page, $_COOKIE['sign_email']);
  if ($pos === false) {
    // email not found - good to redirect
    //echo "<script>window.location.href = \"$url\";</script>";
    slack_general('js_redirect('.$page.')','automation');
    header('Location: '.$url);
    //slack_general('CHECK COOKIE ('.$_COOKIE['sign_email'].') PAGE ('.$page.')','md-petition-admin');
    die(); 
  } else {
    slack_general('Loop Detected for '.$_COOKIE['sign_email'],'automation');
    echo "<h1>Automated Loop Detected - Skip</h1>";
  }
  
}

if ($_COOKIE['level'] == 'user'){
  slack_general('ADMIN: Redirect User Home ('.$_COOKIE['name'].') ('.$_COOKIE['level'].')','md-petition');
  header('Location: user_home.php');
}
if (isset($_GET['clear_php_session_id'])){
  $id = $_GET['clear_php_session_id'];
  $petition->query("update presign set presign_status = 'DONE' where php_session_id = '$id' ");
  header('Location: analytics.php');
}
if (isset($_GET['clear_email'])){
  $email = $_GET['clear_email'];
  $petition->query("update presign set presign_status = 'DONE' where email_for_follow_up = '$email' ");
  header('Location: analytics.php');
}
if (isset($_GET['sign_email'])){
  $email = $_GET['sign_email'];
  $petition->query("update presign set presign_status = 'SIGNED' where email_for_follow_up = '$email' ");
  header('Location: analytics.php');
}
if (isset($_GET['sign_php_session_id'])){
  $id = $_GET['sign_php_session_id'];
  $petition->query("update presign set presign_status = 'SIGNED' where php_session_id = '$id' ");
  header('Location: analytics.php');
}
if ($_COOKIE['level'] == 'manager'){
  slack_general('ADMIN: Redirect Manager Home ('.$_COOKIE['name'].') ('.$_COOKIE['level'].')','md-petition');
  header('Location: manager_home.php');
}
if (isset($_GET['flag_invalid_signature'])){
  $id = $_GET['flag_invalid_signature'];
  $petition->query("update signatures set signature_status = 'flag_invalid_signature' where id = '$id' ");
  header('Location: analytics.php');
}
if (isset($_GET['flag_duplicate'])){
  $id = $_GET['flag_duplicate'];
  $petition->query("update signatures set signature_status = 'flag_duplicate' where id = '$id' ");
  header('Location: analytics.php');
}
if (isset($_GET['flag_ip_address'])){
  $ip = $_GET['flag_ip_address'];
  $petition->query("update signatures set signature_status = 'flag_ip_address' where ip_address = '$ip' ");
  header('Location: analytics.php');
}
if (isset($_GET['resign_requested'])){
  $id = $_GET['resign_requested'];
  $petition->query("update signatures set signature_status = 'resign_requested' where id =  '$id' ");
  header('Location: analytics.php');
}
if (isset($_GET['bot'])){
  $id = $_GET['bot'];
  $petition->query("update signatures set signature_status = 'bot' where id =  '$id' ");
  header('Location: analytics.php');
}
if (isset($_GET['flag_VTRID'])){
  $VTRID = $_GET['flag_VTRID'];
  $petition->query("update signatures set signature_status = 'flag_VTRID' where VTRID = '$VTRID' ");
  header('Location: analytics.php');
}
if (isset($_GET['flag_phone'])){
  $flag_phone = $_GET['flag_phone'];
  $petition->query("update signatures set signature_status = 'flag_phone' where contact_phone = '$flag_phone' ");
  header('Location: analytics.php');
}
include_once('header.php');
if (isset($_GET['ip_address'])){ 
  $ip = $_GET['ip_address']; 
  $petition_id = $_GET['petition_id']; 
  echo "<h1>Review $ip</h1><table width='100%' border='1' cellpadding='5' cellspacing='5'>";    
  $q = "SELECT * FROM signatures where ip_address = '$ip' and signature_status = 'verified' and petition_id = '$petition_id' order by signature_status desc ";
  $r = $petition->query($q);
  while($d = mysqli_fetch_array($r)){
    $color = 'white';
    $pos = strpos($d['date_time_signed'], date('Y-m-d'));
    if ($pos !== false) {
        $color= 'yellow';
    } 
    echo "<tr style='background-color:$color;'>
      <td><b>$d[date_time_signed]</b></td>
      <td><a href='?VTRID=$d[VTRID]'>$d[VTRID]</a></td>
      <td>".id2petition($d['petition_id'])."</td>
      <td>$d[signed_name_as]</td>
      <td>$d[signed_name_as_circulator]</td>
      <td>$d[contact_phone]</td>
      <td>$d[printed_status]</td>
      <td><a href='?flag_invalid_signature=$d[id]'>flag invalid signature</a></td>
      <td><a href='?flag_VTRID=$d[VTRID]'>flag VTRID</a></td>
      <td><a href='?flag_ip_address=$d[ip_address]'>flag ip address</a></td>
      <td><a href='?flag_duplicate=$d[id]'>flag duplicate</a></td>
      <td><a href='?flag_phone=$d[contact_phone]'>contact phone</a></td>
      <td><a href='?resign_requested=$d[id]'>resign requested</a></td>
      <td><a href='?bot=$d[id]'>bot</a></td>
    </tr>"; 
  }
  echo "</table>";
}elseif(isset($_GET['email'])){ 
  $email = $_GET['email']; 
  echo "<h1>Review $email</h1><table width='100%' border='1' cellpadding='5' cellspacing='5'>";    
  $q = "SELECT * FROM presign where email_for_follow_up = '$email' order by id desc ";
  $r = $petition->query($q);
  while($d = mysqli_fetch_array($r)){
    $color = 'white';
    $test = date('Y-m-d',strtotime($d['action_on']));
    $pos = strpos($test, date('Y-m-d'));
    if ($pos !== false) {
        $color= 'yellow';
    } 
    echo "<tr style='background-color:$color;'>
      <td style='white-space:pre;'><b>$d[action_on]</b></td>
      <td style='white-space:pre;'><a href='?php_session_id=$d[php_session_id]'>$d[php_session_id]</a></td>
      <td style='white-space:pre;'>$d[php_page]</td>
      <td style='white-space:pre;'>".id2petition($d['petition'])."</td>
      <td style='white-space:pre;'>$d[invite]</td>
      <td style='white-space:pre;'>$d[invite_error]</td>
      <td style='white-space:pre;'>$d[name]</td>
      <td style='white-space:pre;'>$d[email_for_follow_up]</td>
      <td style='white-space:pre;'>$d[phone_for_validation]</td>
      <td style='white-space:pre;'>$d[presign_status]</td>
      <td style='white-space:pre;'>$d[ip_address]</td>
      <td style='white-space:pre;'>$d[browser_string]</td>
    </tr>"; 
  }
  echo "</table><a href='?clear_email=$email'>CLEAR EMAIL</a> - <a href='?sign_email=$email'>SIGNATURE FOUND</a>";
}elseif(isset($_GET['php_session_id']) && empty($_GET['follow_up'])){ 
  $php_session_id = $_GET['php_session_id']; 
  echo "<h1>Review $php_session_id</h1><table width='100%' border='1' cellpadding='5' cellspacing='5'>";    
  $q = "SELECT * FROM presign where php_session_id = '$php_session_id' order by id desc ";
  $r = $petition->query($q);
  while($d = mysqli_fetch_array($r)){
    $color = 'white';
    $test = date('Y-m-d',strtotime($d['action_on']));
    $pos = strpos($test, date('Y-m-d'));
    if ($pos !== false) {
        $color= 'yellow';
    } 
    echo "<tr style='background-color:$color;'>
      <td style='white-space:pre;'><b>$d[action_on]</b></td>
      <td style='white-space:pre;'>$d[php_page]</td>
      <td style='white-space:pre;'>".id2petition($d['petition'])."</td>
      <td style='white-space:pre;'>$d[invite]</td>
      <td style='white-space:pre;'>$d[invite_error]</td>
      <td style='white-space:pre;'>$d[name]</td>
      <td style='white-space:pre;'><a href='?email=$d[email_for_follow_up]'>$d[email_for_follow_up]</a></td>
      <td style='white-space:pre;'>$d[phone_for_validation]</td>
      <td style='white-space:pre;'>$d[presign_status]</td>
      <td style='white-space:pre;'>$d[ip_address]</td>
      <td style='white-space:pre;'>$d[browser_string]</td>
    </tr>"; 
  }
  echo "</table><a href='?clear_php_session_id=$php_session_id'>CLEAR SESSION</a> - 
  <a href='?sign_php_session_id=$php_session_id'>SIGNATURE FOUND</a><br> 
  - <a href='?php_session_id=$php_session_id&follow_up=X'>ADD TO FOLLOW UP LIST Maryland General</a><br>
  - <a href='?php_session_id=$php_session_id&follow_up=1'>ADD TO FOLLOW UP LIST MGP</a><br> 
  - <a href='?php_session_id=$php_session_id&follow_up=2'>ADD TO FOLLOW UP LIST MLP</a><br> 
  - <a href='?php_session_id=$php_session_id&follow_up=3'>ADD TO FOLLOW UP LIST BTEC</a><br> 
  - <a href='?php_session_id=$php_session_id&follow_up=7'>ADD TO FOLLOW UP LIST PG</a><br> 
  - <a href='?php_session_id=$php_session_id&follow_up=8'>ADD TO FOLLOW UP LIST Ivey</a>
  ";
}elseif(isset($_GET['php_session_id']) && isset($_GET['follow_up'])){ 
  $php_session_id = $_GET['php_session_id']; 
  echo "<h1>Adding Follow up for $php_session_id to $_GET[follow_up]</h1><table width='100%' border='1' cellpadding='5' cellspacing='5'>";    
  $q = "SELECT * FROM presign where php_session_id = '$php_session_id' order by id desc ";
  $r = $petition->query($q);
  while($d = mysqli_fetch_array($r)){
    
    $color = 'white';
    $test = date('Y-m-d',strtotime($d['action_on']));
    $pos = strpos($test, date('Y-m-d'));
    if ($pos !== false) {
        $color= 'yellow';
    } 
if ($d[name] != ''){
  $name = $d[name];
}
if ($d[email_for_follow_up] != ''){
  $email = $d[email_for_follow_up];
}
    echo "<tr style='background-color:$color;'>
      <td style='white-space:pre;'><b>$d[action_on]</b></td>
      <td style='white-space:pre;'>$d[php_page]</td>
      <td style='white-space:pre;'>".id2petition($d['petition'])."</td>
      <td style='white-space:pre;'>$d[invite]</td>
      <td style='white-space:pre;'>$d[invite_error]</td>
      <td style='white-space:pre;'>$d[name]</td>
      <td style='white-space:pre;'>$d[email_for_follow_up]</td>
      <td style='white-space:pre;'>$d[phone_for_validation]</td>
      <td style='white-space:pre;'>$d[presign_status]</td>
      <td style='white-space:pre;'>$d[ip_address]</td>
      <td style='white-space:pre;'>$d[browser_string]</td>
    </tr>"; 
  }
  $petition->query("insert into follow_up (name, email, php_session, petition_id, date_sent) values ('$name','$email','$php_session_id','$_GET[follow_up]','".date('Y-m-d')."') ");  
  $petition->query("update presign set presign_status = 'DONE' where php_session_id = '$php_session_id' ");
  $petition->query("update presign set presign_status = 'DONE' where email_for_follow_up = '$email' ");
  echo "</table>";
}elseif (isset($_GET['VTRID'])){ 
  $VTRID = $_GET['VTRID'];
   $petition_id = $_GET['petition_id']; 
  echo "<h1>Review $VTRID</h1><table width='100%' border='1' cellpadding='5' cellspacing='5'>";   
  $q = "SELECT * FROM  signatures where VTRID = '$VTRID' and signature_status = 'verified' and petition_id = '$petition_id' order by petition_id, id DESC ";
  $r = $petition->query($q);
  $i=0;
  while($d = mysqli_fetch_array($r)){
    $color = 'white';
    $pos = strpos($d['date_time_signed'], date('Y-m-d'));
    if ($pos !== false) {
        $color= 'yellow';
    } 
    echo "<tr style='background-color:$color;'>
          <td><b>$d[date_time_signed]</b></td>
          <td><a href='?ip_address=$d[ip_address]'>$d[ip_address]</a></td>
          <td>".id2petition($d['petition_id'])."</td>
          <td>$d[signed_name_as]</td>
          <td>$d[signed_name_as_circulator]</td>
          <td>$d[contact_phone]</td>
          <td>$d[printed_status]</td>
          <td><a href='?flag_invalid_signature=$d[id]'>flag invalid signature</a></td>
          <td><a href='?flag_VTRID=$d[VTRID]'>flag VTRID</a></td>
          <td><a href='?flag_ip_address=$d[ip_address]'>flag ip address</a></td>
          <td><a href='?flag_duplicate=$d[id]'>flag duplicate</a></td>
          <td><a href='?flag_phone=$d[contact_phone]'>contact phone</a></td>
          <td><a href='?resign_requested=$d[id]'>resign requested</a></td>
          <td><a href='?bot=$d[id]'>bot</a></td>
        </tr>";
        if ($i == 0){
          js_redirect("analytics.php?flag_duplicate=$d[id]");
        }
        $i++;
  }
  echo "</table>";
  die();
}
?>

<h1>Signature Analytics - Server Clock: <?PHP echo date('r');?></h1>
<h2>NEVER NEVER NEVER CALL OR TEXT ANYONE - ONLY EMAIL!!!</h2>
<h3>SysOp Says: Transparency = Trust</h3>
<table>
  
  <tr>
  <td valign="top" colspan='2'><?PHP /*
<h2>IP Address</h2>
<div>Watching for duplicates.</div><ol>
<?PHP
$q="SELECT ip_address, petition_id,VTRID, COUNT(*) as count FROM signatures where signature_status = 'verified' group by ip_address, petition_id, VTRID";
$r = $petition->query($q);
while($d = mysqli_fetch_array($r)){
  if ($d['count'] > 1){
    echo "<li><a href='?ip_address=$d[ip_address]&petition_id=$d[petition_id]'>$d[ip_address]</a> ".id2petition($d['petition_id'])." <b>$d[count]</b> $d[signed_name_as]</li>"; 
  }
}
?></ol>
  </td><td valign="top"> */ ?>
<h2>VTRID</h2>
<div>Watching for duplicates.</div><ol>
<?PHP
$q="SELECT VTRID, petition_id, COUNT(*) as count FROM signatures where signature_status = 'verified' group by VTRID, petition_id";
$r = $petition->query($q);
$i=0;
while($d = mysqli_fetch_array($r)){ 
  if ($d['count'] > 1){
    echo "<li><a href='?VTRID=$d[VTRID]&petition_id=$d[petition_id]'>$d[VTRID]</a> ".id2petition($d['petition_id'])." <b>$d[count]</b> $d[signed_name_as]</li>"; 
    if ($i == 0){
       js_redirect("analytics.php?VTRID=$d[VTRID]&petition_id=$d[petition_id]");
    }
    $i++;
  }
  
}
  ?></ol>
  </td></tr>
  
  
<tr>
<td valign="top" colspan='2'>
<h2>Pre-Sign</h2>
<div>Follow up requested - never signed.</div>
<form method='GET'><input name='email'><input type='submit' value='SEARCH E-MAIL'></form><table>
<?PHP
$q="SELECT distinct php_session_id FROM presign where presign_status = 'NEW' and email_for_follow_up <> '' order by id";
$r = $petition->query($q);
while($d = mysqli_fetch_array($r)){ 
  $q2="SELECT * FROM presign where php_session_id = '$d[php_session_id]' order by id desc";
  $r2 = $petition->query($q2);
  $d2 = mysqli_fetch_array($r2);
  $sig = '';
  if ($d2['name'] != ''){
    $q3 = "SELECT date_time_signed FROM signatures where signed_name_as = '$d2[name]'";
    $r3 = $petition->query($q3);
    $d3 = mysqli_fetch_array($r3); 
    if ($d3['date_time_signed'] != ''){
      $sig = "<b><a href='?sign_email=$d2[email_for_follow_up]'>SIGNATURE $d3[date_time_signed]</a></b><br>";
      js_redirect("analytics.php?sign_email=$d2[email_for_follow_up]");
    }
  }
  $presig='';
  $q4="SELECT * FROM presign where email_for_follow_up = '$d2[email_for_follow_up]' and php_page like '/sign.php%'";
  $r4 = $petition->query($q4);
  $d4 = mysqli_fetch_array($r4);
  if ($d4['action_on']){
    $presig = "<b><a href='?sign_email=$d2[email_for_follow_up]'>PRESIG $d4[action_on]</a></b><br>";
    js_redirect("analytics.php?sign_email=$d2[email_for_follow_up]");
  }
  $invite_error='';
  $q4="SELECT * FROM presign where email_for_follow_up = '$d2[email_for_follow_up]' and invite_error <> '' ";
  $r4 = $petition->query($q4);
  $d4 = mysqli_fetch_array($r4);
  if ($d4['invite_error'] != ''){
    $invite_error = "<b><a href='?clear_email=$d2[email_for_follow_up]'>$d4[invite_error]</a></b><br>";
    js_redirect("analytics.php?clear_email=$d2[email_for_follow_up]");
  }
  $php_session_id = $d2['php_session_id'];
  echo "<tr><td><a href='?php_session_id=$php_session_id'>$d2[action_on]</a></td><td>$presig $sig $invite_error</td>
  <td>$d2[name]</td><td><a href='?email=$d2[email_for_follow_up]'>$d2[email_for_follow_up]</a></td>
  <td>".id2petition($d2['petition'])."</td><td>$d2[invite]</td>
  <td><a href='?php_session_id=$php_session_id&follow_up=X'>General</a>
  - <a href='?php_session_id=$php_session_id&follow_up=1'>MGP</a> 
  - <a href='?php_session_id=$php_session_id&follow_up=2'>MLP</a>
  - <a href='?php_session_id=$php_session_id&follow_up=3'>BTEC</a>
  - <a href='?php_session_id=$php_session_id&follow_up=7'>PG</a>
  - <a href='?php_session_id=$php_session_id&follow_up=8'>Ivey</a></td></tr>"; 
  if( $presig == '' && $invite_error == '' && $sig == '' ){
    if ($d2['invite'] == 'Ivey'){
      js_redirect("analytics.php?php_session_id=$php_session_id&follow_up=8");
    }
    if ($d2['invite'] == 'mlp'){
      js_redirect("analytics.php?php_session_id=$php_session_id&follow_up=2");
    }
    if ($d2['invite'] == 'BTEC'){
      js_redirect("analytics.php?php_session_id=$php_session_id&follow_up=3");
    }
    if ($d2['invite'] == 'RestorePGTermLimits'){
      js_redirect("analytics.php?php_session_id=$php_session_id&follow_up=7");
    }
    if (id2petition($d2['petition']) == 'RESTORE TWO TERM (8 YEAR) TERM LIMITS IN PRINCE GEORGE'){
      js_redirect("analytics.php?php_session_id=$php_session_id&follow_up=7");
    }
    if ($d2['invite'] == 'mgp'){
      js_redirect("analytics.php?php_session_id=$php_session_id&follow_up=1");
    }
  }
}
?></table>
  </td>
  </tr>
  <tr>
<td valign="top" colspan='2'>
<h2>Signatures</h2>
<div>Last 10</div><ol>
<?PHP
$q="SELECT * FROM signatures where signature_status = 'verified' order by id desc limit 0, 10";
$r = $petition->query($q);
while($d = mysqli_fetch_array($r)){ 
    echo "<li>$d[date_time_signed] ".id2petition($d['petition_id'])." $d[signed_name_as]</li>"; 
}
?></ol>

  </td>

  </tr>
  <tr><td valign="top">
<h2>VTRID Bugs</h2>
<div>Watching for 0</div><ol>
<?PHP
$q="SELECT * FROM signatures where VTRID = '0' and signature_status <> 'bot' and signature_status <> 'flag_invalid_signature' and signature_status <> 'resign_requested'";
$r = $petition->query($q);
while($d = mysqli_fetch_array($r)){ 
    echo "<li>$d[date_time_signed] <a href='?ip_address=$d[ip_address]'>$d[ip_address]</a> <a target='_Blank' href='https://ipinfo.io/$d[ip_address]'>IP INFO</a> $d[petition_id] $d[signed_name_as]</li>"; 
}
?></ol>
 </td><td valign="top">
<h2>Petition ID Bugs</h2>
<div>Watching for 0</div><ol>
<?PHP
$q="SELECT * FROM signatures where (petition_id = '0' or petition_id = '') and signature_status <> 'bot' and signature_status <> 'flag_invalid_signature' and signature_status <> 'resign_requested'";
$r = $petition->query($q);
while($d = mysqli_fetch_array($r)){ 
    echo "<li>$d[date_time_signed] <a href='?ip_address=$d[ip_address]'>$d[ip_address]</a> <a target='_Blank' href='https://ipinfo.io/$d[ip_address]'>IP INFO</a>  $d[petition_id] $d[signed_name_as]</li>"; 
}
?></ol>
  </td></tr><tr><td valign="top">
    <?PHP ob_start(); ?>
<h2>resign_requested</h2>
<div>These are most likely from early bugs</div><ol>
<?PHP
$q="SELECT * FROM signatures where signature_status = 'resign_requested' order by ip_address";
$r = $petition->query($q);
    $show = 0;
while($d = mysqli_fetch_array($r)){ 
  $show = 1;
    echo "<li>$d[date_time_signed] <a href='?ip_address=$d[ip_address]'>$d[ip_address]</a> <a target='_Blank' href='https://ipinfo.io/$d[ip_address]'>IP INFO</a> <a href='?VTRID=$d[VTRID]'>$d[VTRID]</a> $d[petition_id] $d[signed_name_as]</li>"; 
}
?></ol>
    <?PHP $html = ob_get_clean(); if ( $show == 1 ){ echo $html; } ?>
  </td>
  
  <td valign="top">
    <?PHP ob_start(); ?>
<h2>bots</h2>
<div>These are bots on the site.</div><ol>
<?PHP
$q="SELECT * FROM signatures where signature_status = 'bot' order by ip_address";
$r = $petition->query($q);
$show = 0;
while($d = mysqli_fetch_array($r)){ 
    $show = 1;
    echo "<li>$d[date_time_signed] <a href='?ip_address=$d[ip_address]'>$d[ip_address]</a> <a target='_Blank' href='https://ipinfo.io/$d[ip_address]'>IP INFO</a> <a href='?VTRID=$d[VTRID]'>$d[VTRID]</a> $d[petition_id] $d[signed_name_as]</li>"; 
}
?></ol>
    <?PHP $html = ob_get_clean(); if ( $show == 1 ){ echo $html; } ?>
    
  </td>


</tr>

</table>


<?PHP
// allow headers to be sent...
$html = ob_get_clean();
echo $html; // run javascript

include_once('footer.php');
?>
