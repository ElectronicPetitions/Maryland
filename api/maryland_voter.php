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
// extract the form elements we will need to post with our data
$VIEWSTATE = cut_part_out('id="__VIEWSTATE" value="','"',$form['html']);
$VIEWSTATEGENERATOR = cut_part_out('id="__VIEWSTATEGENERATOR" value="','"',$form['html']);
$VIEWSTATEENCRYPTED = cut_part_out('id="__VIEWSTATEENCRYPTED" value="','"',$form['html']);
$EVENTVALIDATION = cut_part_out('id="__EVENTVALIDATION" value="','"',$form['html']);
// Voter Info Form Elements
$ctl00$MainContent$listLanguages = "en";
if ($_POST['SearchFirstName']){
  $SearchFirstName_field = 'ctl00$MainContent$txtSearchFirstName';
  $SearchFirstName = $_POST['SearchFirstName'];
}
if ($_POST['SearchLastName']){
  $SearchLastName_field = 'ctl00$MainContent$txtSearchLastName';
  $SearchLastName = $_POST['SearchLastName'];
}
if ($_POST['DOBMonth']){
  $DOBMonth_field = 'ctl00$MainContent$txtDOBMonth';
  $DOBMonth = $_POST['DOBMonth'];
}
if ($_POST['DOBDay']){
  $DOBDay_field = 'ctl00$MainContent$txtDOBDay';
  $DOBDay = $_POST['DOBDay'];
}
if ($_POST['DOBYear']){
  $DOBYear_field = 'ctl00$MainContent$txtDOBYear';
  $DOBYear = $_POST['DOBYear'];
}
if ($_POST['SearchZipCode']){
  $SearchZipCode_field = 'ctl00$MainContent$txtSearchZipCode';
  $SearchZipCode = $_POST['SearchZipCode'];
}
// hidden Form Elements
//__VIEWSTATE
//__VIEWSTATEGENERATOR
//__VIEWSTATEENCRYPTED
//__EVENTVALIDATION

// debug - show full response make sure we have the cookie
echo "<li>COOKIE ASP.NET_SessionId $cookie</li>";
echo "<li>POST VIEWSTATE $VIEWSTATE</li>";
echo "<li>POST VIEWSTATEGENERATOR $VIEWSTATEGENERATOR</li>";
echo "<li>POST VIEWSTATEENCRYPTED $VIEWSTATEENCRYPTED</li>";
echo "<li>POST EVENTVALIDATION $EVENTVALIDATION</li>";
echo "<li>POST SearchFirstName $SearchFirstName</li>";
echo "<li>POST SearchLastName $SearchLastName</li>";
echo "<li>POST DOBMonth $DOBMonth</li>";
echo "<li>POST DOBDay $DOBDay</li>";
echo "<li>POST DOBYear $DOBYear</li>";
echo "<li>POST SearchZipCode $SearchZipCode</li>";
echo "<hr><hr><hr>";
echo htmlspecialchars($form['html']);
echo '<hr><hr><hr><h1>Rendered</h1>';
//echo $form['html'];
?>
<form method='POST'>
<table>
  <tr>
    <td>SearchFirstName</td><td><input name='SearchFirstName'></td>
  </tr>
  <tr>
    <td>SearchLastName</td><td><input name='SearchLastName'></td>
  </tr>
  <tr>
    <td>DOBMonth</td><td><input name='DOBMonth'></td>
  </tr>
  <tr>
    <td>DOBDay</td><td><input name='DOBDay'></td>
  </tr>
  <tr>
    <td>DOBYear</td><td><input name='DOBYear'></td>
  </tr>
  <tr>
    <td>SearchZipCode</td><td><input name='SearchZipCode'></td>
  </tr>
  <tr>
    <td>SearchHouseNumber</td><td>n/a</td>
  </tr>
  <tr>
    <td>SearchMiddleInitial</td><td>n/a</td>
  </tr>
  <tr>
    <td></td><td><input type='submit'></td>
  </tr>
</table>  
</form>
