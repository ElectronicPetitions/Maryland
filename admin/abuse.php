<?PHP 
include_once('../slack.php');
include_once('security.php');
include_once('/var/www/secure.php'); //outside webserver
if ($_COOKIE['level'] == 'user'){
  slack_general('ADMIN: Redirect User Home ('.$_COOKIE['name'].') ('.$_COOKIE['level'].')','md-petition');
  header('Location: user_home.php');
}
if ($_COOKIE['level'] == 'manager'){
  slack_general('ADMIN: Redirect Manager Home ('.$_COOKIE['name'].') ('.$_COOKIE['level'].')','md-petition');
  header('Location: manager_home.php');
}
if (isset($_GET['flag_invalid_signature'])){
  $id = $_GET['flag_invalid_signature'];
  $petition->query("update signatures set signature_status = 'flag_invalid_signature' where id = '$id' ");
  header('Location: abuse.php');
}
if (isset($_GET['flag_duplicate'])){
  $id = $_GET['flag_duplicate'];
  $petition->query("update signatures set signature_status = 'flag_duplicate' where id = '$id' ");
  header('Location: abuse.php');
}
if (isset($_GET['flag_ip_address'])){
  $ip = $_GET['flag_ip_address'];
  $petition->query("update signatures set signature_status = 'flag_ip_address' where ip_address = '$ip' ");
  header('Location: abuse.php');
}
if (isset($_GET['flag_VTRID'])){
  $VTRID = $_GET['flag_VTRID'];
  $petition->query("update signatures set signature_status = 'flag_VTRID' where VTRID = '$VTRID' ");
  header('Location: abuse.php');
}
if (isset($_GET['flag_phone'])){
  $flag_phone = $_GET['flag_phone'];
  $petition->query("update signatures set signature_status = 'flag_phone' where contact_phone = '$flag_phone' ");
  header('Location: abuse.php');
}
include_once('header.php');
if (isset($_GET['ip_address'])){ 
  $ip = $_GET['ip_address']; 
  echo "<h1>Review $ip</h1><table width='100%' border='1' cellpadding='5' cellspacing='5'>";    
  $q = "SELECT * FROM  signatures where ip_address = '$ip' order by signature_status ";
  $r = $petition->query($q);
  while($d = mysqli_fetch_array($r)){
    echo "<tr>
      <td><b>$d[date_time_signed]</b></td>
      <td><a href='?VTRID=$d[VTRID]'>$d[VTRID]</a></td>
      <td>$d[petition_id]</td>
      <td>$d[signed_name_as]</td>
      <td>$d[signed_name_as_circulator]</td>
      <td>$d[contact_phone]</td>
      <td>$d[signature_status]</td>
      <td>$d[printed_status]</td>
      <td><a href='?flag_invalid_signature=$d[id]'>flag_invalid_signature</a></td>
      <td><a href='?flag_VTRID=$d[VTRID]'>flag_VTRID</a></td>
      <td><a href='?flag_ip_address=$d[ip_address]'>flag_ip_address</a></td>
      <td><a href='?flag_duplicate=$d[id]'>flag_duplicate</a></td>
      <td><a href='?flag_phone=$d[contact_phone]'>contact_phone</a></td>
    </tr>"; 
  }
  echo "</table>";
}elseif (isset($_GET['VTRID'])){ 
  $VTRID = $_GET['VTRID'];
  echo "<h1>Review $VTRID</h1><table width='100%' border='1' cellpadding='5' cellspacing='5'>";   
  $q = "SELECT * FROM  signatures where VTRID = '$VTRID' order by signature_status ";
  $r = $petition->query($q);
  while($d = mysqli_fetch_array($r)){
    echo "<tr>
          <td><b>$d[date_time_signed]</b></td>
          <td><a href='?ip_address=$d[ip_address]'>$d[ip_address]</a></td>
          <td>$d[petition_id]</td>
          <td>$d[signed_name_as]</td>
          <td>$d[signed_name_as_circulator]</td>
          <td>$d[contact_phone]</td>
          <td>$d[signature_status]</td>
          <td>$d[printed_status]</td>
          <td><a href='?flag_invalid_signature=$d[id]'>flag_invalid_signature</a></td>
          <td><a href='?flag_VTRID=$d[VTRID]'>flag_VTRID</a></td>
          <td><a href='?flag_ip_address=$d[ip_address]'>flag_ip_address</a></td>
          <td><a href='?flag_duplicate=$d[id]'>flag_duplicate</a></td>
          <td><a href='?flag_phone=$d[contact_phone]'>contact_phone</a></td>
        </tr>"; 
  }
  echo "</table>";
}
?>

<h1>Abuses</h1>
<h2>IP Address List</h2>
<div>Watch for duplicates.</div>
<?PHP
$q="SELECT ip_address, petition_id,VTRID, COUNT(*) as count FROM signatures where signature_status = 'verified' group by ip_address, petition_id, VTRID";
$r = $petition->query($q);
while($d = mysqli_fetch_array($r)){
  if ($d['count'] > 1){
    echo "<li><a href='?ip_address=$d[ip_address]'>$d[ip_address]</a> <a href='?VTRID=$d[VTRID]'>$d[VTRID]</a> $d[petition_id] <b>$d[count]</b></li>"; 
  }
}
?>

<h2>VTRID List</h2>
<div>Watch for duplicates.</div>
<?PHP
$q="SELECT VTRID, petition_id, COUNT(*) as count FROM signatures where signature_status = 'verified' group by VTRID, petition_id";
$r = $petition->query($q);
while($d = mysqli_fetch_array($r)){ 
  if ($d['count'] > 1){
    echo "<li><a href='?VTRID=$d[VTRID]'>$d[VTRID]</a> $d[petition_id] <b>$d[count]</b></li>"; 
  }
}
?>


<?PHP
include_once('footer.php');
?>
