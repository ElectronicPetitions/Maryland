<?PHP include_once('header.php');  ?>
<div class="container">
  <h3>Welcome!</h3>
    Development In Progress -  Please Click Through the Menu to Review 
  <h3>Stats</h3>
  <?PHP
  $expected = 4194252;
  if ($result = $petition->query("SELECT VTRID FROM VoterList")) {
    $row_cnt = $result->num_rows;
    $c = $row_cnt / $expected;
    $p = number_format($c,2)*100;
    echo number_format($row_cnt).' out of '.number_format($expected).' '.$p.'% done.';

    /* close result set */
    $result->close();
}
  
  ?>
</div>
<?PHP include_once('footer.php');
