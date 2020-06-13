<?PHP
require_once "Mail.php";
include_once('/var/www/secure.php');


$from = "MD-Petition.com Support <mdpetition@gmail.com>";
$to = "Patrick <insidenothing@gmail.com>";
$subject = "Hi!";
$body = "Hi,\n\nHow are you?";

$host = "smtp.gmail.com";
$port = "587";
global $gmail_email_user;
$username = $gmail_email_user;
global $gmail_email_pass;
$password = $gmail_email_pass;

$headers = array ('From' => $from,
  'To' => $to,
  'Subject' => $subject);
$smtp = Mail::factory('smtp',
  array ('host' => $host,
    'port' => $port,
    'auth' => true,
    'username' => $username,
    'password' => $password));

$mail = $smtp->send($to, $headers, $body);

if (PEAR::isError($mail)) {
  echo("<p>" . $mail->getMessage() . "</p>");
 } else {
  echo("<p>Message successfully sent!</p>");
 }
 ?>
