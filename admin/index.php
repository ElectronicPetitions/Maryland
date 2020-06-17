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
if ($_POST['name']){	
	$name 		= $petition->real_escape_string($_POST['name']);
	$email 		= $petition->real_escape_string($_POST['email']);
	$sec_level 	= $petition->real_escape_string($_POST['sec_level']);
	$group_id 	= $petition->real_escape_string($_POST['group_id']);
	$petition_id 	= $petition->real_escape_string($_POST['petition_id']);
	$q = "insert into users (name, email, sec_level, group_id, petition_id) values ('$name','$email','$sec_level','$group_id','$petition_id') ";
	$petition->query($q);
	slack_general_admin('SQL: '.$q,'md-petition-signed');
	  include_once('../email.php');
	  $pass = rand(1000,9999);
          $salt = md5(rand(1000,9999));
          $hash = md5($pass.$salt);
          $encrypted = $hash.':'.$salt;
	  $subject = 'MD Petition Login';
	  $body = 'Login with '.$email.' and your new password '.$pass.' at https://www.md-petition.com/admin/login.php';
          meps_mail($email,$body,$subject);
          $petition->query("update users set pass = '$encrypted' WHERE email = '$email'");
          echo "<h1>Password has been Sent.</h1>";
	  slack_general_admin('DEBUG: '.$body,'md-petition-signed');
}
if(isset($_GET['approve'])){
  $id = $_GET['approve'];
  $petition->query("update petitions set admin_status = 'approved' where petition_id = '$id' ");
}
slack_general('ADMIN: Home Page Loaded ('.$_COOKIE['name'].') ('.$_COOKIE['level'].')','md-petition');
?>

<h1>Admin Home</h1>
<div id="chartContainer1" style="height: 400px; width: 100%; margin: 0px auto;"></div>
<h1>Users</h1>
<form method='post'>
  <table>
    	<tr><td>Name</td><td><input name='name' required></td></tr>
	<tr><td>E-Mail</td><td><input name='email' required></td></tr>	  
	<tr><td>Security Level</td><td><input name='sec_level' required></td></tr>
	<tr><td>Group ID</td><td><input name='group_id' required></td></tr>
	<tr><td>Petition ID</td><td><input name='petition_id' required></td></tr>
	<tr><td></td><td><input type='submit' value='New User'></td></tr>
  </table>
</form>
<?PHP
$q="SELECT * FROM users";
$r = $petition->query($q);
while($d = mysqli_fetch_array($r)){
  $alert='';
  if ($d[pass] == ''){
    $alert='NEEDS PASSWORD RESET';    
  }
 echo "<li>ID $d[id] EM $d[email] NM $d[name] GI $d[group_id] PI $d[petition_id] SL $d[sec_level] $alert</li>"; 
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
	  $q2 = "SELECT * FROM follow_up where date_sent = '$just_date'  ";
	  $r2 = $petition->query($q2);	
	  $count  = mysqli_num_rows($r2);
	  $chart4 .=  '{ label: "'.$just_date.'", y: '.intval($goal).' }, ';
	}
	$chart = rtrim(trim($chart), ",");
	$chart2 = rtrim(trim($chart2), ",");
	$chart3 = rtrim(trim($chart3), ",");
	$chart4 = rtrim(trim($chart4), ",");
	
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
		},{
			type: "column",
			visible: true,
			showInLegend: true,
			yValueFormatString: "#####",
			name: "Follow Up E-Mails",
			dataPoints: [
				<?PHP echo $chart4; ?>
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
<script src="../files/canvasjs.min.js"></script>
<?PHP


include_once('footer.php');
?>
