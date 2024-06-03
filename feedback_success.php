<?php
session_start();
include "dbFunctions.php";

// Check if form data has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $date = $_POST['date'];
    $username = $_POST['username'];
    $description = $_POST['description'];
    
    $date = mysqli_real_escape_string($link, $date);
    $username = mysqli_real_escape_string($link, $username);
    $description = mysqli_real_escape_string($link, $description);

    $query = "INSERT INTO feedback (date, username, description) VALUES ('$date', '$username', '$description')";
    if (mysqli_query($link, $query)) {
        $message = "Feedback submitted successfully!";
    } else {
        $message = "Error: " . $query . "<br>" . mysqli_error($link);
    }
    
    // Close the database connection
    mysqli_close($link);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback</title>
    <link rel="icon" type="image/x-icon" href="images/logo.jpg">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <br>
    <div class="login-container">
    <img src="images/logo.jpg" alt="Description of the image" width="300" height="200">
        <form method="post" action="doLogin.php">
            <h2 class="text-center mb-4">Feeback Form</h2>
            <h3 class="text-center mb-4">Sent Successfully</h3>
            <img src="images/tick.jpg" alt="Description of the image" height="200">
            <div class="text-center">
                <button type="submit" class="btn btn-dark btn-block">Back</button>
            </div>
        </form>
    </div>
</body>
</html>


