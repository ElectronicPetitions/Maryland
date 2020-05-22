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
  $petition->query("insert into users (name,email,group_id,sec_level) values ('$name','$email','$group_id','manager') ");
}


slack_general('ADMIN: managers.php ('.$_COOKIE['name'].') ('.$_COOKIE['level'].')','md-petition');
?>
<h1>Groups</h1>
<?PHP
$q="SELECT * FROM groups";
$r = $petition->query($q);
while($d = mysqli_fetch_array($r)){
 echo "<li><a href='groups.php?edit=$d[id]'>EDIT</a> $d[name]</li>"; 
}
?>
<h1>Managers</h1>
<?PHP
$q="SELECT * FROM users where sec_level='manager'";
$r = $petition->query($q);
while($d = mysqli_fetch_array($r)){
 echo "<li><a href='managers.php?edit=$d[id]'>EDIT</a> $d[email] $d[name] ".id2group($d['group_id'])."</li>"; 
}
?>
<h1>New Manager</h1>
<form method='post'>
  Name <input name='name' required>
  E-Mail <input name='email' required>
  Group: <select name='group_id' required>
  <?PHP
$q="SELECT * FROM groups";
$r = $petition->query($q);
while($d = mysqli_fetch_array($r)){
 echo "<option value='$d[id]'>$d[name]</option>
 "; 
}
?>
  </select>
  <input type='submit'>
</form>

<?PHP
include_once('footer.php');
?>
