<?php
session_start();

// Check whether session variable 'user_id' is set (i.e., check whether the user is already logged in)
if (isset($_SESSION['user_id'])) {
    // Redirect to homepage if already logged in
    header("Location: http://localhost/fyp/");
    exit();
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up Page</title>
    <link rel="stylesheet" href="style.css">
    <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet'>
    <link rel="icon" type="image/x-icon" href="images/logo.jpg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body, html {
            height: 100%;
        }
        .signup-container {
            min-height: 80%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            margin-bottom: 50px; 
            margin-top: 200px !important;
        
        }

        
        .footer {
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
            background-color: #333;
            color: white;
            text-align: center;
            padding: 10px 0;
        }
        .btn-register {
    background-color: #FFD036; /* Background color set to #FFD036 */
    border: none;
    color: black;
    padding: 10px 20px;
    cursor: pointer;
    border-radius: 5px;
    font-size: 1rem;
    transition: background-color 0.3s ease;
}
.btn-register:hover {
    background-color: #e0b400; /* Hover color set to a slightly darker shade */
}

    </style>
</head>
<body>

    <div class="signup-container">
        <form method="post" action="doSignup.php">
            <h2 class="text-center mb-4">Become a volunteer with us.</h2>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" placeholder="Enter Username" name="username" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" placeholder="Enter Password" name="password" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" placeholder="Enter Email" name="email" required>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-register btn-block">Register</button>
            </div>
            <div class="form-text text-center mt-3">
                Note: A link will be sent to your email for account verification purposes.
            </div>
        </form>
    </div>
    
</body>
</html>