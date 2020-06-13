<?PHP
// Pear Mail Library
require_once "Mail.php";
include_once('/var/www/secure.php');

function meps_mail($to,$msg,$sub){
    global $gmail_email_user;
    global $gmail_email_pass;
    $from = 'MD Petition Support <mdpetition@gmail.com>';
    //$to = 'Patrick <baltimorehacker@gmail.com>';
    $subject = $sub.' [MD-Petiton.com]';
    $body = "$msg <br><br><br><br> Patrick McGuire <br>MD Petition Support  mdpetition@gmail.com <br> https://www.md-petition.com ";

    $headers = array(
        'From' => $from,
        'To' => $to,
        'Subject' => $subject,
        'MIME-Version' => 1,
        'Content-type' => 'text/html;charset=iso-8859-1'
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
       // echo('<p>' . $mail->getMessage() . '</p>');
    } else {
       // echo('<p>Message successfully sent!</p>');
    }
}


 meps_mail('Patrick <baltimorehacker@gmail.com>','I just wanted to take a second and follow up with your visit to md-petition.com and see if you needed anything, or had any questions.','Petition Follow-Up');
