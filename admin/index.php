<?PHP 
include_once('../slack.php');
include_once('security.php');
if ($_COOKIE['level'] == 'user'){
  slack_general('ADMIN: Redirect User Home ('.$_COOKIE['name'].') ('.$_COOKIE['level'].')','md-petition');
  header('Location: user_home.php');
}
if ($_COOKIE['level'] == 'manager'){
  slack_general('ADMIN: Redirect Manager Home ('.$_COOKIE['name'].') ('.$_COOKIE['level'].')','md-petition');
  header('Location: manager_home.php');
}

include_once('header.php');
if(isset($_GET['approve'])){
  $id = $_GET['approve'];
  $petition->query("update petitions set admin_status = 'approved' where petition_id = '$id' ");
}
slack_general('ADMIN: Home Page Loaded ('.$_COOKIE['name'].') ('.$_COOKIE['level'].')','md-petition');
?>

<h1>Admin Home</h1>
<div id="chartContainer1" style="height: 400px; width: 100%; margin: 0px auto;"></div>
<h1>Users</h1>
<?PHP
$q="SELECT * FROM users";
$r = $petition->query($q);
while($d = mysqli_fetch_array($r)){
  $alert='';
  if ($d[pass] == ''){
    $alert='NEEDS PASSWORD RESET';    
  }
 echo "<li>$d[id] $d[email] $d[name] $d[group_id] $d[sec_level] $alert</li>"; 
}
?>

<h1>New Petitions</h1>
<?PHP
$q="SELECT * FROM petitions where admin_status='new'";
$r = $petition->query($q);
while($d = mysqli_fetch_array($r)){
 echo "<li><a href='?approve=$d[petition_id]'>$d[petition_id] $d[web_short_name] $d[web_color] $d[group_id] $d[petition_name] $d[eligibleVoterListField] $d[eligibleVoterListEquals] $d[eligibleVoterListEnforce]</a></li>"; 
}
?>


<h1>Approved Petitions</h1>
<?PHP
$q="SELECT * FROM petitions where admin_status = 'approved'";
$r = $petition->query($q);
while($d = mysqli_fetch_array($r)){
 echo "<li>$d[petition_id] $d[web_short_name] $d[web_color] $d[group_id] $d[petition_name] $d[eligibleVoterListField] $d[eligibleVoterListEquals] $d[eligibleVoterListEnforce]</li>"; 
}
?>


<h1>Groups</h1>
<?PHP
$q="SELECT * FROM groups";
$r = $petition->query($q);
while($d = mysqli_fetch_array($r)){
 echo "<li>$d[id] $d[name]</li>"; 
}
?>




<h1>Website</h1>
<?PHP
$q="SELECT * FROM website_text";
$r = $petition->query($q);
while($d = mysqli_fetch_array($r)){
 echo "<li>$d[id] $d[text_title]</li>"; 
}
?>

<?PHP
	$pID = 1;
	//echo "<div id=\"chartContainer$pID\" style=\"height: 400px; width: 100%; margin: 0px auto;\"></div>";
	$chart='';
	$chart2='';
	$chart3='';
	$q3 = "SELECT just_date FROM signatures where just_date <> '0000-00-00' group by just_date";
	//echo "<li>$q3</li>";
	$r3 = $petition->query($q3);
	$total=0;
	$goal = $d['signature_goal'];
	if ($goal == 0){
		$goal = 10000;
	}
	while ($d3 = mysqli_fetch_array($r3)){
	  $just_date = $d3['just_date'];
	  $q2 = "SELECT * FROM signatures where just_date = '$just_date' and signature_status = 'verified'  ";
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
			text: "MD-Petition.com Signature Tracker"
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
		},{
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

	<?PHP $javascript .= ob_get_clean(); ?>



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

<?PHP


include_once('footer.php');
?>
