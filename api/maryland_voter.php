<?PHP
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function cut_part_out($start,$end,$whole){
  $parts = explode($start,$whole);
  $subparts = explode($end,$parts[1]);
  $out = $subparts[0];
  return $out;
}

function getPage($url,$cookie=''){
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
  if ($cookie != ''){
    curl_setopt ($curl, CURLOPT_HTTPHEADER, array("Cookie: ASP.NET_SessionId=$cookie")); // use cookies 
  }
  /* 
  $postfields = array(
    'upload_file' => '@file_to_upload.png',
    'upload_text' => '@text_to_upload'
  );
  curl_setopt ($curl, CURLOPT_POSTFIELDS, $postFields);
  */
  $html = curl_exec ($curl);
  curl_close ($curl);
  return $html;
}

// start a session to get a cookie
$form['url']  = 'https://voterservices.elections.maryland.gov/VoterSearch';
$form['html'] = getPage($form['url']);

// extract the cookie from the header (see CURLOPT_HEADER)
$cookie = cut_part_out('ASP.NET_SessionId=',';',$form['html']);
$VIEWSTATE = cut_part_out('id="__VIEWSTATE" value="','"',$form['html']);
// Found Form Elements
//__VIEWSTATE
//__VIEWSTATEGENERATOR
//__VIEWSTATEENCRYPTED
//__EVENTVALIDATION
//ctl00$MainContent$listLanguages = en

// debug - show full response make sure we have the cookie
echo "<li>COOKIE ASP.NET_SessionId $cookie</li>";
echo "<li>POST VIEWSTATE $VIEWSTATE</li>";

echo htmlspecialchars($form['html']);
echo '<hr><h1>Rendered</h1>';
echo $form['html'];
