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

<!-- TOP Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title" id="exampleModalLongTitle">Type Your Signature to Sign <?PHP echo $d['petition_name'];?></h1>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action='petition.php' method='POST' name='form1' id='form1'>
        <div class="modal-body">
          <h2><?PHP echo $d['petition_sign_text_box'];?></h2>
          <h3><?PHP echo $_COOKIE['pNAME'];?>, Please Sign Here</h3>
          
        </div>
        <div class="modal-footer">
          <h1 id="text2" class="sig"></h1>
          <button style='display:none;' id='b1' name='b1' type="submit" class="btn btn-primary btn-lg btn-block"><img class='click_me' src="files/click_here.gif">Sign and Next</button>
          <button style='display:block;' id='b1warn' name='b1warn' class="btn btn-warning btn-lg btn-block disabled" onclick="alert('Please Type Your Name Exactly as Above');">Please Type Your Name Exactly as Above</button>
          <table><tr><td><img id='click_me1' name='click_me1' class='click_me' src="files/click_here.gif"></td><td><input class="form-control input-lg" name="signed_name_as" type="text" id="myText" onkeyup="addText()" required autofocus></td></tr></table>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Lower Modal -->
<div class="modal fade" id="exampleModalLower" tabindex="-1" role="dialog" aria-labelledby="exampleModalLowerTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title" id="exampleModalLongTitleLower">Type Your Signature to Sign as Circulator</h1>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action='sign.php' method='POST' name='form2' id='form2'><input type='hidden' value='<?PHP echo $_POST['signed_name_as'];?>' name='signed_name_as'>
        <div class="modal-body">
          <h2><?PHP echo $d['petition_circulator_text_box'];?></h2>
          <h3><?PHP echo $_COOKIE['pNAME'];?>, Please Sign Here</h3>
        </div>
        <div class="modal-footer">
          <h1 id="text2b" class="sig"></h1>
          <button style='display:none;' id='b2' name='b2' type="submit" class="btn btn-primary btn-lg btn-block"><img class='click_me' src="files/click_here.gif">Sign and Submit</button>
          <button style='display:block;' id='b2warn' name='b1warn' class="btn btn-warning btn-lg btn-block disabled" onclick="alert('Please Type Your Name Exactly as Above');">Please Type Your Name Exactly as Above</button>
          <table><tr><td><img id='click_me2' name='click_me2' class='click_me' src="files/click_here.gif"></td><td><input class="form-control input-lg" name="signed_name_as_circulator" type="text" id="myTextb" onkeyup="addTextb()" required autofocus></td></tr></table>
        </div>
      </form>
    </div>
  </div>
</div>

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
