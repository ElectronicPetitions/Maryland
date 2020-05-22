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

if(empty($_POST['petition_id']) && isset($_POST['petition_name']) ){ // new
  $web_short_name = $petition->real_escape_string($_POST['web_short_name']);
  $web_color = $petition->real_escape_string($_POST['web_color']);
  $petition_name = $petition->real_escape_string($_POST['petition_name']);
  $petition->query("insert into petitions (web_short_name,web_color,group_id,petition_name) values ('$web_short_name','$web_color','$group_id','$petition_name') ");
}
if(isset($_POST['petition_id']) && isset($_POST['petition_name']) ){ // edit
  $petition_id               = $petition->real_escape_string($_POST['petition_id']);
  $web_short_name               = $petition->real_escape_string($_POST['web_short_name']);
  $web_color                    = $petition->real_escape_string($_POST['web_color']);
  $petition_name                = $petition->real_escape_string($_POST['petition_name']);
  $petition_sign_text_box       = $petition->real_escape_string($_POST['petition_sign_text_box']);
  $petition_circulator_text_box = $petition->real_escape_string($_POST['petition_circulator_text_box']);
  $eligibleVoterListEnforce     = $petition->real_escape_string($_POST['eligibleVoterListEnforce']);
  $eligibleVoterListField       = $petition->real_escape_string($_POST['eligibleVoterListField']);
  $eligibleVoterListEquals      = $petition->real_escape_string($_POST['eligibleVoterListEquals']);
  $petition->query("update petitions set web_short_name='$web_short_name', web_color='$web_color', petition_name='$petition_name', petition_sign_text_box='$petition_sign_text_box', petition_circulator_text_box='$petition_circulator_text_box', eligibleVoterListEnforce='$eligibleVoterListEnforce', eligibleVoterListField='$eligibleVoterListField', eligibleVoterListEquals='$eligibleVoterListEquals' where petition_id = '$petition_id' ");
}
?>

<h1>Petitions</h1>
<?PHP
if($_COOKIE['level'] == 'admin'){
  $q="SELECT * FROM petitions";
}else{
  $q="SELECT * FROM petitions where group_id = '$group_id'";
}
$r = $petition->query($q);
while($d = mysqli_fetch_array($r)){
 echo "<li><a href='?edit=$d[petition_id]'>EDIT</a> $d[admin_status] $d[web_short_name] $d[web_color] $d[group_id] $d[petition_name] $d[eligibleVoterListField] $d[eligibleVoterListEquals] $d[eligibleVoterListEnforce]</li>"; 
}
?>

<?PHP 
if (isset($_GET['edit'])){ 
$id = intval($_GET['edit']);
$q = "SELECT * FROM petitions where petition_id = '$id' ";
$r = $petition->query($q);
$d = mysqli_fetch_array($r);                          
?>
<h1>Edit Petition Setup</h1>
<h3>Please keep whatever text you use in a word or google doc that you control, copy and paste here.</h3>
<form method='post'>
  <input type='hidden' name='petition_id' value='<?PHP echo $id;?>'>
  web_short_name* <input name='web_short_name' value='<?PHP echo $d['web_short_name'];?>' required> 
  web_color <input name='web_color' value='<?PHP echo $d['web_color'];?>' required>
  petition_name <input name='petition_name' value='<?PHP echo $d['petition_name'];?>' required>
  petition_sign_text_box <textarea name='petition_sign_text_box' required><?PHP echo $d['petition_sign_text_box'];?></textarea>
  petition_circulator_text_box <textarea name='petition_circulator_text_box' required><?PHP echo $d['petition_circulator_text_box'];?></textarea>
  eligibleVoterListEnforce <select name='eligibleVoterListEnforce'><option><?PHP echo $d['eligibleVoterListEnforce'];?></option><option>NO</option><option>YES</option></select>  <input required>
  eligibleVoterListField <input name='eligibleVoterListField' value='<?PHP echo $d['eligibleVoterListField'];?>' required>
  eligibleVoterListEquals <input name='eligibleVoterListEquals' value='<?PHP echo $d['eligibleVoterListEquals'];?>' required>
  <input type='submit'>
</form>
* changes may break already sent invites!

<?PHP 
 } 
?>
<h1>New Petition</h1>
<form method='post'>
  web_short_name <input name='web_short_name' required>
  web_color <input name='web_color' required>
  petition_name <input name='petition_name' required>
  <input type='submit'>
</form>
<br><br><br>
<?PHP
include_once('footer.php');
?>
