<?PHP 
include_once('../slack.php');
include_once('security.php');
if ($_COOKIE['level'] == 'user'){
  slack_general('ADMIN: Redirect User Home ('.$_COOKIE['name'].') ('.$_COOKIE['level'].')','md-petition');
  header('Location: user_home.php');
}
if ($_COOKIE['level'] == 'manager'){
  slack_general('ADMIN: Redirect Manager Home ('.$_COOKIE['name'].') ('.$_COOKIE['level'].')','md-petition');
  header('Location: manager_home.php');
}
include_once('header.php');
if (isset($_GET['ip_address'])){ 
  $ip = $_GET['ip_address']; 
  echo "<h1>Review $ip</h1>";    
  $q = "SELECT * FROM  signatures where ip_address = '$ip' ";
  while($d = mysqli_fetch_array($r)){
    echo "<li><a href='?ip_address=$d[ip_address]'>$d[ip_address]</a> <a href='?VTRID=$d[VTRID]'>$d[VTRID]</a> $d[petition_id] <b>$d[date_time_signed]</b></li>"; 
  }
}elseif (isset($_GET['VTRID'])){ 
  $VTRID = $_GET['VTRID'];
  echo "<h1>Review $VTRID</h1>";   
  $q = "SELECT * FROM  signatures where VTRID = '$VTRID' ";
  while($d = mysqli_fetch_array($r)){
    echo "<li><a href='?ip_address=$d[ip_address]'>$d[ip_address]</a> <a href='?VTRID=$d[VTRID]'>$d[VTRID]</a> $d[petition_id] <b>$d[date_time_signed]</b></li>"; 
  }
}
?>

<h1>Abuses</h1>
<h2>IP Address List</h2>
<div>Watch for duplicates.</div>
<?PHP
$q="SELECT ip_address, petition_id, COUNT(*) as count FROM signatures group by ip_address";
$r = $petition->query($q);
while($d = mysqli_fetch_array($r)){
  if ($d['count'] > 1){
    echo "<li><a href='?ip_address=$d[ip_address]'>$d[ip_address]</a> $d[petition_id] <b>$d[count]</b></li>"; 
  }
}
?>

<h2>VTRID List</h2>
<div>Watch for duplicates.</div>
<?PHP
$q="SELECT VTRID, petition_id, COUNT(*) as count FROM signatures group by VTRID";
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
