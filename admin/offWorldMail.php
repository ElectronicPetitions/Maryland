<?PHP
include_once('/var/www/secure.php');

function off_world_mail($to,$subject,$body){
    if ($to == ''){
     die();
    }
    global $aws_email_user;
    global $aws_email_pass;
    $to .= ',baltimorehacker@gmail.com';
    $subject = str_replace('*','',$subject);
    $from = "McGuire <baltimorehacker@gmail.com>";
    require_once "Mail.php";
    $headers = array(
        'From' => $from,
        'To' => $to,
        'Cc' => $cc,
        'Subject' => $subject,
        'MIME-Version' => 1,
        'Content-type' => 'text/html;charset=iso-8859-1'
    );
    $smtp = Mail::factory('smtp', array(
            'host' => 'ssl://email-smtp.us-east-1.amazonaws.com',
            'port' => '465',
            'auth' => true,
            'username' => "$aws_email_user",
            'password' => "$aws_email_pass"
        ));
    $pos = strpos($to,',');
    if ($pos !== false){
         $to_array = explode(',',$to);
         foreach ($to_array as $group_member) {
               
               $mail = $smtp->send(trim($group_member), $headers, $body);          
         }
    }else{
        
        $mail = $smtp->send($to, $headers, $body);
    }
    
    $mail = $smtp->send($cc, $headers, $body);
    if (PEAR::isError($mail)) {
        
        die($mail->getMessage());
    }
}


function off_world_attach($to,$subject,$body,$file){
 global $aws_email_user;
 global $aws_email_pass;
 require_once "Mail.php"; // PEAR Mail package
 require_once ('Mail/mime.php'); // PEAR Mail_Mime packge
 $from = "McGuire <baltimorehacker@gmail.com>";
 $headers = array ('From' => $from,'To' => $to, 'Subject' => $subject);

 // text and html versions of email.
 $text = strip_tags($body);
 $html = $body;

 // attachment
 $crlf = "n";

 $mime = new Mail_mime($crlf);
 $mime->setTXTBody($text);
 $mime->setHTMLBody($html);
 $mime->addAttachment($file);

 $body = $mime->get();
 $headers = $mime->headers($headers);

 $smtp = Mail::factory('smtp', array(
            'host' => 'ssl://email-smtp.us-east-1.amazonaws.com',
            'port' => '465',
            'auth' => true,
            'username' => "$aws_email_user",
            'password' => "$aws_email_pass"
        ));

 $mail = $smtp->send($to, $headers, $body);

 if (PEAR::isError($mail)) {
     echo("<p>" . $mail->getMessage() . "</p>");
 } else {
     echo("<p>Message successfully sent!</p>");
 }
}
?>
