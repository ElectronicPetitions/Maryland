<?PHP
// die on bot match
$bot = $_SERVER['HTTP_USER_AGENT'];
$pos = strpos($bot, 'SemrushBot');
if ($pos !== false) {
    die('bad robot');
} 
$pos = strpos($bot, 'AhrefsBot');
if ($pos !== false) {
    die('bad robot');
} 
$pos = strpos($bot, 'Slackbot');
if ($pos !== false) {
    die('bad robot');
} 
?>
