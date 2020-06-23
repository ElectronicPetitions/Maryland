<?PHP 
include_once('../slack.php');
include_once('security.php');
include_once('header.php');
$list1  = '';
$list2  = '';
$list3  = '';

$petition_id = intval($_COOKIE['petition_id']); 

$q="SELECT * FROM follow_up where status = 'NEW' and petition_id = '$petition_id'";
$r = $petition->query($q);
while($d = mysqli_fetch_array($r)){
   $sig = '';
  if ($d['name'] != ''){
    $q3 = "SELECT date_time_signed FROM signatures where signed_name_as = '$d[name]' and petition_id = '$petition_id'";
    $r3 = $petition->query($q3);
    $d3 = mysqli_fetch_array($r3); 
    if ($d3['date_time_signed'] != ''){
      $sig = "<b>SIGNATURE $d3[date_time_signed]</b>";
    }
  }
  // no petition_id available...  petition (name)	invite (id) are
  $presig='';
  $q4="SELECT * FROM presign where email_for_follow_up = '$d[email]' and php_page like '/sign.php%'";
  $r4 = $petition->query($q4);
  $d4 = mysqli_fetch_array($r4);
  if ($d4['action_on']){
    $presig = "<b>PRESIG $d4[action_on]</b>";
  }
  if ($presig != '' || $sig != ''){ 
    $list3 .= "<li>$d[email] $presig $d[name] $sig</li>";    
  }else{
    $list3 .= "<li>$d[date_sent] $d[email] $d[name]</li>";
  }    
}

$q="SELECT * FROM follow_up where status <> 'NEW' and petition_id = '$petition_id' order by id DESC";
$r = $petition->query($q);
while($d = mysqli_fetch_array($r)){
  $sig = '';
  if ($d['name'] != ''){
    $q3 = "SELECT date_time_signed FROM signatures where signed_name_as = '$d[name]' and petition_id = '$petition_id'";
    $r3 = $petition->query($q3);
    $d3 = mysqli_fetch_array($r3); 
    if ($d3['date_time_signed'] != ''){
      $sig = "<b>SIGNATURE $d3[date_time_signed]</b>";
    }
  }
  // no petition_id available... petition (name)	invite (id) are
  $presig='';
  $q4="SELECT * FROM presign where email_for_follow_up = '$d[email]' and php_page like '/sign.php%'";
  $r4 = $petition->query($q4);
  $d4 = mysqli_fetch_array($r4);
  if ($d4['action_on']){
    $presig = "<b>PRESIG $d4[action_on]</b>";
  }
  if ($presig != '' || $sig != ''){ 
    $list1 .= "<li>$d[email] $presig $d[name] $sig</li>";    
  }else{
    $list2 .= "<li>$d[date_sent] $d[email] $d[name]</li>";
  }
  
}
ob_start();
echo "<h1>Outbox</h1>";
echo "<ol>";
echo $list3;
echo "</ol>";
$buffer = ob_get_clean();
if ($list3 != ''){
 echo $buffer; 
}
echo "<h1>Signed</h1>";
echo "<ol>";
echo $list1;
echo "</ol>";
echo "<h1>Sent</h1>";
echo "<ol>";
echo $list2;
echo "</ol>";
include_once('footer.php');
