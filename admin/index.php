<?PHP 
include_once('../slack.php');
include_once('security.php');
if ($_COOKIE['level'] == 'user'){
  slack_general('ADMIN: Redirect User Home ('.$_COOKIE['name'].') ('.$_COOKIE['level'].')','md-petition');
  header('Location user_home.php');
}
if ($_COOKIE['level'] == 'manager'){
  slack_general('ADMIN: Redirect Manager Home ('.$_COOKIE['name'].') ('.$_COOKIE['level'].')','md-petition');
  header('Location manager_home.php');
}

include_once('header.php');

slack_general('ADMIN: Home Page Loaded ('.$_COOKIE['name'].') ('.$_COOKIE['level'].')','md-petition');
?>

<h1>Admin Home</h1>

<h1>Users</h1>
<?PHP
$q="SELECT * FROM users";
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

<h1>Petitions</h1>
<?PHP
$q="SELECT * FROM petitions";
$r = $petition->query($q);
while($d = mysqli_fetch_array($r)){
 echo "<li>$d[petition_id] $d[web_short_name] $d[web_color] $d[group_id] $d[petition_name] $d[eligibleVoterListField] $d[eligibleVoterListEquals] $d[eligibleVoterListEnforce]</li>"; 
}
?>


<h1>Website</h1>
<?PHP
$q="SELECT * FROM website_text";
$r = $petition->query($q);
while($d = mysqli_fetch_array($r)){
 echo "<li>$d[id] $d[text_title]</li>"; 
}
?>


<?PHP
include_once('footer.php');
?>
