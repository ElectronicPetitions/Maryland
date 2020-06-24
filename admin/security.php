<?PHP
if ($_COOKIE['id'] == ''){
  header('Location: login.php');
}
if ($_COOKIE['name'] == ''){
  header('Location: login.php');
}
?>
