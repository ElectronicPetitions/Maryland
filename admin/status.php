<?PHP include_once('../header.php');  ?>
<meta http-equiv="refresh" content="1">
  <h1>
  <?PHP
  $expected = 4194252;
  if ($result = $petition->query("SELECT VTRID FROM VoterList")) {
    $row_cnt = $result->num_rows;
    $c = $row_cnt / $expected;
    $p = number_format($c,2)*100;
    echo date('r').' '.number_format($row_cnt).' out of '.number_format($expected).' '.$p.'% done.';
} ?>
</h1>
<?PHP include_once('../footer.php');  ?>
