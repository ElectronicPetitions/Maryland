<?PHP
session_start();
// this will overlay our current system
function presign(){
  global $petition;
  $id     = session_id();
  $page   = $_SERVER['REQUEST_URI'];
  $petition->query("insert into presign (php_session_id,php_page) values ('$id','$page') "); 
}
?>
