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
        body,
        html {
            height: 100%;
            font-family: 'Lato', sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .signup-container {
            max-width: 400px;
            width: 100%;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 50px; /* Reduced margin-top to move the container up */
        }

        .signup-container img {
            display: block;
            margin: 0 auto;
            margin-bottom: 20px;
            border-radius: 8px;
            width: 150px;
            height: 100px;
        }

        .text-center {
            text-align: center;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .btn-register {
            background-color: #FFD036;
            border: none;
            color: black;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
            font-size: 1rem;
            transition: background-color 0.3s ease;
            width: 100%;
        }

        .btn-register:hover {
            background-color: #e0b400;
            /* Hover color set to a slightly darker shade */
        }

        .form-text {
            margin-top: 20px;
            font-size: 0.9rem;
            color: #6c757d;
        }

        .form-control {
            width: 100%;
            padding: 8px;
            font-size: 1rem;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
    </style>
</head>

<body>
    <div class="signup-container">
        <form method="post" action="vol_doSignup.php">
            <img src="images/logo.jpg" alt="Logo">
            <h2 class="text-center mb-4">Become a volunteer with us.</h2>

            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" placeholder="Enter Username" name="username" required>
            </div>

            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" placeholder="Enter Your Full Name" name="name" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" placeholder="Enter Password" name="password" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" placeholder="Enter Email" name="email" required>
            </div>

            <div class="form-group">
                <label for="dob">Date of Birth</label>
                <input type="date" class="form-control" id="dob" name="dob" required>
            </div>

            <div class="form-group">
                <label for="gender">Gender</label>
                <select class="form-control" id="gender" name="gender" required>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-register">Register</button>
            </div>
            <div class="form-text text-center">
                Note: A link will be sent to your email for account verification purposes.
            </div>
        </form>
    </div>
</body>

</html>
