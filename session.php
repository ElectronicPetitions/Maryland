<?PHP
session_start();
// this will overlay our current system
function presign(){
  global $petition;
  $id     = session_id();
  $page   = $_SERVER['REQUEST_URI'];
  $email  = $_COOKIE['email'];
  $name   = $_COOKIE['pNAME'];
  $phone  = $_COOKIE['pPHONE'];
  $petition->query("insert into presign (php_session_id,php_page,name,email_for_follow_up,phone_for_validation) 
  values ('$id','$page','$name','$email','$phone') "); 
}
?>
