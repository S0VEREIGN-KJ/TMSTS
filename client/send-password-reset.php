<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/vendor/autoload.php';

// Function to send a password reset email
function sendPasswordResetEmail($email, $token) {
    $mail = new PHPMailer(true);


    try {
 $mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'jasperkarl1231@gmail.com';
        $mail->Password = 'hyyrzayuhqkwdhrj'; // Use a secure password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;

        // Sender and recipient settings
        $mail->setFrom('jasperkarl1231@gmail.com', 'CICTO Admin');
        $mail->addAddress($email, $firstName);

      // Email content for the password reset
      $mail->isHTML(true);
      $mail->Subject = 'Password Reset Request';
      $mail->Body = <<<END
      <h1>Password Reset Request</h1>
      <p>We received a request to reset your password. If this was you, click the link below:</p>
      <p><a href="http://localhost/Technical and Maintenance Services Ticketing System(TMSTS)/client/reset-password.php?token=$token">Reset Your Password</a></p>
      <p>If you did not request a password reset, please ignore this email.</p>
      END;
      $mail->AltBody = "We received a request to reset your password. If this was you, visit the following link to reset your password: http://localhost/Technical and Maintenance Services Ticketing System(TMSTS)/client/reset-password.php?token=$token";

        // Send the email
        $mail->send();
        return true;
    } catch (Exception $e) {
        return 'Mailer error: ' . $mail->ErrorInfo;
    }
}

// Main logic for handling password reset
$email = $_POST["email"];

$token = bin2hex(random_bytes(16));
$token_hash = hash("sha256", $token);
$expiry = date("Y-m-d H:i:s", time() + 60 * 30);

$mysqli = require __DIR__ . "/database.php";

// Check if the email exists in the technician table
$sql = "SELECT 1 FROM technician WHERE email = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $table = "technician";
} else {
    $table = "account";
}

// Update the reset token in the appropriate table
$sql = "UPDATE $table
        SET reset_token_hash = ?,
            reset_token_expires_at = ?
        WHERE email = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("sss", $token_hash, $expiry, $email);
$stmt->execute();

if ($mysqli->affected_rows) {
    if (sendPasswordResetEmail($email, $token)) {
        echo "Message sent, please check your inbox.";
    } else {
        echo "Message could not be sent.";
    }
} else {
    echo "No account found with that email address.";
}
?>
