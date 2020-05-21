<?PHP 

include_once('security.php');

include_once('header.php');
slack_general('ADMIN: Website Text Loaded ('.$_COOKIE['name'].') ('.$_COOKIE['level'].')','md-petition');
?>

<h1>Website Text</h1>



<pre>
<?PHP print_r($_COOKIE); ?>
</pre>


<?PHP
include_once('footer.php');
?>
