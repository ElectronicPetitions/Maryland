<?PHP 
include_once('../slack.php');
include_once('security.php');
if ($_COOKIE['level'] == 'user'){
  slack_general('ADMIN: Redirect User Home ('.$_COOKIE['name'].') ('.$_COOKIE['level'].')','md-petition');
  header('Location: user_home.php');
}
include_once('header.php');
slack_general('ADMIN: petition manager Loaded ('.$_COOKIE['name'].') ('.$_COOKIE['level'].')','md-petition');
$group_id = $_COOKIE['group_id'];
if(isset($_POST['web_short_name']) && isset($_POST['web_color']) && isset($_POST['petition_name']) ){
  $web_short_name = $petition->real_escape_string($_POST['web_short_name']);
  $web_color = $petition->real_escape_string($_POST['web_color']);
  $petition_name = $petition->real_escape_string($_POST['petition_name']);
  $petition->query("insert into petitions (web_short_name,web_color,group_id,petition_name) values ('$web_short_name','$web_color','$group_id','$petition_name') ");
}
?>

<h1>Petitions</h1>
<?PHP
$q="SELECT * FROM petitions where group_id = '$group_id'";
$r = $petition->query($q);
while($d = mysqli_fetch_array($r)){
 echo "<li>$d[petition_id] $d[web_short_name] $d[web_color] $d[group_id] $d[petition_name] $d[eligibleVoterListField] $d[eligibleVoterListEquals] $d[eligibleVoterListEnforce]</li>"; 
}
?>

<h1>New Petition</h1>
<form method='post'>
  web_short_name <input name='web_short_name' required>
  web_color <input name='web_color' required>
  petition_name <input name='petition_name' required>
  <input type='submit'>
</form>

<?PHP
include_once('footer.php');
?>
