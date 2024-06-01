<?php
session_start();

// Include the file that contains the common database connection code
include "dbFunctions.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare and bind SQL statement
    $query = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($link, $query);
    mysqli_stmt_bind_param($stmt, 'sss', $username, $email, $hashed_password);

    // Execute the statement
    if (mysqli_stmt_execute($stmt)) {
        // Redirect to the login page
        header("Location: login.php");
        exit;
    } else {
        // Display an error message if the query fails
        echo "Error: " . mysqli_error($link);
    }

    // Close the statement and database connection
    mysqli_stmt_close($stmt);
    mysqli_close($link);
} else {
    // If the form was not submitted, redirect to the signup page
    header("Location: forgotPassword.php");
    exit;
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
</head>
<body>
    <br>
    <div class="login-container">
    <img src="images/logo.jpg" alt="Description of the image" width="300" height="200">
        <form method="post" action="doLogin.php">
            <h2 class="text-center mb-4">Hello</h2>
            <br><br> 
            <div class="form-group">
                <label for="newpass">New Password</label>
                <input type="text" class="form-control" placeholder="Enter New Password" name="newpass" required>
            </div>
            <div class="form-group">
                <label for="cnewpass">Confirm New Password</label>
                <input type="text" class="form-control" placeholder="Confirm New Password" name="cnewpass" required>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-dark btn-block">Confirm and go to Login!</button>
            </div>
        </form>
    </div>
</body>
</html>
