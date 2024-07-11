<?php
session_start();
$msg = "";

// Debugging: Check the current session status
echo '<pre>';
print_r($_SESSION);
echo '</pre>';

// Check whether session variable 'adminID' is set (i.e., check whether the user is already logged in)
if (isset($_SESSION['adminID'])) {
    $msg = "You are already logged in.";
} else {
    // Check whether all form inputs contain values
    if (isset($_POST['company']) && isset($_POST['username']) && isset($_POST['password']) && isset($_POST['name']) && isset($_POST['number']) && isset($_POST['email']) && isset($_POST['role'])) {
        // Clear session variables
        session_unset();
        
        // Retrieve form data
        $company = $_POST['company'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $name = $_POST['name'];
        $number = $_POST['number'];
        $email = $_POST['email'];
        $role = $_POST['role'];

        // Connect to database
        include("dbFunctions.php");

        // Check if the username or email already exists
        $query = "SELECT * FROM admins WHERE username='$username' OR email='$email'";
        $result = mysqli_query($link, $query) or die(mysqli_error($link));

        if (mysqli_num_rows($result) == 0) {
            // If the username and email do not exist, proceed to insert new admin
            $insert_query = "INSERT INTO admins (company, username, password, name, number, email, role, approval_status)
                             VALUES ('$company', '$username', '$password', '$name', '$number', '$email', '$role', 'pending')";

            if (mysqli_query($link, $insert_query)) {
                // Get the ID of the newly inserted record
                $new_admin_id = mysqli_insert_id($link);

                // Store user ID and username into session
                $_SESSION['adminID'] = $new_admin_id;
                $_SESSION['username'] = $username;
                $_SESSION['email'] = $email;

                // Redirect to login page
                header("Location: admin_login.php");
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
