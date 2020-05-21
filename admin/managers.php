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
if(isset($_POST['name']) && isset($_POST['email']) && isset($_POST['group_id']) ){
  $name = $petition->real_escape_string($_POST['name']);
  $email = $petition->real_escape_string($_POST['email']);
  $group_id = $petition->real_escape_string($_POST['group_id']);
  $petition->query("insert into users (email,name,group_id,sec_level) values ('$name','$email','$group_id') ");
}


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
<h1>Groups</h1>
<?PHP
$q="SELECT * FROM groups";
$r = $petition->query($q);
while($d = mysqli_fetch_array($r)){
 echo "<li>$d[id] $d[name]</li>"; 
}
?>
<h1>New Manager</h1>
<form method='post'>
  name <input name='name' required>
  email <input name='email' required>
  group_id <input name='group_id' required>
  <input type='submit'>
</form>

<?PHP
include_once('footer.php');
?>
