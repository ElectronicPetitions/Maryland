<?PHP
$copy = 'MEPS';
if ($_COOKIE['invite'] != ''){
 $copy = 'MEPS - '.strtoupper($_COOKIE['invite']); 
}  
?>
<div class='col-sm-12' style='text-align:center;'><hr> &COPY; 2020 <?PHP echo $copy;?></div>
  <div class='col-sm-12' style='text-align:center;'>
   <?PHP if($_COOKIE['debug'] == 'on'){ ?> 
    <pre><?PHP print_r($_GET); ?></pre>
    <pre><?PHP print_r($_POST); ?></pre> 
    <pre><?PHP print_r($_COOKIE); ?></pre>
   <?PHP } ?>
</div>
 </div>
</body>
