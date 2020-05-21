<?PHP 
include_once('security.php');
include_once('header.php');
slack_general('ADMIN: Reports Loaded ('.$_COOKIE['name'].') ('.$_COOKIE['level'].')','md-petition');
$group_id = $_COOKIE['group_id'];
$q="SELECT * FROM petitions where group_id = '$group_id' and admin_status = 'approved'";
$r = $petition->query($q);
$hide = array();
while($d = mysqli_fetch_array($r)){
  echo "<h1>$d[petition_name]</h1>";
  $pID = $d['petition_id'];
  $q2="SELECT * FROM signatures where petition_id = '$pID' order by id desc";
  $r2 = $petition->query($q2);
  while($d2 = mysqli_fetch_array($r2)){
    if (!in_array($d2['VTRID'], $hide)) {
      $hide[] = $d2['VTRID'];
      echo "<li>$d2[date_time_signed] $d2[signed_name_as] $d2[signed_name_as_circulator] $d2[contact_phone]</li>";
    }
  }
}

include_once('footer.php');
?>
