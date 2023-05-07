<?php

namespace Apps\Controller\Acceuil;


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class sendService

{

    public static function sendMailer(string $mailUser, string $nameUser, string $Body, string $Subject): bool
    {
        //Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function

//Load Composer's autoloader
//require 'vendor/autoload.php';

//Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {
            //Server settings
//$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host = $_ENV["MAILER_SMTP"];                     //Set the SMTP server to send through
            $mail->SMTPAuth = true;                                   //Enable SMTP authentication
            $mail->Username = $_ENV["MAILER_USER"];                     //SMTP username
            $mail->Password = $_ENV["MAILER_PASSWORD"];                               //SMTP password
//$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port = $_ENV["MAILER_PORT"];                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom($_ENV["MAILER_MAIL_FROM"], $_ENV["MAILER_NAME_FROM"]);
            $mail->addAddress($mailUser, $nameUser);     //Add a recipient


            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = $Subject;
            $mail->Body = $Body;
            $mail->AltBody = $Body;

            $mail->send();
            return true;
        } catch (Exception $e) {
            return "Le message n'a pas pu etre envoyé. Mailer Erreur: {$mail->ErrorSfo}";
        }
    }
}
