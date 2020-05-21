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
?>

<h1>Petitions</h1>
<?PHP
$q="SELECT * FROM petitions where group_id = '$group_id'";
$r = $petition->query($q);
while($d = mysqli_fetch_array($r)){
 echo "<li>$d[petition_id] $d[web_short_name] $d[web_color] $d[group_id] $d[petition_name] $d[eligibleVoterListField] $d[eligibleVoterListEquals] $d[eligibleVoterListEnforce]</li>"; 
}
?>

<?PHP
include_once('footer.php');
?>
