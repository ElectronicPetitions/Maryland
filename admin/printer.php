<?PHP
function getPage($url){
    $curl = curl_init();
    curl_setopt ($curl, CURLOPT_URL, $url);
    curl_setopt ($curl, CURLOPT_USERAGENT, sprintf("McGuire Petition Printer at md-petition.com /%d.0",rand(4,50)));
    curl_setopt ($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt ($curl, CURLOPT_SSL_VERIFYPEER, 0);
    $html = curl_exec ($curl);
    curl_close ($curl);
    return $html;
}
foreach ($_POST['print'] as $k => $v) {
    $url = "http://md-petition.com/admin/print.php?id=$k";
    echo getPage($url);
}
die();
