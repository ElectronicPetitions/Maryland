<?PHP
$id = intval($_GET['id']);
include_once('/var/www/secure.php'); //outside webserver
$q = "select petition_id from signatures where id = '$id'";
$r = $petition->query($q);
$d = mysqli_fetch_array($r);
$q = "select petition_jpg_page2 from petitions where petition_id = '$d[petition_id]'";
$r = $petition->query($q);
$d = mysqli_fetch_array($r);
?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<div class="container">
  <div class="row">
    <div class='col-sm-12'><img class="img-responsive" src='https://www.md-petition.com/soft_copy.php?id=<?PHP echo $id;?>'></div>
  </div>
  <?PHP if ($d['petition_jpg_page2'] != ''){ ?>
    <div class="row">
      <div class='col-sm-12'><img class="img-responsive" src='<?PHP echo $d['petition_jpg_page2'];?>'></div>
    </div>
  <?PHP } ?>
</div>
