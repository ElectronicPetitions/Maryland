<?PHP
$copy = '&copy; 2020 Patrick McGuire';
if ($_COOKIE['invite'] != ''){
 $copy = '&copy; 2020 Patrick McGuire - '.strtoupper($_COOKIE['invite']); 
}  
?>
<?PHP if ($_SERVER['SCRIPT_NAME'] != '/share.php'){ ?>  
 <div class='row'>
  <div class='col-sm-10' style='text-align:center;'><br><br><br><button type="button" class="btn btn-info btn-lg btn-block" onclick="window.open('share.php')">Before you leave click here to share the petition.</button></div>
 </div>
<?PHP } ?>

<div class='row'>
 <div class='col-sm-4' style='text-align:center;'>
  
 </div>
 <div class='col-sm-2' style='text-align:center;'>
  <a target='_Blank' href='https://www.youtube.com/watch?v=PFVN97kfUD8'><img alt='Click Here for a youtube instructional video' class='img-responsive' src='files/img-help_button.png'></a>
 </div>
 <div class='col-sm-4' style='text-align:center;'>
  
 </div>
</div>

<div class='row'>
 <div class='col-sm-10' style='text-align:center;'>
  <?PHP echo $copy;?>
 </div>
</div>



<div class='row'>
 <div class='col-sm-10' style='text-align:center;'>
  <span id="siteseal"><script async type="text/javascript" src="https://seal.starfieldtech.com/getSeal?sealID=aPXbc3kH1AvnQodUszkMcZir7V0JjcOovILeuCzgYFn2WwPTWyh0o2vI6hDF"></script></span>
 </div>
</div>

<div id="fb-root"></div>
  <script>(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.0";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));</script>

<div class='row'>
  <div class='col-sm-10' style='text-align:center;'>
   <?PHP if($_COOKIE['debug'] == 'on'){ ?> 
    <pre><?PHP print_r($_GET); ?></pre>
    <pre><?PHP print_r($_POST); ?></pre> 
    <pre><?PHP print_r($_SESSION); ?></pre>
    <pre><?PHP print_r($_COOKIE); ?></pre>
   <?PHP } ?>
  </div>
</div>

</div><!-- close container -->
<script type="text/javascript">
    window.doorbellOptions = {
        "id": "10512",
        "appKey": "4wEnfKuAdj4WlHgKaxLMrAbYn8aKdFhtYVnpbRPkG4AbA7SH7KcgiRvdZyWmwxnw"
    };
    (function(w, d, t) {
        var hasLoaded = false;
        function l() { if (hasLoaded) { return; } hasLoaded = true; window.doorbellOptions.windowLoaded = true; var g = d.createElement(t);g.id = 'doorbellScript';g.type = 'text/javascript';g.async = true;g.src = 'https://embed.doorbell.io/button/'+window.doorbellOptions['id']+'?t='+(new Date().getTime());(d.getElementsByTagName('head')[0]||d.getElementsByTagName('body')[0]).appendChild(g); }
        if (w.attachEvent) { w.attachEvent('onload', l); } else if (w.addEventListener) { w.addEventListener('load', l, false); } else { l(); }
        if (d.readyState == 'complete') { l(); }
    }(window, document, 'script'));
</script>
</body>
