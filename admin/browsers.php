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
<h1>SEO Known Browsers count hits over 100</h1>
<ol>
<?PHP
$q="SELECT browser_string,COUNT(*) as count FROM presign group by browser_string";
$r = $petition->query($q);
while($d = mysqli_fetch_array($r)){ 
  if ($d['count'] > 100){
    echo "<li>$d[count] $d[browser_string]</li>"; 
  }
}
?>
</ol>

<?PHP
include_once('footer.php');
?>
