<?PHP
include_once('header.php'); 
if (isset($_POST['petition'])){
  $id = $_POST['petition'];
  $q = "select * from petitions where petition_id = '$id'";
  $r = $petition->query($q);
  $d = mysqli_fetch_array($r);
}
?>
<button onclick="myFunction()">Sign Now</button>



<script>
function myFunction() {
  var txt;
  var person = prompt("Please sign your name by typing :", "");
  if (person == null || person == "") {
    txt = "User cancelled the prompt.";
  } else {
    txt = "Hello " + person + "! How are you today?";
  }
  document.getElementById("demo").innerHTML = txt;
}
</script>

<div class='col-sm-12'><img class="img-responsive" src='<?PHP echo $d['petition_jpg'];?>'></div>

<p id="demo"></p>

<?PHP include_once('footer.php');
