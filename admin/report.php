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
$javascript='';
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
<?PHP
if($_COOKIE['level'] == 'admin'){
    $q="SELECT * FROM petitions where admin_status = 'approved' order by admin_sort DESC ";
}else{
    $q="SELECT * FROM petitions where group_id = '$group_id' and admin_status = 'approved'";
}
//echo "<li>$q</li>";
$r = $petition->query($q);
while($d = mysqli_fetch_array($r)){
	$pID = $d['petition_id'];
	echo "<div id=\"chartContainer$pID\" style=\"height: 400px; width: 100%; margin: 0px auto;\"></div>";
	$chart='';
	$chart2='';
	$chart3='';
	$q3 = "SELECT just_date FROM signatures where petition_id = '$pID' and just_date <> '0000-00-00' group by just_date";
	//echo "<li>$q3</li>";
	$r3 = $petition->query($q3);
	$total=0;
	$goal = $d['signature_goal'];
	if ($goal == 0){
		$goal = 10000;
	}
	while ($d3 = mysqli_fetch_array($r3)){
	  $just_date = $d3['just_date'];
	  $q2 = "SELECT * FROM signatures where petition_id = '$pID' and just_date = '$just_date' and signature_status = 'verified'  ";
	  //echo "<li>$q2</li>";
	  $r2 = $petition->query($q2);
	  $count  = mysqli_num_rows($r2);
	  $chart .=  '{ label: "'.$just_date.'", y: '.intval($count).' }, ';
	  $total = $total + intval($count);
	  $chart2 .=  '{ label: "'.$just_date.'", y: '.intval($total).' }, ';
	  $goal = $goal - intval($count);
	  $chart3 .=  '{ label: "'.$just_date.'", y: '.intval($goal).' }, ';
	}
	$chart = rtrim(trim($chart), ",");
	$chart2 = rtrim(trim($chart2), ",");
	$chart3 = rtrim(trim($chart3), ",");
	
	ob_start(); ?>

	var chart<?PHP echo $pID;?> = new CanvasJS.Chart("chartContainer<?PHP echo $pID;?>", {
		theme:"light2",
		animationEnabled: true,
		exportEnabled: true,
		title:{
			text: "<?PHP echo $d['petition_name'];?> MD-Petition.com Signature Tracker"
		},
		axisY :{
			includeZero: false,
			title: "Number of Signatures",
			suffix: "",
	    scaleBreaks: {
					autoCalculate: true
				}
		},
		toolTip: {
			shared: "true"
		},
		legend:{
			cursor:"pointer",
			itemclick : toggleDataSeries
		},
		data: [{
			type: "line",
			visible: true,
			showInLegend: true,
			yValueFormatString: "#####",
			name: "Total Signatures Count",
			dataPoints: [
				<?PHP echo $chart2; ?>
			]
		},<?PHP if(1 == 2){ ?>{
			type: "line",
			visible: true,
			showInLegend: true,
			yValueFormatString: "#####",
			name: "Signatures Remaining to Goal",
			dataPoints: [
				<?PHP echo $chart3; ?>
			]
		},<?PHP } ?>{
			type: "column",
			visible: true,
			showInLegend: true,
			yValueFormatString: "#####",
			name: "New Daily Signatures",
			dataPoints: [
				<?PHP echo $chart; ?>
			]
		}]
	}


				      );
	chart<?PHP echo $pID;?>.render();

	<?PHP $javascript .= ob_get_clean();
}
?>















<form id='form3' name='form3' method='POST' action='printer.php'>
<?PHP
  if($_COOKIE['level'] == 'admin'){
    $q="SELECT * FROM petitions where admin_status = 'approved' ";
  }else{
    $q="SELECT * FROM petitions where group_id = '$group_id' and admin_status = 'approved'";
  }
$r = $petition->query($q);
while($d = mysqli_fetch_array($r)){
  echo "<fieldset style='border: solid 1px $d[web_color];'><legend style='background-color:white;'>$d[petition_name] - Unprinted</legend>
  <a onclick=\"javascript:checkAll('form3', true);\" href=\"javascript:void();\">Check All</a>
  <a onclick=\"javascript:checkAll('form3', false);\" href=\"javascript:void();\">Uncheck All</a>
  <input type='submit' value='PRINT'>";
  echo "<table border='1' cellpadding='0' cellspacing='5'>";
  unset($hide);
  $hide = array();
  $pID = $d['petition_id'];
  $q2="SELECT * FROM signatures where petition_id = '$pID' and printed_status = '' and signature_status = 'verified' order by signature_status, id desc";
  $r2 = $petition->query($q2);
  while($d2 = mysqli_fetch_array($r2)){
    if ($d2['signature_status'] == 'verified'){
	    $id = $d2['id'];
      echo "<tr>
      <td><input type='checkbox' name='print[".$id."]'></td><td>$d2[ip_address]</td><td>$d2[date_time_signed]</td><td>$d2[VoterList_table]</td><td>$d2[signed_name_as]</td><td>$d2[signed_name_as_circulator]</td><td>$d2[contact_phone]</td><td>$d2[signature_status]-<a href='?review=$d2[id]'>Flag for Review</a></td><td>$d2[printed_status]</td></tr>";
    }else{
      echo "<tr>
      <td><a href='?override=$d2[id]'>Override</a> or <a href='?delete=$d2[id]'>Delete</a></td><td>$d2[ip_address]</td><td>$d2[date_time_signed]</td><td>$d2[VoterList_table]</td><td>$d2[signed_name_as]</td><td>$d2[signed_name_as_circulator]</td><td>$d2[contact_phone]</td><td>$d2[signature_status]</td><td>$d2[printed_status]</td></tr>";
    }
  }
  echo '</table></fieldset>';

	
	
}
    ?>
</form>


<?PHP if($_COOKIE['level'] == 'admin'){ ?>

<form id='form5' name='form5' method='POST' action='printer.php'>
<?PHP
  if($_COOKIE['level'] == 'admin'){
    $q="SELECT * FROM petitions where admin_status = 'approved' ";
  }else{
    $q="SELECT * FROM petitions where group_id = '$group_id' and admin_status = 'approved'";
  }
$r = $petition->query($q);
while($d = mysqli_fetch_array($r)){
  echo "<fieldset style='border: solid 1px $d[web_color];'><legend style='background-color:white;'>$d[petition_name] - Flagged for Deletion or Override</legend>
  <a onclick=\"javascript:checkAll('form3', true);\" href=\"javascript:void();\">Check All</a>
  <a onclick=\"javascript:checkAll('form3', false);\" href=\"javascript:void();\">Uncheck All</a>
  <input type='submit' value='PRINT'>";
  echo "<table border='1' cellpadding='0' cellspacing='5'>";
  unset($hide);
  $hide = array();
  $pID = $d['petition_id'];
  $q2="SELECT * FROM signatures where petition_id = '$pID' and printed_status = '' and signature_status <> 'deleted' and signature_status <> 'verified' order by signature_status, id desc";
  $r2 = $petition->query($q2);
  while($d2 = mysqli_fetch_array($r2)){
    if ($d2['signature_status'] == 'verified'){
      echo "<tr>
      <td><input type='checkbox' name='print[".$d2[id]."]'></td><td>$d2[ip_address]</td><td>$d2[date_time_signed]</td><td>$d2[VoterList_table]</td><td>$d2[signed_name_as]</td><td>$d2[signed_name_as_circulator]</td><td>$d2[contact_phone]</td><td>$d2[signature_status]-<a href='?review=$d2[id]'>Flag for Review</a></td><td>$d2[printed_status]</td></tr>";
    }else{
      echo "<tr>
      <td><a href='?override=$d2[id]'>Override</a> or <a href='?delete=$d2[id]'>Delete</a></td><td>$d2[ip_address]</td><td>$d2[date_time_signed]</td><td>$d2[VoterList_table]</td><td>$d2[signed_name_as]</td><td>$d2[signed_name_as_circulator]</td><td>$d2[contact_phone]</td><td>$d2[signature_status]</td><td>$d2[printed_status]</td></tr>";
    }
  }
  echo '</table></fieldset>';

	
	
}
    ?>
</form>

<?PHP } ?>


<form id='form2' name='form2' method='POST' action='printer.php'>

<?PHP
  if($_COOKIE['level'] == 'admin'){
    $q="SELECT * FROM petitions where admin_status = 'approved' ";
  }else{
    $q="SELECT * FROM petitions where group_id = '$group_id' and admin_status = 'approved' ";
  }
$r = $petition->query($q);
while($d = mysqli_fetch_array($r)){
  echo "<fieldset style='border: solid 1px $d[web_color];'><legend style='background-color:white;'>$d[petition_name] - Printed</legend>
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
      echo "<tr><td><input type='checkbox' name='print[".$d2[id]."]'></td><td>$d2[ip_address]</td><td>$d2[date_time_signed]</td><td>$d2[VoterList_table]</td><td>$d2[signed_name_as]</td><td>$d2[signed_name_as_circulator]</td><td>$d2[contact_phone]</td><td>$d2[signature_status]-<a href='?review=$d2[id]'>Flag for Review</a></td><td>$d2[printed_status]</td></tr>";
    }else{
      echo "<tr><td><a href='?override=$d2[id]'>Override</a> or <a href='?delete=$d2[id]'>Delete</a></td><td>$d2[ip_address]</td><td>$d2[date_time_signed]</td><td>$d2[VoterList_table]</td><td>$d2[signed_name_as]</td><td>$d2[signed_name_as_circulator]</td><td>$d2[contact_phone]</td><td>$d2[signature_status]</td><td>$d2[printed_status]</td></tr>";
    }
  }
  echo '</table></fieldset>';
 
	
}
?>
</form>





<script>
window.onload = function () {

<?PHP echo $javascript;?>

function toggleDataSeries(e) {
	if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible ){
		e.dataSeries.visible = false;
	} else {
		e.dataSeries.visible = true;
	}
	chart.render();
}

}
</script>



<script src="../files/canvasjs.min.js"></script>
<?PHP
include_once('footer.php');
?>
