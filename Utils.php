<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

class Utils
{
    public function checkCookie($cookie) {
        include 'config.php';
        if(isset($_COOKIE[$cookie])) {
            $req = $db->prepare('SELECT COUNT(*) FROM tokens_admin WHERE token = :cookie');
            $req->execute(array(
                'cookie' => $_COOKIE[$cookie]
            ));
            $req = $req->fetch();
            if ($req[0] == 1) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function sendRecoveryEmail($email, $token) {
        $mail = new PHPMailer(true);
        include 'config.php';
        try {
            $mail->isSMTP();
            $mail->CharSet = 'UTF-8';
            $mail->Host = $mailConfig['host'];
            $mail->SMTPAuth = true;
            $mail->Username = $mailConfig['username'];
            $mail->Password = $mailConfig['password'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = $mailConfig['port'];
            $mail->setFrom($mailConfig['username'], 'Eloquéncia');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'Récupération de votre mot de passe';
            $mail->Body = 'Bonjour,<br><br>Vous avez demandé la réinitialisation de votre mot de passe. Pour ce faire, veuillez cliquer sur le lien suivant : <a href="https://eloquencia.org/admin/resetpassword.php?reset=' . $token . '">Réinitialiser mon mot de passe</a><br><br>Cordialement,<br>L\'équipe Eloquéncia';
            $mail->send();
        } catch (Exception $e) {
            echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
        }
    }

    public function sendValidDiscountEmail($email, $code) {
        $mail = new PHPMailer(true);
        include 'config.php';
        try {
            $mail->isSMTP();
            $mail->CharSet = 'UTF-8';
            $mail->Host = $mailConfig['host'];
            $mail->SMTPAuth = true;
            $mail->Username = $mailConfig['username'];
            $mail->Password = $mailConfig['password'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = $mailConfig['port'];
            $mail->setFrom($mailConfig['username'], 'Eloquéncia');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'Votre code de réduction Eloquéncia';
            $mail->Body = 'Bonjour,<br><br>Vous avez demandé un code de réduction sur notre site. Après vérification, nous vous avons attribué le code suivant : <strong>' . $code . '</strong><br><br>Cordialement,<br>L\'équipe Eloquéncia';
            $mail->send();
        } catch (Exception $e) {
            echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
        }
    }

    public function sendInvalidDiscountEmail($email) {
        $mail = new PHPMailer(true);
        include 'config.php';
        try {
            $mail->isSMTP();
            $mail->CharSet = 'UTF-8';
            $mail->Host = $mailConfig['host'];
            $mail->SMTPAuth = true;
            $mail->Username = $mailConfig['username'];
            $mail->Password = $mailConfig['password'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = $mailConfig['port'];
            $mail->setFrom($mailConfig['username'], 'Eloquéncia');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'Votre demande de réduction Eloquéncia';
            $mail->Body = 'Bonjour,<br><br>Votre demande de réduction a été refusée. Veuillez nous contacter pour plus d\'informations.<br><br>Cordialement,<br>L\'équipe Eloquéncia';
            $mail->send();
        } catch (Exception $e) {
            echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
        }
    }

    public function getProof($id) {
        include 'config.php';
        $req = $db->prepare('SELECT proof FROM discounts WHERE ID = :id');
        $req->execute(array(
            'id' => $id
        ));
        $data = $req->fetch();
        return (base64_encode($data['proof']));
    }

    public function getChaptersNameList() {
        include 'config.php';
        $req = $db->prepare('SELECT ID, name FROM lessons_chapters');
        $req->execute();
        return $req->fetchAll();
    }
}