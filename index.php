<?PHP include_once('header.php');  ?>
<div class="container">
  <h3>Welcome!</h3>
    Development In Progress -  Please Click Through the Menu to Review 
  <h3>Stats</h3>
  <?PHP
  if ($result = $petition->query("SELECT VTRID FROM VoterList")) {

    /* determine number of rows result set */
    $row_cnt = $result->num_rows;

    printf("Result set has %d rows.\n", $row_cnt);

    /* close result set */
    $result->close();
}
  
  ?>
</div>
<?PHP include_once('footer.php');
