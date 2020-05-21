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
slack_general('ADMIN: managers.php ('.$_COOKIE['name'].') ('.$_COOKIE['level'].')','md-petition');
?>

<h1>Managers</h1>
<?PHP
$q="SELECT * FROM users where level='manager'";
$r = $petition->query($q);
while($d = mysqli_fetch_array($r)){
 echo "<li>$d[id] $d[email] $d[name] $d[group_id] $d[sec_level]</li>"; 
}
?>


<?PHP
include_once('footer.php');
?>
