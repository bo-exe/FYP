<?php
session_start();
include "dbFunctions.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $verificationCode = rand(100000, 999999); // Generate a random 6-digit code

    // Save the code to the session for later verification
    $_SESSION['verification_code'] = $verificationCode;
    $_SESSION['form_data'] = $_POST; // Save the form data to session

    // Send the verification code to the user's email
    $subject = "Your Verification Code";
    $message = "Your verification code is: $verificationCode";
    $headers = "From: no-reply@example.com";

    if (mail($email, $subject, $message, $headers)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
}
