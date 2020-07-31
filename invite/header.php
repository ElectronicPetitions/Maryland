<?PHP
include_once('../session.php');
if (isset($_GET['form_version'])){
  if ($_GET['form_version'] == '2'){ 
    setcookie("form_version", '2', time()+3600, "/"); 
  } 
  if ($_GET['form_version'] == '3'){ 
    setcookie("form_version", '3', time()+3600, "/"); 
  }
}  
