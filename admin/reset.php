<?PHP
include_once('../slack.php');
include_once('/var/www/secure.php'); 
include_once('../email.php');
if(isset($_POST['email'])){
      	$email = $_POST['email'];
      	$r = $petition->query("SELECT * FROM users WHERE email = '$email'");
	$row = mysqli_fetch_array($r,MYSQLI_ASSOC);
    	if ($row['email'] != ''){
          $pass =  rand(1000,9999);
          $salt = md5(rand(1000,9999));
          $hash = md5($pass.$salt);
          $encrypted = $hash.':'.$salt;
          //off_world_mail(,,);
	  $subject = 'MD Petition Login';
	  $body = 'Login with '.$email.' and your new password '.$pass.' at https://www.md-petition.com/admin/login.php'
          meps_mail($email,$body,$subject);
          $petition->query("update users set pass = '$encrypted' WHERE email = '$email'");
          echo "<h1>Your Password has been Sent.</h1>";
	  slack_general_admin('DEBUG: $body','md-petition-signed');
        }else{
          echo "<h1>E-Mail address not found.</h1>";
	  slack_general('ADMIN: Reset- E-Mail address not found','md-petition');
        }	
}else{
	slack_general('ADMIN: reset.php','md-petition');	
}
?>

<form action="reset.php" method="post" accept-charset="utf-8">	<table>
		<tbody><tr>
			<td>E-Mail Address</td>
			<td><input type="text" name="email" value=""></td>
		</tr>
		<tr>	
			<td>&nbsp;</td>
			<td><input type="submit" name="resetGo" value="Reset Password"> or <a href='login.php'>Login Here</a></td>
		</tr>
	</tbody></table>	
</form>
