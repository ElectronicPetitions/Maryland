<?PHP 
include_once('bots.php');
include_once('../slack.php');
include_once('security.php');
include_once('/var/www/secure.php'); //outside webserver
include_once('functions.php');
include_once('header.php');
$LASTNAME='';
if ($_POST['LASTNAME']){
  $LASTNAME=$_POST['LASTNAME'];
}
if($LASTNAME != ''){
  $q = "select * from VoterList where LASTNAME = '$LASTNAME' ";
  echo "$q";
  $r = $petition->query($q);
  while ($d = mysqli_fetch_array($r,MYSQLI_ASSOC)){
  echo "<li>$d[FIRSTNAME] House Number: $d[HOUSE_NUMBER] Zip Code: $d[RESIDENTIALZIP5]</li>";
  }
}
?>
<form method='POST'>
Last Name <input name='LASTNAME'><input type='submit'>
</form>

<?


include_once('footer.php');
