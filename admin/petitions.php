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
  header('Location: petitions.php');
}
if(isset($_POST['petition_id']) && isset($_POST['petition_name']) ){ // edit
  $petition_id               = $petition->real_escape_string($_POST['petition_id']);
  $web_short_name               = $petition->real_escape_string($_POST['web_short_name']);
  $web_color                    = $petition->real_escape_string($_POST['web_color']);
  $web_color_text               = $petition->real_escape_string($_POST['web_color_text']);
  $petition_name                = $petition->real_escape_string($_POST['petition_name']);
  $petition_sign_text_box       = $petition->real_escape_string($_POST['petition_sign_text_box']);
  $petition_circulator_text_box = $petition->real_escape_string($_POST['petition_circulator_text_box']);
  $eligibleVoterListWarning     = $petition->real_escape_string($_POST['eligibleVoterListWarning']);
  $eligibleVoterListEnforce     = $petition->real_escape_string($_POST['eligibleVoterListEnforce']);
  $eligibleVoterListField       = strtoupper($petition->real_escape_string($_POST['eligibleVoterListField']));
  $eligibleVoterListEquals      = $petition->real_escape_string($_POST['eligibleVoterListEquals']);
  $eligibleVoterSigMatch        = $petition->real_escape_string($_POST['eligibleVoterSigMatch']);
  $signature_goal               = $petition->real_escape_string($_POST['signature_goal']);
  
  // custom landing page - paid feature one day?
  $tab_name         = $petition->real_escape_string($_POST['tab_name']);
  $text_title       = $petition->real_escape_string($_POST['text_title']);
  $text_block       = $petition->real_escape_string($_POST['text_block']);
  $logo_url         = $petition->real_escape_string($_POST['logo_url']);
  
  $petition->query("update petitions set web_color_text='$web_color_text', signature_goal='$signature_goal', logo_url='$logo_url', text_block='$text_block', text_title='$text_title', tab_name='$tab_name', eligibleVoterSigMatch='$eligibleVoterSigMatch', eligibleVoterListWarning='$eligibleVoterListWarning', web_short_name='$web_short_name', web_color='$web_color', petition_name='$petition_name', petition_sign_text_box='$petition_sign_text_box', petition_circulator_text_box='$petition_circulator_text_box', eligibleVoterListEnforce='$eligibleVoterListEnforce', eligibleVoterListField='$eligibleVoterListField', eligibleVoterListEquals='$eligibleVoterListEquals' where petition_id = '$petition_id' ");
  header('Location: petitions.php');
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
  <table>
    <tr><td><b>Required</b></td><td>&nbsp;</td></tr> 
    <tr><td>Web Short Name*</td><td><input name='web_short_name' value='<?PHP echo $d['web_short_name'];?>' required></td></tr>
    <tr><td>Web Color Background</td><td><input type="color" name='web_color' value='<?PHP echo $d['web_color'];?>' required></td></tr> 
    <tr><td>Web Color Text</td><td><input type="color" name='web_color' value='<?PHP echo $d['web_color'];?>' required></td></tr>
    <tr><td>Petition Name</td><td><input name='petition_name' value='<?PHP echo $d['petition_name'];?>' required></td></tr>
    <tr><td>Petition Sign Text Box</td><td><textarea rows='5' cols='50' name='petition_sign_text_box' required><?PHP echo $d['petition_sign_text_box'];?></textarea></td></tr>   
    <tr><td>Petition Circulator Text Box</td><td><textarea rows='5' cols='50' name='petition_circulator_text_box' required><?PHP echo $d['petition_circulator_text_box'];?></textarea></td></tr>
    <tr><td>eligibleVoterList Enforce</td><td><select name='eligibleVoterListEnforce'><option><?PHP echo $d['eligibleVoterListEnforce'];?></option><option>NO</option><option>YES</option></select></td></tr>   
    <tr><td>eligibleVoterList Field</td><td><input name='eligibleVoterListField' value='<?PHP echo $d['eligibleVoterListField'];?>' required></td></tr>
    <tr><td>eligibleVoterList Equals</td><td><input name='eligibleVoterListEquals' value="<?PHP echo $d['eligibleVoterListEquals'];?>" required></td></tr>   
    <tr><td>eligibleVoterList Warning</td><td><textarea rows='5' cols='50' name='eligibleVoterListWarning' required><?PHP echo $d['eligibleVoterListWarning'];?></textarea></td></tr>
    <tr><td>VoterList Signature Match Required</td><td><select name='eligibleVoterSigMatch' required><option><?PHP echo $d['eligibleVoterSigMatch'];?></option><option>NO</option><option>YES</option></select></td></tr>   
    <tr><td><b>Not Required</b></td><td>&nbsp;</td></tr> 
    <tr><td>Signature Goal</td><td><input name='signature_goal' value="<?PHP echo $d['signature_goal'];?>"></td></tr> 
    <tr><td>Landing Page Title</td><td><input name='tab_name' value="<?PHP echo $d['tab_name'];?>"></td></tr>   
    <tr><td>Landing Page Header</td><td><input name='text_title' value="<?PHP echo $d['text_title'];?>"></td></tr>   
    <tr><td>Landing Page Body</td><td><textarea rows='5' cols='50' name='text_block'><?PHP echo $d['text_block'];?></textarea></td></tr>
    <tr><td>Logo URL</td><td><input name='logo_url' value="<?PHP echo $d['logo_url'];?>"></td></tr>   
       
    
    
    <tr><td></td><td><input type='submit'></td></tr>
  </table>
</form>
* changes may break already sent invites!

<?PHP 
 } 
?>
<h1>New Petition</h1>
<form method='post'>
  web_short_name <input name='web_short_name' required>
  web_color <input type="color" name='web_color' required>
  petition_name <input name='petition_name' required>
  <input type='submit'>
</form>
<br><br><br>
<?PHP
include_once('footer.php');
?>
