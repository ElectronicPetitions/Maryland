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
