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
  //curl_setopt ($curl, CURLOPT_COOKIEJAR, dirname(__FILE__) . '/cookie.txt'); // save cookies
  //curl_setopt ($curl, CURLOPT_HTTPHEADER, array("Cookie: ASP.NET_SessionId=true")); // use cookies
  $html = curl_exec ($curl);
  curl_close ($curl);
  return $html;
}

// start a session to get a cookie
$form['url']  = 'https://voterservices.elections.maryland.gov/VoterSearch';
$form['html'] = getPage($form['url']);

// extract the cookie form the header (see CURLOPT_HEADER)
$parts = explode ('ASP.NET_SessionId=',$form['html']);
$subparts = explode (';',$parts[1]);
$cookie = $subparts[0];

// debug - show full response make sure we have the cookie
echo "<h1>RAW - $cookie </h1>".htmlspecialchars($form['html']).'<hr><h1>Rendered</h1>';
echo $form['html'];
