<li role='presentation' style='background-color:orange;' <?PHP if($_SERVER['SCRIPT_NAME'] == '/admin/search.php'){ echo "class='active'"; } ?> ><a href="search.php">Search</a></li>
<li role='presentation' style='background-color:orange;' <?PHP if($_SERVER['SCRIPT_NAME'] == '/admin/analytics.php'){ echo "class='active'"; } ?> ><a href="analytics.php">Automated Analytics</a></li>
<?PHP
$q="SELECT id FROM follow_up where status = 'NEW'";
$r = $petition->query($q);
$d = mysqli_fetch_array($r);
if (intval($d['id']) > 0){
?>
<li role='presentation' style='background-color:orange;' <?PHP if($_SERVER['SCRIPT_NAME'] == '/admin/follow_up_emails.php'){ echo "class='active'"; } ?> ><a href="follow_up_emails.php">Send Follow Up</a></li>
<?PHP } ?>
<li role='presentation' style='background-color:orange;' <?PHP if($_SERVER['SCRIPT_NAME'] == '/admin/follow_up_success.php'){ echo "class='active'"; } ?> ><a href="follow_up_success.php">Follow Up Status</a></li>
