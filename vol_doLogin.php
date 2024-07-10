<?php
session_start();

// Include the file that contains the common database connection code
include "dbFunctions.php";
include "ft.php";

$entered_username = $_POST['username'];
$entered_password = $_POST['password'];

$msg = "";

$queryCheck = "SELECT * FROM volunteers WHERE username='$entered_username' AND password='$entered_password'";
$resultCheck = mysqli_query($link, $queryCheck) or die(mysqli_error($link));

if (mysqli_num_rows($resultCheck) == 1) {
    $row = mysqli_fetch_array($resultCheck);
    $_SESSION['volunteerID'] = $row['volunteerID'];
    $_SESSION['username'] = $row['username'];
    $_SESSION['role'] = $row['role'];

    // Set the 'rememberUsername' cookie if the "Remember Me" checkbox is checked
    if (isset($_POST['remember'])) {
        setcookie('rememberUsername', $entered_username, time() + (60 * 60 * 24 * 7)); // Cookie expires in 7 days
    } else {
        // Clear the 'rememberUsername' cookie if the "Remember Me" checkbox is not checked
        setcookie('rememberUsername', '', time() - 3600);
    }

    // Redirect based on user role
    switch ($_SESSION['role']) {
        case 'volunteer':
            header("Location: index.php");
            break;
        default:
            header("Location: index.php");
            break;
    }
    exit(); // Ensure no further code is executed after redirection
} else {
    $msg = "<p>Sorry, you must enter a valid username and password to log in</p>";
    $msg .= "<a href='vol_login.php' class='btn btn-custom'>Go back to login page</a>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css"> <!-- Ensure style.css is appropriately linked for styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body, h1, h2, h3, h4, h5, h6 {
            margin: 0;
            padding: 0;
        }
        .w3-bar-block .w3-bar-item {
            padding: 20px;
        }
        .login-container {
            background-color: #FFD036; /* Yellow background color */
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            margin-top: 20px;
            max-width: 400px;
            margin-left: auto;
            margin-right: auto;
        }
        .btn-custom {
            background-color: #343A40; /* Dark background color */
            border-color: #343A40;
            color: #FFFFFF; /* White text color */
            padding: 10px 20px; /* Adjust padding as needed */
            text-decoration: none; /* Remove underline from link */
            display: inline-block; /* Make it behave like a block-level element */
            transition: background-color 0.3s ease; /* Smooth transition */
        }
        .btn-custom:hover {
            background-color: #23272B; /* Darker shade for hover effect */
            border-color: #23272B;
            color: #FFFFFF; /* White text color */
        }
    </style>
</head>
<body>
    <div class="login-container">
        <img src="images/logo.jpg" alt="Description of the image" width="300" height="200">
        <div style="text-align: center; margin-top: 20px;">
            <?php echo $msg; ?>
        </div>
    </div>
</body>
</html>
