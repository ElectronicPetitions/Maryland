<?PHP
include_once('header.php'); 
if (isset($_POST['petition'])){
  $id = $_POST['petition'];
  $q = "select * from petitions where petition_id = '$id'";
  $r = $petition->query($q);
  $d = mysqli_fetch_array($r);
}
?>
<style>
@font-face {
    font-family: "myFirstFont";
    src: url("files\Claston Script.ttf");
}
.sig {
    font-family: "myFirstFont";
}
</style>

<script>
  $('#exampleModalCenterTitle').modal('show');
</script>
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
  Launch demo modal
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Adopt Digital Signature</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <span class="sig"><?PHP echo $_COOKIE['pNAME'];?></span>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary">Sign and Submit</button>
      </div>
    </div>
  </div>
</div>
<div class='col-sm-12'><img class="img-responsive" src='hard_copy.php'></div>


<?PHP include_once('footer.php');
