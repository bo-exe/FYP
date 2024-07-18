<?php
session_start();
include "dbFunctions.php";
include "ft.php";

$entered_username = $_POST['username'];
$entered_password = $_POST['password'];

$msg = "";

$queryCheck = "SELECT * FROM admins WHERE username='$entered_username' AND password='$entered_password' AND approval_status='1'";

$resultCheck = mysqli_query($link, $queryCheck) or die(mysqli_error($link));

if (mysqli_num_rows($resultCheck) == 1) {
    $row = mysqli_fetch_array($resultCheck);
    $_SESSION['adminID'] = $row['adminID'];
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
        case 'cashierAdmin':
            header("Location: admin_cashierHome.php");
            exit();
        case 'retailAdmin':
            header("Location: admin_retailHome.php");
            exit();
        case 'vomoAdmin':
            header("Location: admin_teamHome.php");
            exit();
        case 'volunteerAdmin':
            header("Location: admin_volunteerHome.php");
            exit();
    }
}

else {
    $msg = "<p>Sorry, you must enter a valid username and password to log in.</p>";
    $msg .= "<p>If you have already signed up, please wait for your account's approval before logging in.</p>";
    $msg .= '<p style="margin-top: 20px; text-align: center;"><a href="admin_login.php" class="btn btn-custom">Go back to login page</a></p>';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {

        }
        .login-container {
            background-color: #FFD036;
            max-width: 400px;
            margin: 0 auto;
            padding: 40px; /* Increased padding for more space */
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .login-container img {
            display: block;
            margin: 0 auto;
            margin-bottom: 20px;
            border-radius: 8px;
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
            background-color: #e6bb2e;
            color: #FFFFFF;
        }
    </style>
</head>
<body>
    <br>
    <div class="login-container">
        <img src="images/admin_logo.jpg" alt="Description of the image" width="300" height="200">
        <div style="text-align: center;">
            <?php echo $msg; ?>
        </div>
    </div>
</body>
</html>
