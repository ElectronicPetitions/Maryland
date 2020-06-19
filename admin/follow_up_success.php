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
echo "<ol>";
$q="SELECT * FROM follow_up where status <> 'NEW'";
$r = $petition->query($q);
while($d = mysqli_fetch_array($r)){
  echo "<li>$d[name] $d[email]</li>";
}
echo "</ol>";
include_once('footer.php');
