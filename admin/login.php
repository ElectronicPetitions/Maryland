<?PHP
include_once('/var/www/secure.php'); 
include_once('../slack.php'); 

function check_user($email,$pass){
		global $petition;
		$res = $petition->query("SELECT * FROM users WHERE email = '$email'");
		$user = mysqli_fetch_array($res,MYSQLI_ASSOC);
		if ($user['email'] != ''){
			$encrypted = $user['pass'];
			$explode = explode(':',$encrypted);
			$hash = $explode[0];
			$salt = $explode[1];
			$test = md5($pass.$salt);
			if( $test == $hash ){
				setcookie("id", $user['id']);
			        setcookie("name", $user['name']);
			        setcookie("email", $user['email']);
			        setcookie("level", $user['sec_level']);
				setcookie("group_id", $user['group_id']);
				header('Location: index.php');
			}else{
				slack_general('ADMIN: Wrong Password','md-petition');
				return "Wrong Password.";
			}
		}else{
			slack_general('ADMIN: E-Mail Address Not Found','md-petition');
			return "E-Mail Address Not Found.";
		}
	}

if (isset($_POST['email']) && isset($_POST['password'])){
  $message =  check_user($_POST['email'],$_POST['password']);
}else{
	slack_general('ADMIN: Login Page Loaded','md-petition');	
}

?>

<div class="slate">
  <form method="post" accept-charset="utf-8">
    <table>
      <?PHP if (isset($message)){ ?>
  		<tr>
  			<td>Message</td>
  			<td><?PHP echo $message;?></td>
  		</tr>
      <?PHP } ?>
  		<tr>
  			<td>E-Mail Address</td>
  			<td><input type="text" name="email" value=""  /></td>
  		</tr>
  		<tr>	
  			<td>Password</td>
  			<td><input type="password" name="password" value=""  /></td>
  		</tr>
  		<tr>	
  			<td>&nbsp;</td>
			<td><input type="submit" name="loginGo" value="Log In"  /> or <a href='reset.php'>Reset Password</a></td>
  		</tr>
  	</table>	
  </form>
</div>
