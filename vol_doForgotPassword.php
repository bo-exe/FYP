<?php
session_start();
include "dbFunctions.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/phpmailer/phpmailer/src/Exception.php';
require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/phpmailer/src/SMTP.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    if (empty($email)) {
        echo json_encode(['success' => false, 'message' => 'Email is required.']);
        exit;
    }

    // Check if the email exists in the volunteers table and get the volunteerID
    $query = "SELECT volunteerId AS id, 'volunteer' AS role FROM volunteers WHERE email = ?
              UNION
              SELECT adminID AS id, 'admin' AS role FROM admins WHERE email = ?";
    $stmt = $link->prepare($query);
    $stmt->bind_param("ss", $email, $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    if (!$user) {
        echo json_encode(['success' => false, 'message' => 'Email does not exist.']);
        exit;
    }

    $userID = $user['id'];
    $userRole = $user['role'];

    // Generate a random token
    $token = bin2hex(random_bytes(32));
    $expires_at = date('Y-m-d H:i:s', strtotime('+1 day'));

    // Insert token and expiry into password_resets table
    $query = "INSERT INTO password_resets (volunteerID, email, token, expires_at) VALUES (?, ?, ?, ?)
              ON DUPLICATE KEY UPDATE token=?, expires_at=?";
    $stmt = $link->prepare($query);
    $stmt->bind_param("isssss", $userID, $email, $token, $expires_at, $token, $expires_at);
    $stmt->execute();
    $stmt->close();

    // Send the reset link to the user's email using PHPMailer
    $mail = new PHPMailer(true);
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'sandbox.smtp.mailtrap.io'; // Mailtrap SMTP server
        $mail->SMTPAuth   = true;
        $mail->Username   = '171e781cafa9b9'; // Mailtrap username
        $mail->Password   = 'b06e4a81923958'; // Mailtrap password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Recipients
        $mail->setFrom('leia@ng.com', 'Your Name');
        $mail->addAddress($email);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Password Reset Request';
        $mail->Body    = "Click the link to reset your password: <a href='http://localhost/Github/FYP/vol_resetpassword.php?token=$token'>Reset Password</a>";

        $mail->send();
        
        // Redirect to login page after email is sent
        header("Location: vol_login.php");
        exit();
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
