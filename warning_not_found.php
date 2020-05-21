<?PHP 
$save_invite = $_COOKIE['invite'];
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
setcookie("invite", $save_invite);
include_once('header.php');  
slack_general('Warning Not Found ('.$_COOKIE['invite'].')','md-petition');
$qX = "select * from website_text where id = '5'";
$rX = $petition->query($qX);
$dX = mysqli_fetch_array($rX);
?>
<script>document.title = "MEPS - Warning Not Found";</script>
<div class='row'>
 <div class='col-sm-10' style='text-align:center;'><h1><?PHP echo $dX['text_title'];?></h1></div>
</div>
<div class='row'>
 <div class='col-sm-10' style='text-align:center;'><h2><?PHP echo $dX['text_block'];?></h2></div>
</div>
<?PHP include_once('footer.php');
