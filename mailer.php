<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
$config = require '/home/findinternship/config.php';

if ($_POST) {
    $to = "info@cihadcengiz.com"; // your mail here
    $name = filter_var($_POST["name"], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $subject = filter_var($_POST["subject"], FILTER_SANITIZE_STRING);
    $message = filter_var($_POST["message"], FILTER_SANITIZE_STRING);

    $mail = new PHPMailer(true);

    try {
        // SMTP ayarları
        $mail->isSMTP();
        $mail->Host       = $config['host'];
        $mail->Port       = $config['port'];
        $mail->SMTPAuth   = true;
        $mail->Username   = $config['username'];
        $mail->Password   = $config['password'];
        $mail->SMTPSecure = $config['encryption'];

        // Alıcı ve gönderici bilgileri
        $mail->setFrom('webmaster@example.com', 'Webmaster');
        $mail->addAddress($to);

        // İçerik
        $mail->isHTML(false); // HTML değil, düz metin olarak gönder
        $mail->Subject = $subject;
        $mail->Body    = "Name: $name\nE-mail: $email\nSubject: $subject\nMessage: $message";

        $mail->send();
        $output = json_encode(array('success' => true));
        die($output);
    } catch (Exception $e) {
        $output = json_encode(array('success' => false, 'error' => $mail->ErrorInfo));
        die($output);
    }
}
?>