<?PHP 
$title = 'MEPS - Invite Links';
include_once('header.php');
$q = "select * from website_text where id = '8'";
$r = $petition->query($q);
$d = mysqli_fetch_array($r);
?>
<script>document.title = "<?PHP echo $title;?>";</script>
<div class='col-sm-12' style='height:100px; text-align:center;'><h2><?PHP echo $d['text_title'];?></h2><p><?PHP echo $d['text_block'];?></p></div>
<?PHP include_once('footer.php');
