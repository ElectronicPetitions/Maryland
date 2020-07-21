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

function getPage($url,$cookie,$post){
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
  */
  if ($post != ''){
    curl_setopt ($curl, CURLOPT_POSTFIELDS, $post);
  }
  $html = curl_exec ($curl);
  curl_close ($curl);
  return $html;
}

// start a session to get a cookie
$form['url']  = 'https://voterservices.elections.maryland.gov/VoterSearch';
$form['html'] = getPage($form['url'],'','');

// extract the cookie from the header (see CURLOPT_HEADER)
$cookie = cut_part_out('ASP.NET_SessionId=',';',$form['html']);
// extract the form elements we will need to post with our data
$post['__VIEWSTATE'] = cut_part_out('id="__VIEWSTATE" value="','"',$form['html']);
$post['__VIEWSTATEGENERATOR'] = cut_part_out('id="__VIEWSTATEGENERATOR" value="','"',$form['html']);
$post['__VIEWSTATEENCRYPTED'] = cut_part_out('id="__VIEWSTATEENCRYPTED" value="','"',$form['html']);
$post['__EVENTVALIDATION'] = cut_part_out('id="__EVENTVALIDATION" value="','"',$form['html']);
// Voter Info Form Elements
//$post['Languages_field'] = '$ctl00$MainContent$listLanguages';
$post['$ctl00$MainContent$listLanguages'] = "en";
if (isset($_POST['SearchFirstName'])){
  //$post['SearchFirstName_field'] = 'ctl00$MainContent$txtSearchFirstName';
  $post['ctl00$MainContent$txtSearchFirstName'] = $_POST['SearchFirstName'];
}else{
  $post['ctl00$MainContent$txtSearchFirstName'] = '';
}
if (isset($_POST['SearchLastName'])){
  //$post['SearchLastName_field'] = 'ctl00$MainContent$txtSearchLastName';
  $post['ctl00$MainContent$txtSearchLastName'] = $_POST['SearchLastName'];
}else{
  $post['ctl00$MainContent$txtSearchLastName'] = '';
}
if (isset($_POST['DOBMonth'])){
  //$post['DOBMonth_field'] = 'ctl00$MainContent$txtDOBMonth';
  $post['ctl00$MainContent$txtDOBMonth'] = $_POST['DOBMonth'];
}else{
  $post['ctl00$MainContent$txtDOBMonth'] = '';
}
if (isset($_POST['DOBDay'])){
  //$post['DOBDay_field'] = 'ctl00$MainContent$txtDOBDay';
  $post['ctl00$MainContent$txtDOBDay'] = $_POST['DOBDay'];
}else{
  $post['ctl00$MainContent$txtDOBDay'] = '';
}
if (isset($_POST['DOBYear'])){
  //$post['DOBYear_field'] = 'ctl00$MainContent$txtDOBYear';
  $post['ctl00$MainContent$txtDOBYear'] = $_POST['DOBYear'];
}else{
  $post['ctl00$MainContent$txtDOBYear'] = '';
}
if (isset($_POST['SearchZipCode'])){
  //$post['SearchZipCode_field'] = 'ctl00$MainContent$txtSearchZipCode';
  $post['ctl00$MainContent$txtSearchZipCode'] = $_POST['SearchZipCode'];
}else{
  $post['ctl00$MainContent$txtSearchZipCode'] = '';
}
// debug - show full response make sure we have the cookie
echo "<li>COOKIE ASP.NET_SessionId $cookie</li>";
echo "<li>POST VIEWSTATE $post[__VIEWSTATE]</li>";
echo "<li>POST VIEWSTATEGENERATOR $post[__VIEWSTATEGENERATOR]</li>";
echo "<li>POST VIEWSTATEENCRYPTED $post[__VIEWSTATEENCRYPTED]</li>";
echo "<li>POST EVENTVALIDATION $post[__EVENTVALIDATION]</li>";
echo "<li>POST SearchFirstName $post[ctl00$MainContent$txtSearchFirstName]</li>";
echo "<li>POST SearchLastName $post[ctl00$MainContent$txtSearchLastName]</li>";
echo "<li>POST DOBMonth $post[ctl00$MainContent$txtDOBMonth]</li>";
echo "<li>POST DOBDay $post[ctl00$MainContent$txtDOBDay]</li>";
echo "<li>POST DOBYear $post[ctl00$MainContent$txtDOBYear]</li>";
echo "<li>POST SearchZipCode $post[ctl00$MainContent$txtSearchZipCode]</li>";
echo "<hr><hr><hr><h1>Voter Form</h1>";
echo htmlspecialchars($form['html']);
echo '<hr><hr><hr>';
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
<?PHP
if ($post['ctl00$MainContent$txtSearchFirstName'] != ''){
  $result['html'] = getPage($form['url'],$cookie,$post);
  echo "<hr><hr><hr><h1>SBE API RESULTS</h1>";
  echo htmlspecialchars($form['html']);
}
?>
