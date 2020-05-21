<?PHP
include_once('header.php'); 
if (isset($_POST['petition'])){
  $id = $_POST['petition'];
  setcookie("pID", $id);
  $q = "select * from petitions where petition_id = '$id'";
  $r = $petition->query($q);
  $d = mysqli_fetch_array($r);
}elseif($_COOKIE['pID'] != ''){
  $id = $_COOKIE['pID'];
  $q = "select * from petitions where petition_id = '$id'";
  $r = $petition->query($q);
  $d = mysqli_fetch_array($r);
}else{
  slack_general('MAJOR ERROR: petition.php ('.$_COOKIE['invite'].')','md-petition');
  header('Location: reset.php');
  die('Error #15'); 
}
setcookie("pJPG", $d['petition_jpg']);
?>
<script>document.title = "MEPS - Sign <?PHP echo $d['petition_name'];?>";</script>
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
      <form action='petition.php' method='POST'>
        <div class="modal-body">
          <h2><?PHP echo $d['petition_sign_text_box'];?></h2>
          <input class="form-control input-lg" name="signed_name_as" type="text" id="myText" onkeyup="addText()" required>
          <h1 id="text2" class="sig"></h1>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary btn-lg btn-block">Sign and Next</button>
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
      <form action='sign.php' method='POST'><input type='hidden' value='<?PHP echo $_POST['signed_name_as'];?>' name='signed_name_as'>
        <div class="modal-body">
          <h2><?PHP echo $d['petition_circulator_text_box'];?></h2>
          <input class="form-control input-lg" name="signed_name_as_circulator" type="text" id="myTextb" onkeyup="addTextb()" required>
          <h1 id="text2b" class="sig"></h1>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary btn-lg btn-block">Sign and Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class='col-sm-12'><img class="img-responsive" src='hard_copy.php'></div>


<?PHP 
if(isset($_POST['signed_name_as'])){
 slack_general('petition.php ('.$d['petition_name'].') ('.$_POST['signed_name_as'].') ('.$_COOKIE['invite'].')','md-petition');
}else{
 slack_general('petition.php ('.$d['petition_name'].') ('.$_COOKIE['invite'].')','md-petition'); 
}
include_once('footer.php');
