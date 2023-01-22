<?php
session_start();
if(isset($_SESSION['name'])){

    // solution: https://stackoverflow.com/questions/8364323/php-wrong-date-time/36427176
    date_default_timezone_set('America');

    $text = $_POST['text'];     
    /* date("g:i a") */
    $text_message = "<div class='msgln'><span class='chat-time'>".date("m:i a")."</span> <b class='user-name'>".$_SESSION['name']."</b> ".stripslashes(htmlspecialchars($text))."<br></div>";
    file_put_contents("log.html", $text_message, FILE_APPEND | LOCK_EX);
}
?>