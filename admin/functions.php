<?PHP

function id2group($id){
  global $petition;
  $q = "select name from groups where id = '$id';
  $r = $petition->query($q);
  $d = mysqli_fetch_array($r,MYSQLI_ASSOC);
  return $d['name'];
}


