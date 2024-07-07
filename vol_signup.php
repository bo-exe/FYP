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
            margin: 0;
            font-family: 'Lato', sans-serif;
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .signup-container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px 40px;
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        .signup-container .header {
            background-color: #FFD036;
            padding: 20px 0;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
            margin: -20px -40px 20px;
        }
        .signup-container img {
            width: 150px; /* Make the logo slightly bigger */
            height: auto;
            margin-bottom: 20px;
        }
        .signup-container h2 {
            margin-bottom: 20px;
            font-size: 1.5rem;
            color: #333;
        }
        .form-group {
            margin-bottom: 15px;
            text-align: left;
        }
        .form-group label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }
        .form-control {
            width: 100%;
            padding: 10px;
            margin: 5px 0 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
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
            margin-top: 10px;
        }
        .btn-register:hover {
            background-color: #e0b400;
        }
        .form-text {
            font-size: 0.9rem;
            color: #666;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="signup-container">
        <div class="header">
            <img src="images/logo.jpg" alt="Logo">
        </div>
        <form method="post" action="vol_doSignup.php">
            <h2>Become a volunteer with us</h2>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" placeholder="Enter Username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" placeholder="Enter Password" name="password" required>
            </div>
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" placeholder="Enter Name" name="name" required>
            </div>
            <div class="form-group">
                <label for="dob">Date of Birth</label>
                <input type="date" class="form-control" id="dob" placeholder="Enter Date of Birth" name="dob" required>
            </div>
            <div class="form-group">
                <label for="gender">Gender</label>
                <select class="form-control" id="gender" name="gender" required>
                    <option value="" disabled selected>Select Gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" placeholder="Enter Email" name="email" required>
            </div>
            <button type="submit" class="btn btn-register">Register</button>
            <div class="form-text">
                Note: A link will be sent to your email for account verification purposes.
            </div>
        </form>
    </div>
</body>
</html>




