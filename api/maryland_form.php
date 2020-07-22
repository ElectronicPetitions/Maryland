<?PHP
include_once('maryland_voter.php');
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
