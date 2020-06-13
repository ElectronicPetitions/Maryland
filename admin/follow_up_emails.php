<?PHP
include_once('../email.php');
$base_message = "I just wanted to take a second and follow up with your visit to md-petition.com and see if you needed anything, or had any questions.";

// USAGE meps_mail('Patrick <baltimorehacker@gmail.com>','','Petition Follow-Up');

$q="SELECT * FROM follow_up, presign, petitions where presign.php_session_id = follow_up.php_session_id and follow_up.petition_id = petitions.petition_id and follow_up.status = 'NEW'";

echo "<li>$q</li>";
$r = $petition->query($q);
while($d = mysqli_fetch_array($r)){
  echo "<pre>";
  $row = $d;
  print_r($row);
  echo "</pre>";
}

?>
