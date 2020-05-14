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
