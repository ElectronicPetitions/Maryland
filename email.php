<?PHP
// Pear Mail Library
require_once "Mail.php";
include_once('/var/www/secure.php');
global $gmail_email_user;
global $gmail_email_pass;

$from = 'MD-Petition.com Support <mdpetition@gmail.com>';
$to = '<insidenothing@gmail.com>';
$subject = 'Hi!';
$body = "Hi,\n\nHow <b>are</b> you?";

$headers = array(
    'From' => $from,
    'To' => $to,
    'Subject' => $subject
);

$smtp = Mail::factory('smtp', array(
        'host' => 'ssl://smtp.gmail.com',
        'port' => '465',
        'auth' => true,
        'username' => $gmail_email_user,
        'password' => $gmail_email_pass
    ));

$mail = $smtp->send($to, $headers, $body);

if (PEAR::isError($mail)) {
    echo('<p>' . $mail->getMessage() . '</p>');
} else {
    echo('<p>Message successfully sent!</p>');
}
