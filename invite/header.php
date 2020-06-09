<?PHP
include_once('../session.php');
function presign(){
  global $petition;
  $id = session_id();
 $petition->query("insert into presign (php_session_id) values ('$id') "); 
}
