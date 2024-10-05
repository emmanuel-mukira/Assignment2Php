<?php
require __DIR__ . '/../vendor/autoload.php'; // Adjusted path to the autoload.php

// Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv;

class SendMail {

    public function SendMail($mailMsg) {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->load();

        // Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->SMTPDebug = 0;                      // Enable verbose debug output
            $mail->isSMTP();                           // Send using SMTP
            $mail->Host       = 'smtp.gmail.com';     // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                  // Enable SMTP authentication
            $mail->Username   = $_ENV['MAIL_USERNAME']; // SMTP username
            $mail->Password   = $_ENV['MAIL_PASSWORD'];                     // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Enable implicit TLS encryption
            $mail->Port       = 465;                   // TCP port to connect to; use 587 if you have set 

            // Recipients
            $mail->setFrom('ics@gmail.com', 'ICS 2024');
            $mail->addAddress($mailMsg['to_email'], $mailMsg['to_name']); // Add a recipient

            // Content
            $mail->isHTML(true);                      // Set email format to HTML
            $mail->Subject = $mailMsg['subject'];
            $mail->Body    = nl2br($mailMsg['message']);

            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            die("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
        }
    }
}
