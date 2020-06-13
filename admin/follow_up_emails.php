<?PHP
include_once('../email.php');

$base_message = "I just wanted to take a second and follow up with your visit to md-petition.com and
see if you needed anything, or had any questions. You indicated a follow up if we did not receive your
completed petition. The software flagged your session, and we had a human review. You should receive an
alert 'Petition Signed' when complete. If you would like, please retry and if you continue to have trouble
I will work to fix it ASAP.";

// USAGE meps_mail('Patrick <baltimorehacker@gmail.com>','','Petition Follow-Up');

$q="SELECT * FROM follow_up where status = 'NEW'";
$r = $petition->query($q);
while($d = mysqli_fetch_array($r)){
  $name = $d['name'];
  $email = $d['email']; 
  $q2 = "SELECT * FROM presign where php_session_id = '$d[php_session]'";
  $r2 = $petition->query($q2);
  $presign = mysqli_fetch_array($r2);  
  $visit = $presign['action_on'];
  $invite='';
  $petition_name='Maryland';
  if($d['petition_id'] != '0'){
    $q2 = "SELECT * FROM petitions where petition_id = '$d[petition_id]'";
    $r2 = $petition->query($q2);
    $petitions = mysqli_fetch_array($r2);
    $petition_name = $petitions['petition_name'];
    $landing_page = $petitions['landing_page'];
    $web_short_name   = $petitions['web_short_name'];
    $link = 'https://www.md-petition.com/?invite='.$web_short_name;
    if ($landing_page != ''){
      $link = 'https://www.md-petition.com/'.$landing_page;
    }
    $invite = "<br><br>Petition: $petition_name at <a href='$link'>$link</a>";
  }
  $last = "<br><br>Follow up was requested at $visit";
  $body = $base_message.$invite.$last;
  $subject = "$petition_name Petition Follow-Up";
  $to = "$name <$email>";
  $feedback_message = "TO: $to SUB: $subject MSG: $body sent on ".date('r')." by ".$_COOKIE['name'];
  meps_mail($to,$body,$subject);
  $feedback_message = $petition->real_escape_string($feedback_message);
  $petition->query("update follow_up set status = 'sent', feedback_message = '$feedback_message' where id = '$d[id]'  ");
}

?>
