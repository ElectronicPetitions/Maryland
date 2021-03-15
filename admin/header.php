<!DOCTYPE html>
<html lang="en">  
<head>
  <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-TY6C66ZWMX"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-TY6C66ZWMX');
</script>
  <?PHP 
  include_once('/var/www/secure.php'); //outside webserver
  include_once('../slack.php');
  $pageX = $_SERVER['REQUEST_URI'];
  $nameX = $_COOKIE['name'];
  slack_general_admin("$nameX Loaded $pageX",'md-petition-admin');
  include_once('../session.php');
  include_once('functions.php');
  $sID = session_id();
  if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} else {
		$ip = $_SERVER['REMOTE_ADDR'];
	}
  $ip = $petition->real_escape_string($ip);
  $browser_string = $petition->real_escape_string($_SERVER['HTTP_USER_AGENT']);
  $petition->query("INSERT INTO admin_sessions (ip, browser_string, php_session, php_page, loaded_on_date, action_on, username) VALUES ('$ip','$browser_string','".$sID."', '$pageX', NOW(), NOW(), '$nameX')");
  ?>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <title><?PHP echo $_COOKIE['name'];?> - MEPS <?PHP echo $_COOKIE['level'];?></title>
</head>
<body>
  <div class="container">
    <ul class="nav nav-pills">
      <li role='presentation'><a href="/index.php">Main Website</a></li>
      <li role='presentation' <?PHP if($_SERVER['SCRIPT_NAME'] == '/admin/index.php' || $_SERVER['SCRIPT_NAME'] == '/admin/user_home.php' || $_SERVER['SCRIPT_NAME'] == '/admin/manager_home.php'){ echo "class='active'"; } ?> ><a href="index.php">Home</a></li>
      <?PHP if ($_COOKIE['level'] == 'admin'){  include_once('menu_admin.php'); } ?>
      <?PHP if ($_COOKIE['level'] == 'manager' || $_COOKIE['level'] == 'admin'){  include_once('menu_manager.php'); } ?>
      <?PHP if ($_COOKIE['level'] == 'user' || $_COOKIE['level'] == 'manager' || $_COOKIE['level'] == 'admin'){  include_once('menu_user.php'); } ?>
      <li role='presentation' <?PHP if($_SERVER['SCRIPT_NAME'] == '/admin/logout.php'){ echo "class='active'"; } ?> ><a href="logout.php">Log Out</a></li>	
    </ul>

