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

function md_voter_lookup($SearchFirstName,$SearchLastName,$DOBMonth,$DOBDay,$DOBYear,$SearchZipCode,$SearchHouseNumber,$SearchMiddleInitial){
  $post['ctl00$MainContent$btnSearch'] = "Search";
  $post['btnSearch'] = "Search";
  $post['ctl00$MainContent$listLanguages'] = "en";
  $post['listLanguages'] = "en";
  $post['ctl00$MainContent$txtSearchFirstName'] = $SearchFirstName;
  $post['txtSearchFirstName'] = $SearchFirstName;
  $post['ctl00$MainContent$txtSearchLastName'] = $SearchLastName;
  $post['txtSearchLastName'] = $SearchLastName;
  $post['ctl00$MainContent$txtDOBMonth'] = $DOBMonth;
  $post['txtDOBMonth'] = $DOBMonth;
  $post['ctl00$MainContent$txtDOBDay'] = $DOBDay;
  $post['txtDOBDay'] = $DOBDay;
  $post['ctl00$MainContent$txtDOBYear'] = $DOBYear;
  $post['txtDOBYear'] = $DOBYear;
  $post['ctl00$MainContent$txtSearchZipCode'] = $SearchZipCode;
  $post['txtSearchZipCode'] = $SearchZipCode;
  $post['ctl00$MainContent$txtSearchHouseNumber'] = $SearchHouseNumber;
  $post['txtSearchHouseNumber'] = $SearchHouseNumber;
  $post['ctl00$MainContent$txtSearchMiddleInitial'] = $SearchMiddleInitial;
  $post['txtSearchMiddleInitial'] = $SearchMiddleInitial;
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
  /*
  echo "<li>COOKIE ASP.NET_SessionId $cookie</li>";
  echo "<li>POST VIEWSTATE $post[__VIEWSTATE]</li>";
  echo "<li>POST VIEWSTATEGENERATOR $post[__VIEWSTATEGENERATOR]</li>";
  echo "<li>POST VIEWSTATEENCRYPTED $post[__VIEWSTATEENCRYPTED]</li>";
  echo "<li>POST EVENTVALIDATION $post[__EVENTVALIDATION]</li>";
  echo "<pre>";
  echo print_r($post);
  echo "</pre>";
  */
  $result['html'] = getPage($form['url'],$cookie,$post);
  //echo "<h1>STEP 2: SBE RESULTS</h1>";
  $return['debug'] = htmlspecialchars($result['html']);
  $return['html']  = $result['html']; 
  return $return;
}

if (isset($_POST['SearchFirstName'])){
  $voter = md_voter_lookup($_POST['SearchFirstName'],$_POST['SearchLastName'],$_POST['DOBMonth'],$_POST['DOBDay'],$_POST['DOBYear'],$_POST['SearchZipCode'],$_POST['SearchHouseNumber'],$_POST['SearchMiddleInitial']);
  echo $voter['html'];
}
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
      <td>SearchHouseNumber*</td><td><input name='SearchHouseNumber'></td>
    </tr>
    <tr>
      <td>SearchMiddleInitial*</td><td><input name='SearchMiddleInitial'></td>
    </tr>
    <tr>
      <td>*Optional</td><td><input type='submit'></td>
    </tr>
  </table>  
  </form>
  */
  
  ?>
