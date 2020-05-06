<?PHP
/* delete ALL cookies */
foreach ( $_COOKIE as $key => $value ){
	unset($_COOKIE[$key]);
	setcookie($key, '', time() - 3600, '/'); 
}
// unset cookies
if (isset($_SERVER['HTTP_COOKIE'])) {
    $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
    foreach($cookies as $cookie) {
        $parts = explode('=', $cookie);
        $name = trim($parts[0]);
        setcookie($name, '', time()-1000);
        setcookie($name, '', time()-1000, '/');
    }
}
header('Location: index.php');
?>
