<?php
session_start();
$msg = "";

// Debugging: Check the current session status
echo '<pre>';
print_r($_SESSION);
echo '</pre>';

// Check whether session variable 'user_id' is set (i.e., check whether the user is already logged in)
if (isset($_SESSION['userId'])) {
    $msg = "You are already logged in.";
} else {
    // Check whether all form inputs contain values
    if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['email']) && isset($_POST['name']) && isset($_POST['dob']) && isset($_POST['gender'])) {
        // Clear session variables
        session_unset();
        
        // Retrieve form data
        $entered_username = $_POST['username'];
        $entered_password = $_POST['password'];
        $entered_email = $_POST['email'];
        $entered_name = $_POST['name'];
        $entered_dob = $_POST['dob'];
        $entered_gender = $_POST['gender'];

        // Connect to database
        include ("dbFunctions.php");

        // Check if the username or email already exists
        $query = "SELECT * FROM volunteers WHERE username='$entered_username' OR email='$entered_email'";
        $result = mysqli_query($link, $query) or die(mysqli_error($link));

        if (mysqli_num_rows($result) == 0) {
            // If the username and email do not exist, proceed to insert new volunteer
            $hashed_password = password_hash($entered_password, PASSWORD_DEFAULT);

            $insert_query = "INSERT INTO volunteers (username, password, name, email, role, points, dob, gender)
                             VALUES ('$entered_username', '$hashed_password', '$entered_name', '$entered_email', 'volunteer', 0, '$entered_dob', '$entered_gender')";

            if (mysqli_query($link, $insert_query)) {
                // Store a success message
                $msg = "Registration successful! Please login.";

                // Redirect to login page
                header("Location: vol_login.php");
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

