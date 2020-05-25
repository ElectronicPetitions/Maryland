 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<?PHP
foreach ($_POST['print'] as $k => $v) {
    $url = "http://md-petition.com/admin/print.php?id=$k";
    echo "<img class='img-responsive' src='$url' alt='$k' style='page-break-after: always;'>";
}
die();
