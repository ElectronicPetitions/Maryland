 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<?PHP
if(empty($_COOKIE['name'])){
  die("Error #".__LINE__);
}
include_once('/var/www/secure.php'); //outside webserver
foreach ($_POST['print'] as $k => $v) {
    $url = "http://md-petition.com/admin/print.php?id=$k&name=".$_COOKIE['name'];
    echo "<img class='img-responsive' src='$url' alt='$k' style='page-break-after: always;'>";
    $q = "select petition_id from signatures where id = '$id'";
    $r = $petition->query($q);
    $d = mysqli_fetch_array($r);
    $q = "select petition_jpg_page2 from petitions where petition_id = '$d[petition_id]'";
    $r = $petition->query($q);
    $d = mysqli_fetch_array($r);
    if ($d['petition_jpg_page2'] != ''){ ?>
    <div class="row">
      <div class='col-sm-12'><img class="img-responsive" src='../<?PHP echo $d['petition_jpg_page2'];?>'></div>
    </div>
    <?PHP }
}
die();
