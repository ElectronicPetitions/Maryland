<?PHP

function id2petition($id){
  global $petition;
  $q = "select petition_name from petition where petition_id = '$id'";
  $r = $petition->query($q);
  $d = mysqli_fetch_array($r,MYSQLI_ASSOC);
  return $d['petition_name'];
}
function id2group($id){
  global $petition;
  $q = "select name from groups where id = '$id'";
  $r = $petition->query($q);
  $d = mysqli_fetch_array($r,MYSQLI_ASSOC);
  return $d['name'];
}


