<?PHP 
include_once('../slack.php');
include_once('security.php');
if ($_COOKIE['level'] == 'user'){
  slack_general('ADMIN: Redirect User Home ('.$_COOKIE['name'].') ('.$_COOKIE['level'].')','md-petition');
  header('Location: user_home.php');
}
include_once('header.php');
slack_general('ADMIN: user manager Loaded ('.$_COOKIE['name'].') ('.$_COOKIE['level'].')','md-petition');
$group_id = $_COOKIE['group_id'];
?>
<h1>Managers</h1>
<?PHP
$q="SELECT * FROM users where sec_level='manager' and group_id = '$group_id'";
$r = $petition->query($q);
while($d = mysqli_fetch_array($r)){
 echo "<li>$d[email] $d[name] $d[group_id] $d[sec_level]</li>"; 
}
?>
<h1>Users</h1>
<?PHP
$q="SELECT * FROM users where sec_level='user' and group_id = '$group_id'";
$r = $petition->query($q);
while($d = mysqli_fetch_array($r)){
 echo "<li>$d[email] $d[name] $d[group_id] $d[sec_level]</li>"; 
}
include_once('footer.php');
