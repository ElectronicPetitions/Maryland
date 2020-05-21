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
if(isset($_POST['name'])){
  $name = $petition->real_escape_string($_POST['name']);
  $petition->query("insert into groups (name) values ('$name') ");
}
slack_general('ADMIN: Group Manager Loaded ('.$_COOKIE['name'].') ('.$_COOKIE['level'].')','md-petition');
?>

<h1>Groups</h1>
<?PHP
$q="SELECT * FROM groups";
$r = $petition->query($q);
while($d = mysqli_fetch_array($r)){
 echo "<li>$d[name]</li>"; 
}
?>


<h1>New Group</h1>
<form method='post'>
  group name <input name='name' required>
  <input type='submit'>
</form>

<?PHP
include_once('footer.php');
?>
