<?php
session_start();
$msg = "";

// Check whether session variable 'user_id' is set (i.e., check whether the user is already logged in)
if (isset($_SESSION['userId'])) {
    $msg = "You are already logged in.";
} else {
    // Check whether form input 'username' contains value
    if (isset($_POST['username'])) {
        // Retrieve form data
        $entered_username = $_POST['username'];
        $entered_password = $_POST['password'];
        $entered_email = $_POST['email'];

        // Connect to database
        include ("dbFunctions.php");

        // Check if the username or email already exists
        $query = "SELECT * FROM volunteers WHERE username='$entered_username' OR email='$entered_email'";
        $result = mysqli_query($link, $query) or die(mysqli_error($link));

        if (mysqli_num_rows($result) == 0) {
            // If the username and email do not exist, proceed to insert new volunteer
            $hashed_password = password_hash($entered_password, PASSWORD_DEFAULT);

            $insert_query = "INSERT INTO volunteers (username, password, email, role, points, approval_status)
                             VALUES ('$entered_username', '$hashed_password', '$entered_email', 'volunteer', 0, 'pending')";

            if (mysqli_query($link, $insert_query)) {
                // Get the ID of the newly inserted record
                $new_user_id = mysqli_insert_id($link);

                // Store user ID and username into session
                $_SESSION['user_id'] = $new_user_id;
                $_SESSION['username'] = $entered_username;
                $_SESSION['email'] = $entered_email;

                $msg = "<p><i>You are logged in as " . $_SESSION['username'] . "</p>";
                $msg .= "<p><a href='home.php'>Home</a></p>";

                // Redirect to homepage
                header("Location: http://localhost/fyp/");
                exit();
            } else {
                $msg = "Error: " . mysqli_error($link);
            }
        } else {
            $msg = "Sorry, the username or email is already taken.";
        }
    } else {
        $msg = "Please fill in all the required fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup Status</title>
</head>
<body>
    <?php echo $msg; ?>
</body>
</html>
