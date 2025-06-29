<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


require __DIR__ . '/vendor/autoload.php';


function sendActivationEmail($email, $full_name, $activationToken) {
    $mail = new PHPMailer(true);

    try {

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'jasperkarl1231@gmail.com';
        $mail->Password = 'hyyrzayuhqkwdhrj'; // Use a secure password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;

        // Sender and recipient settings
        $mail->setFrom('jasperkarl1231@gmail.com', 'CICTO Admin');
        $mail->addAddress($email, $full_name);

        // Email content for the welcome and activation email
        $mail->isHTML(true);
        $mail->Subject = 'Welcome to CICTO Technician! Account Activation Required';
        $mail->Body = <<<END
        <h1>Welcome, $full_name!</h1>
        <p>Thank you for signing up. Your email address <b>$email</b> has been successfully registered with us.</p>
        <p>Click <a href="http://localhost/Technical and Maintenance Services Ticketing System(TMSTS)/cicto/administrator/account/activate-account.php?token=$activationToken">HERE</a> 
        to activate your account. The link will expire in 30 minutes.</p>
        END;
        $mail->AltBody = "Welcome, $full_name! Thank you for signing up. Your email address $email has been successfully registered with us. Click the following link to activate your account: http://localhost/Technical and Maintenance Services Ticketing System(TMSTS)/cicto/administrator/account/activate-account.php?token=$activationToken";

        // Send the email
        $mail->send();
        return true;
    } catch (Exception $e) {
        return 'Mailer error: ' . $mail->ErrorInfo;
    }
}
?>
