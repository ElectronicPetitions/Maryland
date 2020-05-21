<?PHP 

include_once('security.php');

include_once('header.php');
slack_general('ADMIN: Group Manager Loaded ('.$_COOKIE['name'].') ('.$_COOKIE['level'].')','md-petition');
?>

<h1>Group Manager</h1>



<pre>
<?PHP print_r($_COOKIE); ?>
</pre>


<?PHP
include_once('footer.php');
?>
