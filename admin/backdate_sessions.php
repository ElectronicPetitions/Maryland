<?PHP
include_once('/var/www/secure.php'); 
$q = "select * from presign where only_date = '0000-00-00' ";
$r = $petition->query($q);
while($d = mysqli_fetch_array($r)){
  $id = $d['id'];
  $action_on = $d['action_on'];
  $only_date = date('Y-m-d',strtotime($action_on));
  $petition->query("update presign set only_date = '$only_date' where id = '$id' ");
  echo "[ $id $action_on $only_date ]";
}
?>
