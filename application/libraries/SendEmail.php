<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\OAuth;
use PHPMailer\PHPMailer\Exception;
use League\OAuth2\Client\Provider\Google;

class SendEmail {

    public function getMailer() {
        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->SMTPDebug = SMTP::DEBUG_OFF;
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 465;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->SMTPAuth = true;
        $mail->AuthType = 'XOAUTH2';

        $clientId = $_ENV['CLIENT_ID'];
        $clientSecret = $_ENV['CLIENT_SECRET'];
        $refreshToken = $_ENV['REFRESH_TOKEN'];

        $provider = new Google(
            [
                'clientId' => $clientId,
                'clientSecret' => $clientSecret,
            ]
        );
        $mail->setOAuth(new OAuth([
            'provider' => $provider,
            'clientId' => $clientId,
            'clientSecret' => $clientSecret,
            'refreshToken' => $refreshToken,
            'userName' => $_ENV['SMTP_USER'],
        ]));

        return $mail;
    }

    public function send($to, $subject, $body) {
        $mail = $this->getMailer();

        $mail->isHTML(true);
        $mail->setFrom($_ENV['SMTP_USER'], 'Bali Mitra Medical Center');
        $mail->addAddress($to);
        $mail->Subject = $subject;
        $mail->CharSet = PHPMailer::CHARSET_UTF8;
        $mail->Body = $body;

        try {
            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}

?>