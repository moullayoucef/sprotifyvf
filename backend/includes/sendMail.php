<?php

// la fonction pour envoyé les emails 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';




function sendMail($subject ,$to , $message) {
        
        $mail = new PHPMailer(true);
        try {

        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'youcefmoulla01@gmail.com'; 
        $mail->Password   = 'jaej ffrr rjzc dqvm'; 
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
        
    
        $mail->setFrom('youcefmou1@gmail.com',"SPORTIFY");
        $mail->addAddress($to);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $message;
        
        $mail->send();
        echo 'Message envoyé avec succès'; 
        } catch (Exception $e) {
            echo "Erreur : {$mail->ErrorInfo}";
        }
}
?>
