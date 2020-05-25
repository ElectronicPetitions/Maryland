<?PHP
foreach ($_POST['print'] as $k => $v) {
    $url = "http://md-petition.com/admin/print.php?id=$k";
    echo "<img src='$url' alt='$k' style='page-break-after: always;'>";
}
die();
