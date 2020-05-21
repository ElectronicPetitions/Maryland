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
slack_general('ADMIN: admin manager ('.$_COOKIE['name'].') ('.$_COOKIE['level'].')','md-petition');
?>

<h1>admin manager</h1>



<pre>
<?PHP print_r($_COOKIE); ?>
</pre>


<?PHP
include_once('footer.php');
?>
