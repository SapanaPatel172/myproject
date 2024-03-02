<?php 

use PHPMailer\PHPMailer\PHPMailer;
//Load Composer's autoloader
require '../vendor/autoload.php';
//send link in email
function send_mail($to, $to_email, $link, $password = null)
{
    $to=htmlspecialchars($to, ENT_QUOTES, 'UTF-8');

    $phpmailer = new PHPMailer();
    $phpmailer->isSMTP();
    $phpmailer->Host = 'sandbox.smtp.mailtrap.io';
    $phpmailer->SMTPAuth = true;
    $phpmailer->Port = 2525;
    $phpmailer->Username = '5e8975c2bfc3b2';
    $phpmailer->Password = 'e48578ee9627e1';

    //Recipients
    $phpmailer->setFrom('myproject@gmail.com');
    $phpmailer->addAddress($to_email, $to);
    $phpmailer->addReplyTo('myproject@gmail.com', 'Information');

    $phpmailer->isHTML(true);
    $phpmailer->Subject = 'Notification';
    $mail_template = "
    <h2>hello, " . $to . " </h2>
    <h3>you are receiving email because we will try to confirm your account.</h3>";

    if ($password !== null) {
        $mail_template .= "
    <h4>Your Email is :</h4> $to_email <br>
    <h4>Your password is :</h4> $password<br>";
    }

    $mail_template .= "<br><br><a href='$link'>click me</a>";
    $phpmailer->Body = $mail_template;
    return $phpmailer;
}