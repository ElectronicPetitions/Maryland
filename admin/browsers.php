<?PHP 
include_once('../slack.php');
include_once('security.php');
if ($_COOKIE['level'] != 'admin'){
  slack_general('ADMIN: Redirect NonAdmin ('.$_COOKIE['name'].') ('.$_COOKIE['level'].')','md-petition');
  header('Location: index.php');
}
include_once('header.php');
slack_general('ADMIN: browser list loaded ('.$_COOKIE['name'].') ('.$_COOKIE['level'].')','md-petition');
?>
<h1>SEO Known Browsers</h1>
<ol>
<?PHP
$q="SELECT distinct browser_string FROM presign order by browser_string";
$r = $petition->query($q);
while($d = mysqli_fetch_array($r)){ 
    echo "<li>$d[browser_string]</li>"; 
}
?>
</ol>

<?PHP
include_once('footer.php');
?>
