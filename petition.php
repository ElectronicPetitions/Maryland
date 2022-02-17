<?PHP
include_once('header.php'); 
if (isset($_POST['petition'])){
  $id = $_POST['petition'];
  setcookie("pID", $id);
  $q = "select * from petitions where petition_id = '$id'";
  $r = $petition->query($q);
  $d = mysqli_fetch_array($r);
  //slack_general('OK POST (invite:'.$_COOKIE['invite'].')','md-petition');
}elseif($_COOKIE['pID'] != ''){
  $id = $_COOKIE['pID'];
  $q = "select * from petitions where petition_id = '$id'";
  $r = $petition->query($q);
  $d = mysqli_fetch_array($r);
  //slack_general('OK COOKIE (invite:'.$_COOKIE['invite'].')','md-petition');
}else{
  slack_general('MAJOR ERROR (invite:'.$_COOKIE['invite'].')','md-petition');
  header('Location: reset.php');
  die('Error #15'); 
}
setcookie("pJPG", $d['petition_jpg']);
?>
<script>
  window.onload = function() { window.print(); }
  document.title = "MEPS - Sign <?PHP echo $d['petition_name'];?>";
$(document).ready(function() {
  $('#myText').keypress(function(event){
    if (event.keyCode == 10 || event.keyCode == 13) 
        event.preventDefault();
  });
  $('#myTextb').keypress(function(event){
    if (event.keyCode == 10 || event.keyCode == 13) 
        event.preventDefault();
  });
});
</script>
<style>
@font-face {
    font-family: "myFirstFont";
    src: url("files/Claston Script.ttf");
}
.sig {
    font-family: "myFirstFont";
    font-size: 60px;
}
</style>
<?PHP
if (isset($_POST['signed_name_as'])){
?>
<script>
   window.scrollTo(0,document.body.scrollHeight);
   $(document).ready(function(){   
     window.scrollTo(0,document.body.scrollHeight);
     $('#exampleModalLower').modal('show');
    });
  function addTextb()
  {
      document.getElementById('text2b').innerHTML = document.getElementById('myTextb').value;
      var string = document.getElementById('myTextb').value; 
      var string = string.replace(/ +(?= )/g,'');
      var res = string.toUpperCase();
      var res = res.replace(/ +(?= )/g,'');
      var result = res.match(/<?PHP echo $_COOKIE['pNAME'];?>/i); 
      if (result == "<?PHP echo $_COOKIE['pNAME'];?>"){
            document.getElementById("b2").style.display = "block";
            document.getElementById("b2warn").style.display = "none";
            document.getElementById("click_me2").style.display = "none";
            document.getElementById("form2").submit();
            //alert("Confirmed : " + result); 
      }else{
            document.getElementById("b2").style.display = "none";
            document.getElementById("b2warn").style.display = "block";
            document.getElementById("click_me2").style.display = "block";
      }
  }
</script>
<?PHP
}else{
?>
<script>
   $(document).ready(function(){
         $('#exampleModalCenter').modal('show');
    });
  function addText()
  {
      document.getElementById('text2').innerHTML = document.getElementById('myText').value;
      var string = document.getElementById('myText').value; 
      var string = string.replace(/ +(?= )/g,'');
      var res = string.toUpperCase();
      var res = res.replace(/ +(?= )/g,'');
      var result = res.match(/<?PHP echo $_COOKIE['pNAME'];?>/i);
      if (result == "<?PHP echo $_COOKIE['pNAME'];?>"){
            document.getElementById("b1").style.display = "block";
            document.getElementById("b1warn").style.display = "none";
            document.getElementById("click_me1").style.display = "none";
            document.getElementById("form1").submit();
            //alert("Confirmed : " + result); 
      }else{
            document.getElementById("b1").style.display = "none";
            document.getElementById("b1warn").style.display = "block";
            document.getElementById("click_me1").style.display = "block";
      }
  }
</script>
<?PHP
}
?>





<div class='col-sm-12'><img class="img-responsive" src='hard_copy.php'></div>
<?PHP if ($d['petition_jpg_page2'] != ''){ ?>
  <div class='col-sm-12'><img class="img-responsive" src='<?PHP echo $d['petition_jpg_page2'];?>'></div>
<?PHP } ?>
<?PHP 
if(isset($_POST['signed_name_as'])){
 slack_general('*Step 2* ('.$d['petition_name'].') ('.$_POST['signed_name_as'].') ('.$_COOKIE['invite'].')','md-petition');
}else{
 slack_general('*Step 1* ('.$d['petition_name'].') ('.$_COOKIE['invite'].')','md-petition'); 
}
include_once('footer.php');


$name   = $petition->real_escape_string($_COOKIE['pNAME']);
	if(trim($name) == ''){
		$name = $petition->real_escape_string($_COOKIE['web_first_name'].' '.$_COOKIE['web_middle_name'].' '.$_COOKIE['web_last_name']);
	}

$signed_name_as             = $petition->real_escape_string($name);
$date_of_birth              = $petition->real_escape_string($_COOKIE['pDOB']);
$signed_name_as_circulator  = $petition->real_escape_string($name);
$contact_phone              = $petition->real_escape_string($_COOKIE['pPHONE']);
$shared_email               = $petition->real_escape_string($_COOKIE['email']);
$signature_status           = $petition->real_escape_string('SIGNED');
$bot_check                  = $petition->real_escape_string($_SERVER['HTTP_USER_AGENT']);
$VoterList_table           = $petition->real_escape_string($_COOKIE['VoterList_table']);
$php_session_id             = session_id();
$VTRID 			= $_COOKIE['pVTRID'];

$signature_status = 'unverified';
if ($VTRID > 0){
$signature_status = 'verified';
}
 

if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
    $ip = $_SERVER['REMOTE_ADDR'];
}
$petition_id = $id;
// we now are going to record this as signed
$petition->query("insert into signatures (signature_status,shared_email,VoterList_table,php_session_id,bot_check,VTRID,ip_address,date_of_birth,date_time_signed,just_date,petition_id,signed_name_as,signed_name_as_circulator,contact_phone,signature_status)
values ('$signature_status','$shared_email','$VoterList_table','$php_session_id','$bot_check','$VTRID','$ip','$date_of_birth',NOW(),NOW(),'$petition_id','$signed_name_as','$signed_name_as_circulator','$contact_phone','$signature_status')") or die(mysqli_error($petition));

$last = $petition->insert_id;

$petition->query("update presign set presign_status = 'SIGNED' where php_session_id = '$php_session_id' and presign_status = 'NEW' ");



