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
    header("Location: signup.php");
    exit;
}
?>
