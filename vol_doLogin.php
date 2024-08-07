<?php
session_start();

// Include the file that contains the common database connection code
include "dbFunctions.php";

$entered_username = $_POST['username'];
$entered_password = $_POST['password'];

$msg = "";

// Use prepared statements to prevent SQL injection
$queryCheck = "SELECT volunteerId, username, role, password FROM volunteers WHERE username = ?";
$stmt = mysqli_prepare($link, $queryCheck);
mysqli_stmt_bind_param($stmt, 's', $entered_username);
mysqli_stmt_execute($stmt);
$resultCheck = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($resultCheck) == 1) {
    $row = mysqli_fetch_array($resultCheck);

    // Verify the password
    if (password_verify($entered_password, $row['password'])) {
        $_SESSION['volunteerId'] = $row['volunteerId'];
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
            case 'retailAdmin':
                header("Location: admin_retailHome.php");
                break;
            case 'vomoAdmin':
                header("Location: admin_vomoHome.php");
                break;
            case 'volunteerAdmin':
                header("Location: admin_volunteerHome.php");
                break;    
            default:
                header("Location: index.php");
                break;
        }
        exit(); // Ensure no further code is executed after redirection
    } else {
        $msg = "<p>Sorry, you must enter a valid username and password to log in</p>";
        $msg .= "<p><a href='vol_login.php'>Go back to login page</a></p>";
    }
} else {
    $msg = "<p>Sorry, you must enter a valid username and password to log in</p>";
    $msg .= "<p><a href='vol_login.php'>Go back to login page</a></p>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Page</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="stylesheets/GAstylesheet.css"/>
    <style>
        body, h1, h2, h3, h4, h5, h6 {
            font-family: "Karma", sans-serif;
        }
        .w3-bar-block .w3-bar-item {
            padding: 20px;
        }
    </style>
</head>
<body>
    <?php include "vol_navbar.php"; ?>
        
    <div style="text-align: center; margin-top:100px">
        <?php echo $msg; ?>
    </div>
</body>
</html>
