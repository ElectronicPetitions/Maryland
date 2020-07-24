<?PHP 
include_once('security.php');
include_once('header.php');
function secondsToDHMS($seconds) {
    $s = (int)$seconds;
    return sprintf('%d:%02d:%02d:%02d', $s/86400, $s/3600%24, $s/60%60, $s%60);
}
?>

  <?PHP
  $expected = 4313592; // old data file...
  if ($result = $petition->query("SELECT VTRID FROM VoterList2")) {
    $row_cnt = $result->num_rows;
    echo "<meta http-equiv=\"refresh\" content=\"60; url=https://www.md-petition.com/admin/status.php?last=$row_cnt\">";
    $c = $row_cnt / $expected;
    $p = number_format($c,2)*100;
    $per_minute = intval($_GET['last']) - $row_cnt;
    $left = $expected - $row_cnt;
    $minutes = round($left/$per_minute);
    $human = secondsToDHMS($minutes*60)
    echo '<h1>'.date('r').'</h1><h1>'.number_format($row_cnt).' out of '.number_format($expected).' '.$p.'% done</h1>
    <h3>$per_minute Per Minute</h3>
<h3>$left row Left</h3>
<h3>$human Left</h3>
<title>'.$p.'% loaded</title>';
  } 

include_once('footer.php'); 
?>
