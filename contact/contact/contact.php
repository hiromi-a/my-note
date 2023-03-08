<?php
header('X-FRAME-OPTIONS: SAMEORIGIN');

session_start();

if (!isset($_SESSION['token'])) {
    $_SESSION['token'] = sha1(substr(str_shuffle('1234567890abcdefghijklmnopqrstuvwxyz1234567890abcdefghijklmnopqrstuvwxyz1234567890abcdefghijklmnopqrstuvwxyz'), 0,32));
}

$html = file_get_contents("_contact.html");
$html = str_replace("%token%",$_SESSION['token'],$html);

echo $html;