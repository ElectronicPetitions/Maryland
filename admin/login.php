<?PHP
include_once('/var/www/secure.php'); 
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
				return "Wrong Password.";
			}
		}else{
			return "E-Mail Address Not Found.";
		}
	}

if (isset($_POST['email']) && isset($_POST['password'])){
  $message =  check_user($_POST['email'],$_POST['password']);
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
  			<td><input type="submit" name="loginGo" value="Log In"  /></td>
  		</tr>
  	</table>	
  </form>
</div>
