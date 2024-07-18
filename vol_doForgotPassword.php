<?php
session_start();
include "dbFunctions.php"; 

$message = ""; // Variable to store message

// Check if form data has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($link, $_POST['email']);

    // Check if email exists in the admins table
    $query = "SELECT * FROM admins WHERE email = '$email'";
    $result = mysqli_query($link, $query);

    if (!$result) {
        die("Query Failed: " . mysqli_error($link));
    }

    // If not found in admins, check volunteers table
    if (mysqli_num_rows($result) == 0) {
        $query = "SELECT * FROM volunteers WHERE email = '$email'";
        $result = mysqli_query($link, $query);

        if (!$result) {
            die("Query Failed: " . mysqli_error($link));
        }
    }

    // If email is found in either table
    if (mysqli_num_rows($result) > 0) {
        $token = bin2hex(random_bytes(50));
        $expiry = date("Y-m-d H:i:s", strtotime('+1 hour')); 
        $query = "INSERT INTO password_resets (email, token, expires_at) VALUES ('$email', '$token', '$expiry')";
        if (mysqli_query($link, $query)) {
            $resetLink = "http://localhost/resetPassword.php?token=" . $token;

            $subject = "Password Reset Request";
            $message = "Hello, you requested a password reset. Click the link below to reset your password:\n\n";
            $message .= $resetLink;
            $headers = "From: no-reply@yourwebsite.com";

            if (mail($email, $subject, $message, $headers)) {
                $message = "A password reset link has been sent to your email.";
            } else {
                $message = "Failed to send email.";
            }
        } else {
            $message = "Failed to insert token into the database: " . mysqli_error($link);
        }
    } else {
        $message = "No account found with that email address.";
    }

    mysqli_close($link);
} else {
    $message = "Invalid request method.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="icon" type="image/x-icon" href="images/logo.jpg">
    <link rel="stylesheet" href="style.css">
    <style>
        .container {
            background: #FFFFFF;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .btn {
            padding: 0.3rem 0.7rem;
            background: #FFD036;
            border-radius: .6rem;
            box-shadow: 0 .2rem .5rem #333;
            font-size: 0.8rem;
            color: #333;
            letter-spacing: .1rem;
            font-weight: 600;
            border: .2rem solid transparent;
            margin-top: 16px;
            text-decoration: none;
            text-align: center;
        }

        .btn:hover {
            background-color: #e6bb2e
            color: #333; 
            border: .2rem solid transparent;
        }
        
        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
    <br>
    <div class="container">
    <img src="images/logo.jpg" alt="Description of the image" width="300" height="200">
        <form method="post" action="doForgotPassword.php">
            <h2 class="text-center mb-4">Forgot Your Password?</h2>
            <br><br>
            <?php
            if (!empty($message)) {
                echo "<p class='text-center'>$message</p>";
            }
            ?>
        </form>
    </div>
</body>
</html>
