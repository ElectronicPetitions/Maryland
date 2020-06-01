<?PHP 
include_once('security.php');
include_once('/var/www/secure.php'); //outside webserver
if (isset($_GET['override'])){
  $id = $_GET['override'];
  $petition->query("update signatures set signature_status = 'verified' where id = '$id' ");
  header('Location: report.php');
}
if (isset($_GET['delete'])){
  $id = $_GET['delete'];
  $petition->query("update signatures set signature_status = 'deleted' where id = '$id' ");
  header('Location: report.php');
}
if (isset($_GET['review'])){
  $id = $_GET['review'];
  $petition->query("update signatures set signature_status = 'review_requested' where id = '$id' ");
  header('Location: report.php');
}
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
<style>
  body { background-color:lightgrey; }
  fieldset{ border: solid 1px lightblue; background-color:white; margin:10px; padding:10px; }
  legend{ border: solid 1px blue; background-color:white; margin:10px; padding:10px; }
  td{ white-space: pre; }
</style>
<form id='form3' name='form3' method='POST' action='printer.php'>
<?PHP
  if($_COOKIE['level'] == 'admin'){
    $q="SELECT * FROM petitions where admin_status = 'approved' ";
  }else{
    $q="SELECT * FROM petitions where group_id = '$group_id' and admin_status = 'approved'";
  }
$r = $petition->query($q);
while($d = mysqli_fetch_array($r)){
  echo "<fieldset style='background-color:$d[web_color];'><legend style='background-color:white;'>$d[petition_name] - Unprinted</legend>
  <a onclick=\"javascript:checkAll('form3', true);\" href=\"javascript:void();\">Check All</a>
  <a onclick=\"javascript:checkAll('form3', false);\" href=\"javascript:void();\">Uncheck All</a>
  <input type='submit' value='PRINT'>";
  echo "<table border='1' cellpadding='0' cellspacing='5'>";
  unset($hide);
  $hide = array();
  $pID = $d['petition_id'];
  $q2="SELECT * FROM signatures where petition_id = '$pID' and printed_status = '' and signature_status <> 'deleted' order by signature_status, id desc";
  $r2 = $petition->query($q2);
  while($d2 = mysqli_fetch_array($r2)){
    if ($d2['signature_status'] == 'verified'){
      echo "<tr><td><input type='checkbox' name='print[".$d2[id]."]'></td><td>$d2[ip_address]</td><td>$d2[date_time_signed]</td><td>$d2[signed_name_as]</td><td>$d2[signed_name_as_circulator]</td><td>$d2[contact_phone]</td><td>$d2[signature_status]-<a href='?review=$d2[id]'>Flag for Review</a></td><td>$d2[printed_status]</td></tr>";
    }else{
      echo "<tr><td><a href='?override=$d2[id]'>Override</a> or <a href='?delete=$d2[id]'>Delete</a></td><td>$d2[ip_address]</td><td>$d2[date_time_signed]</td><td>$d2[signed_name_as]</td><td>$d2[signed_name_as_circulator]</td><td>$d2[contact_phone]</td><td>$d2[signature_status]</td><td>$d2[printed_status]</td></tr>";
    }
  }
  echo '</table></fieldset>';
}
    ?>
</form>

<form id='form2' name='form2' method='POST' action='printer.php'>

<?PHP
  if($_COOKIE['level'] == 'admin'){
    $q="SELECT * FROM petitions where admin_status = 'approved' ";
  }else{
    $q="SELECT * FROM petitions where group_id = '$group_id' and admin_status = 'approved' ";
  }
$r = $petition->query($q);
while($d = mysqli_fetch_array($r)){
  echo "<fieldset style='background-color:$d[web_color];'><legend style='background-color:white;'>$d[petition_name] - Printed</legend>
  <a onclick=\"javascript:checkAll('form2', true);\" href=\"javascript:void();\">Check All</a>
  <a onclick=\"javascript:checkAll('form2', false);\" href=\"javascript:void();\">Uncheck All</a>
  <input type='submit' value='PRINT'>";
  echo "<table border='1' cellpadding='0' cellspacing='5'>";
  unset($hide);
  $hide = array();
  $pID = $d['petition_id'];
  $q2="SELECT * FROM signatures where petition_id = '$pID' and printed_status <> '' and signature_status <> 'deleted' order by signature_status, id desc";
  $r2 = $petition->query($q2);
  while($d2 = mysqli_fetch_array($r2)){
    if ($d2['signature_status'] == 'verified'){
      echo "<tr><td><input type='checkbox' name='print[".$d2[id]."]'></td><td>$d2[ip_address]</td><td>$d2[date_time_signed]</td><td>$d2[signed_name_as]</td><td>$d2[signed_name_as_circulator]</td><td>$d2[contact_phone]</td><td>$d2[signature_status]-<a href='?review=$d2[id]'>Flag for Review</a></td><td>$d2[printed_status]</td></tr>";
    }else{
      echo "<tr><td><a href='?override=$d2[id]'>Override</a> or <a href='?delete=$d2[id]'>Delete</a></td><td>$d2[ip_address]</td><td>$d2[date_time_signed]</td><td>$d2[signed_name_as]</td><td>$d2[signed_name_as_circulator]</td><td>$d2[contact_phone]</td><td>$d2[signature_status]</td><td>$d2[printed_status]</td></tr>";
    }
  }
  echo '</table></fieldset>';
}
?>
</form>

<?PHP
include_once('footer.php');
?>
