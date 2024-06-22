<?php
session_start();
include "dbFunctions.php";
include "ft.php";

// Check if form data has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $date = $_POST['date'];
    $username = $_POST['username'];
    $description = $_POST['description'];
    
    $date = mysqli_real_escape_string($link, $date);
    $username = mysqli_real_escape_string($link, $username);
    $description = mysqli_real_escape_string($link, $description);

    $query = "INSERT INTO contact (date, username, description) VALUES ('$date', '$username', '$description')";
    if (mysqli_query($link, $query)) {
        $message = "Form submitted successfully!";
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
            background: #FFD036;
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
        <img src="images/logo.jpg" alt="Logo" width="300" height="200">
        <form method="post" action="index.php">
            <h2 class="text-center mb-4">Contact Us Form</h2>
            <h3 class="text-center mb-4">Sent Successfully</h3>
            <img src="images/tick.jpg" alt="Tick" height="150" width="150">
            <div class="text-center">
                <button type="submit" class="btn btn-block">Back</button>
            </div>
        </form>
    </div>
</body>
</html>
