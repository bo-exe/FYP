<?php
session_start();

// Include the file that contains the common database connection code
include "dbFunctions.php";

$entered_username = $_POST['username'];
$entered_password = $_POST['password'];

$msg = "";

// Use prepared statements to prevent SQL injection
$queryCheck = "SELECT * FROM users WHERE username=?";
$stmt = mysqli_prepare($link, $queryCheck);
mysqli_stmt_bind_param($stmt, 's', $entered_username);
mysqli_stmt_execute($stmt);
$resultCheck = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($resultCheck) == 1) {
    $row = mysqli_fetch_array($resultCheck);

    // Verify the password using password_verify
    if (password_verify($entered_password, $row['password'])) {
        $_SESSION['userId'] = $row['userId'];
        $_SESSION['username'] = $row['username'];
        $msg = "<p><i>You are logged in as " . $_SESSION['username'] . "</p>";
        $msg .= "<p>Email: " . $row['email'] . "</p>";
        $msg .= "<p>Date of Birth: " . $row['dob'] . "</p>";
        $msg .= "<p><a href='index.html'>Home</a></p>";

        // Set the 'rememberUsername' cookie if the "Remember Me" checkbox is checked
        if (isset($_POST['remember'])) {
            setcookie('rememberUsername', $entered_username, time() + (60 * 60 * 24 * 7)); // Cookie expires in 7 days
        } else {
            // Clear the 'rememberUsername' cookie if the "Remember Me" checkbox is not checked
            setcookie('rememberUsername', '', time() - 3600);
        }
    } else {
        $msg = "<p>Invalid password. Please try again.</p>";
        $msg .= "<p><a href='Login.html'>Go back to login page</a></p>";
        $msg = "password received:" . $entered_password;
    }
} else {
    $msg = "<p>Username not found. Please try again.</p>";
    $msg .= "<p><a href='Login.html'>Go back to login page</a></p>";
}

mysqli_stmt_close($stmt);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Page</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="stylesheets/style.css"/>
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
    <div style="text-align: center;">
        <?php echo $msg; ?>
    </div>
</body>
</html>
