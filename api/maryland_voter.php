<?PHP
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function getPage($url){
  $url = str_replace('[month]',date('F'),$url); // replace month January through December
  $url = str_replace('[day]',date('j'),$url); // replace day 1 to 31
  $url = str_replace('[yesterday]',date('j',strtotime('yesterday')),$url); // replace day 1 to 31
  $url = str_replace('[year]',date('Y'),$url); // replace year Examples: 1999 or 2003
  $curl = curl_init();
  curl_setopt ($curl, CURLOPT_URL, $url);
  curl_setopt ($curl, CURLOPT_USERAGENT, sprintf("McGuire MEPS https://www.md-petition.com/ /%d.0",rand(4,50)));
  curl_setopt ($curl, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt ($curl, CURLOPT_HEADER, 1);
  curl_setopt ($curl, CURLOPT_SSL_VERIFYPEER, 0);
  curl_setopt ($curl, CURLOPT_FOLLOWLOCATION, true);
  curl_setopt ($curl, CURLOPT_COOKIEJAR, dirname(__FILE__) . '/cookie.txt'); // save cookies
  //curl_setopt ($curl, CURLOPT_HTTPHEADER, array("Cookie: ASP.NET_SessionId=true")); // use cookies
  $html = curl_exec ($curl);
  curl_close ($curl);
  return $html;
}

$form['cookies_file'] = dirname(__FILE__) . '/cookie.txt';
$form['url']  = 'https://voterservices.elections.maryland.gov/VoterSearch';
$form['html'] = getPage($form['url']);

$cookies = '';
if (file_exists($form['cookies_file'])) {
  ob_start();
  readfile($form['cookies_file']);
  $cookies = ob_get_clean();
}
echo '<h1>Cookies</h1>'.$cookies;
echo '<h1>RAW</h1>'.htmlspecialchars($form['html']).'<hr>';
echo $form['html'];
