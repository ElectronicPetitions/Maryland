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
?>
<h1>Abuses</h1>
<div>We really need to watch for lazy hackers... ok all hackers... we can flag signatures for human review, we WILL be active.</div>
<h2>IP Address</h2>
<?PHP
$q="SELECT ip_address, petition_id, COUNT(*) as count FROM signatures group by ip_address";
$r = $petition->query($q);
while($d = mysqli_fetch_array($r)){
 echo "<li>$d[ip_address] $d[petition_id] <b>$d[count]</b></li>"; 
}
?>

<h2>VTRID</h2>
<?PHP
$q="SELECT VTRID, petition_id, COUNT(*) as count FROM signatures group by VTRID";
$r = $petition->query($q);
while($d = mysqli_fetch_array($r)){
 echo "<li>$d[VTRID] $d[petition_id] <b>$d[count]</b></li>"; 
}
?>


<?PHP
include_once('footer.php');
?>
