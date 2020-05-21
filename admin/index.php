<?PHP 

include_once('security.php');

include_once('header.php');
slack_general('ADMIN: Home Page Loaded ('.$_COOKIE['name'].') ('.$_COOKIE['level'].')','md-petition');
?>

<h1>Admin Home</h1>

<pre>
list all users and levels

list all petitions and stats
</pre>


<pre>
<?PHP print_r($_COOKIE); ?>
</pre>


<?PHP
include_once('footer.php');
?>
