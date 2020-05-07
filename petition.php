<?PHP
include_once('header.php'); 
if (isset($_POST['petition'])){
  $id = $_POST['petition'];
  $q = "select * from petitions where petition_id = '$id'";
  $r = $petition->query($q);
  $d = mysqli_fetch_array($r);
}
?>
<div class='col-sm-12'><img class="img-responsive" src='<?PHP echo $d['petition_jpg'];?>'></div>
<?PHP include_once('footer.php');
