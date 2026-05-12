<?php
namespace MMIG46\Services;
use MMIG46\Core\Env;
use PHPMailer\PHPMailer\PHPMailer;
final class Mailer {
    public static function send(string $to, string $subject, string $body): bool {
        if (class_exists(PHPMailer::class)) {
            $mail = new PHPMailer(true);
            $mail->isSMTP(); $mail->Host=Env::get('MAIL_HOST',''); $mail->SMTPAuth=true; $mail->Username=Env::get('MAIL_USERNAME',''); $mail->Password=Env::get('MAIL_PASSWORD',''); $mail->SMTPSecure=Env::get('MAIL_ENCRYPTION','ssl'); $mail->Port=(int)Env::get('MAIL_PORT','465');
            $mail->setFrom(Env::get('MAIL_FROM','dr.gerecht@mmig46.org'), Env::get('MAIL_FROM_NAME','MMIG46'));
            foreach (array_map('trim', explode(',', $to)) as $addr) if ($addr) $mail->addAddress($addr);
            $mail->Subject=$subject; $mail->Body=$body; return $mail->send();
        }
        return mail($to, $subject, $body, 'From: '.Env::get('MAIL_FROM','dr.gerecht@mmig46.org'));
    }
}
