<?PHP
/* delete ALL cookies */
foreach ( $_COOKIE as $key => $value ){
	unset($_COOKIE[$key]);
	setcookie($key, '', time() - 3600, '/'); 
}
header('Location: index.php');
?>
