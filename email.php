<?PHP
require_once "Mail.php";                // Pear Mail Library
include_once('/var/www/secure.php');    // provides $gmail_email_user & $gmail_email_pass

// USAGE meps_mail('Patrick <baltimorehacker@gmail.com>','I just wanted to take a second and follow up with your visit to md-petition.com and see if you needed anything, or had any questions.','Petition Follow-Up','1');
function meps_mail($to,$msg,$sub,$custom_mail_server=''){
    global $gmail_email_user;
    global $gmail_email_pass;
    $custom_mail_server = intval($custom_mail_server);
    if ($custom_mail_server != 0){
        /*
        email_smtp_server	varchar(300)	
        email_smtp_port	    varchar(300)	
        email_smtp_user	    varchar(300)	
        email_smtp_pass	    varchar(300)
        */
        $r = $petition->query("select * from petition where petition_id = '$custom_mail_server' ");
        $d = mysqli_fetch_array($r,MYSQLI_ASSOC);
        $custom_email_user = $d['email_smtp_user'];
        $custom_email_pass = $d['email_smtp_pass'];
        $custom_email_server = $d['email_smtp_server'];
        $custom_email_port = $d['email_smtp_port'];
    }else{
        // Use Our G-Mail Server
        $custom_email_server = 'ssl://smtp.gmail.com';
        $custom_email_port = '465';
        $custom_email_user =  $gmail_email_user;
        $custom_email_pass =  $gmail_email_pass;
    }
    $from = 'Petition Support <'.$custom_email_user.'>';
    $subject = $sub.' [MD-Petition.com]';
    $body = "$msg <br><br><br><br> MD Petition Support  $custom_email_user <br> https://www.md-petition.com ";
    $headers = array(
        'From' => $from,
        'To' => $to,
        'Subject' => $subject,
        'MIME-Version' => 1,
        'Content-type' => 'text/html;charset=iso-8859-1'
    );
    $smtp = Mail::factory('smtp', array(
            'host' => $custom_email_server,
            'port' => $custom_email_port,
            'auth' => true,
            'username' => $custom_email_user,
            'password' => $custom_email_pass
        ));
    $mail = $smtp->send($to, $headers, $body);
    if (PEAR::isError($mail)) {
       return $mail->getMessage();
    } else {
       return 'NO ERROR';
    }
 
}
