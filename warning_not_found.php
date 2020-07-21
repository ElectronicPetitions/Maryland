<?PHP 
$save_invite = $_COOKIE['invite'];
include_once('email.php');


ob_start();
echo "<pre>";
print_r($_COOKIE);
print_r($_SESSION);
print_r($_GET);
print_r($_POST);
print_r($_SERVER);
echo "</pre>";
$msg = ob_get_clean();
//meps_mail('mdpetition@gmail.com',$msg,'Voter v1 Found Details');

// hopefully no conflicts with the new api
include_once('api/maryland_voter.php');
$web_first_name   	= $_COOKIE['web_first_name'];
$web_last_name    	= $_COOKIE['web_last_name'];
$web_house_number 	= $_COOKIE['web_house_number'];
$web_zip_code     	= $_COOKIE['web_zip_code'];
$DOB              	= $_COOKIE['pDOB'];
$month 	  		= date('m',strtotime($DOB));
$day 	  		= date('d',strtotime($DOB));
$year     		= date('Y',strtotime($DOB));
$error = 'Based on what you entered, we were unable to find any information.';
$sbe_response = md_voter_lookup($web_first_name,$web_last_name,$month,$day,$year,$web_zip_code,'','');
$pos = strpos($sbe_response, $error);
if ($pos === false) {
    meps_mail('mdpetition@gmail.com',$sbe_response,'Voter v2 ** Data Found! **');
} else {
    meps_mail('mdpetition@gmail.com',$sbe_response,'Voter v2 Still Missing');
}


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
