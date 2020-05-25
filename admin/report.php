<?PHP 
include_once('security.php');
include_once('header.php');
slack_general('ADMIN: Reports Loaded ('.$_COOKIE['name'].') ('.$_COOKIE['level'].')','md-petition');
$group_id = $_COOKIE['group_id'];
?>
<script>
  function checkAll(formname, checktoggle)
{
  var checkboxes = new Array(); 
  checkboxes = document[formname].getElementsByTagName('input');
 
  for (var i=0; i<checkboxes.length; i++)  {
    if (checkboxes[i].type == 'checkbox')   {
      checkboxes[i].checked = checktoggle;
    }
  }
}
</script>
<form id='form3' name='form3' method='POST' action='printer.php'>
<a onclick="javascript:checkAll('form3', true);" href="javascript:void();">check all</a>
<a onclick="javascript:checkAll('form3', false);" href="javascript:void();">uncheck all</a>
<input type='submit' value='PRINT'>
<?PHP
  if($_COOKIE['level'] == 'admin'){
    $q="SELECT * FROM petitions where admin_status = 'approved'";
  }else{
    $q="SELECT * FROM petitions where group_id = '$group_id' and admin_status = 'approved'";
  }
$r = $petition->query($q);
while($d = mysqli_fetch_array($r)){
  echo "<h1>$d[petition_name]</h1>";
  echo "<table border='1' cellpadding='0' cellspacing='5'>";
  unset($hide);
  $hide = array();
  $pID = $d['petition_id'];
  $q2="SELECT * FROM signatures where petition_id = '$pID' order by id desc";
  $r2 = $petition->query($q2);
  while($d2 = mysqli_fetch_array($r2)){
    if (!in_array($d2['VTRID'], $hide)) {
      $hide[] = $d2['VTRID'];
      echo "<tr><td><input type='checkbox' name='print[".$d2[id]."]'></td><td>$d2[ip_address]</td><td>$d2[date_time_signed]</td><td>$d2[signed_name_as]</td><td>$d2[signed_name_as_circulator]</td><td>$d2[contact_phone]</td><td>$d2[signature_status]</td><td>$d2[printed_status]</td></tr>";
    }
  }
  echo '</table>';
}
?>
</form>
<?PHP
include_once('footer.php');
?>
