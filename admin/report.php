<?PHP 
include_once('security.php');
include_once('header.php');
slack_general('ADMIN: Reports Loaded ('.$_COOKIE['name'].') ('.$_COOKIE['level'].')','md-petition');
$group_id = $_COOKIE['group_id'];
$q="SELECT * FROM petitions where group_id = '$group_id'";
$r = $petition->query($q);
while($d = mysqli_fetch_array($r)){
  echo "<h1>$d[petition_name]</h1>";
 $pID = $d['petition_id'];
  $q2="SELECT * FROM signatures where group_id = '$group_id'";
  $r2 = $petition->query($q2);
  while($d2 = mysqli_fetch_array($r2)){
    echo "<li>$d[date_time_signed] $d[signed_name_as] $d[signed_name_as_circulator] $d[contact_phone]</li>";
  }
}

include_once('footer.php');
?>
