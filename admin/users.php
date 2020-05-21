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
if(isset($_POST['name']) && isset($_POST['email']) ){
  $name = $petition->real_escape_string($_POST['name']);
  $email = $petition->real_escape_string($_POST['email']);
  $petition->query("insert into users (name,email,group_id,sec_level) values ('$name','$email','$group_id','user') ");
}
?>

<h1>Managers</h1>
<?PHP
$q="SELECT * FROM users where sec_level='manager' and group_id = '$group_id'";
$r = $petition->query($q);
while($d = mysqli_fetch_array($r)){
 echo "<li>$d[id] $d[email] $d[name] $d[group_id] $d[sec_level]</li>"; 
}
?>
<h1>Users</h1>
<?PHP
$q="SELECT * FROM users where sec_level='user' and group_id = '$group_id'";
$r = $petition->query($q);
while($d = mysqli_fetch_array($r)){
 echo "<li>$d[id] $d[email] $d[name] $d[group_id] $d[sec_level]</li>"; 
}
?>
<h1>New User</h1>
<form method='post'>
  name <input name='name' required>
  email <input name='email' required>
  <input type='submit'>
</form>


<?PHP
include_once('footer.php');
?>
