<?php
/**
 * Created by PhpStorm.
 * User: Filip
 * Date: 15.01.2019
 * Time: 12:18
 */

if (isset($_POST['submit'])){
    $name = $_POST['name'];
    $subject = $_POST['subject'];
    $mailFrom = $_POST['mail'];
    $message = $_POST['message'];

    $mailTo = "manhist@post.cz";
    $headers = "From: " . $mailFrom;
    $txt = "You have recieved an email from ".$name.".\n\n". $message;

    mail($mailTo, $subject,$txt,$headers);
    header("Location: contact.php?mailsend");
}