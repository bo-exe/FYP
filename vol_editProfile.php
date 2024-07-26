<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['volunteerId'])) {
    // Redirect to login page if not logged in
    header("Location: vol_login.php");
    exit();
}
include "dbFunctions.php";

$volunteerId = $_SESSION['volunteerId'];
$query = "SELECT * FROM volunteers WHERE volunteerId = ?";
$stmt = mysqli_prepare($link, $query);
mysqli_stmt_bind_param($stmt, "i", $volunteerId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);
    $name = $row['name'];
    $username = $row['username'];
    $email = $row['email'];
    $password = $row['password'];
    $role = $row['role'];
    $points = $row['points'];
    $dob = $row['dob'];
    $gender = $row['gender'];
    $profile_pic = $row['profile_pic'];
    // No need to fetch password here if you're not displaying it
} else {
    // Handle error if user data not found
    echo "Error: User data not found.";
    exit();
}

// Handle form submission for updating user profile
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input data
    $name = mysqli_real_escape_string($link, $_POST['name']);
    $username = mysqli_real_escape_string($link, $_POST['username']);
    $email = mysqli_real_escape_string($link, $_POST['email']);
    $dob = mysqli_real_escape_string($link, $_POST['dob']);
    $gender = mysqli_real_escape_string($link, $_POST['gender']);

    // Check if a new password is submitted
    if (!empty($_POST['password'])) {
        // Sanitize and hash the password
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    } else {
        // If password field is empty, keep the current password
        $password = $row['password'];
    }

    // Check if a profile picture is uploaded
    if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == 0) {
        // Define the allowed file types and max file size
        $allowed_types = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "png" => "image/png");
        $max_file_size = 5 * 1024 * 1024; // 5MB

        // Get the file details
        $file_name = $_FILES['profile_pic']['name'];
        $file_type = $_FILES['profile_pic']['type'];
        $file_size = $_FILES['profile_pic']['size'];
        $file_tmp_name = $_FILES['profile_pic']['tmp_name'];

        // Validate file type and size
        $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
        if (!array_key_exists($file_ext, $allowed_types) || $file_size > $max_file_size) {
            echo "Error: Invalid file type or file size too large.";
            exit();
        }

        // Define the upload path and move the uploaded file
        $new_file_name = $adminID . "." . $file_ext;
        $upload_path = "images/" . $new_file_name;
        if (move_uploaded_file($file_tmp_name, $upload_path)) {
            // File upload successful, update the profile picture path
            $profile_pic = $new_file_name;
            echo "File uploaded successfully to " . $upload_path; // Debugging statement
        } else {
            echo "Error: There was a problem uploading the file.";
            exit();
        }
    }

    // Update user data in the database
    $query = "UPDATE volunteers SET name = ?, username = ?, email = ?, profile_pic = ?, password = ?, dob = ?, gender = ? WHERE volunteerId = ?";
    $stmt = mysqli_prepare($link, $query);
    mysqli_stmt_bind_param($stmt, "sssssssi", $name, $username, $email, $profile_pic, $password, $dob, $gender, $volunteerId);
    if (mysqli_stmt_execute($stmt)) {
        // Update session variables if necessary
        $_SESSION['username'] = $username; // Update session with new username if changed

        // Redirect to profile page with updated information
        header("Location: vol_Profile.php");
        exit();
    } else {
        // Handle update error
        echo "Error updating profile: " . mysqli_error($link);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<style>
    .profile-container img {
            width: 150px;
            height: 150px;
            /* border-radius: 50%; */
            margin-bottom: 20px;
    }

    .btn-save-profile {
        display: inline-block;
        padding: 8px 20px;
        background-color: #FFD036;
        text-decoration: none;
        border-radius: 30px;
        margin-top: 16px;
        margin-left: 5px;
        margin-bottom: 10px;
        color: #FFF5F5;
        font-weight: bold;
    }

    .btn-save-profile:hover {
        background-color: #ffcd00;
        color: #d9d9d9;
    }
</style>

<body>
    <?php include "vol_navBar.php"; ?>
    <?php include "ft.php"; ?>
    <div class="profile-container">
        <img src="images/logo.jpg" alt="Vol Logo" class="profile-logo">
        <h1 class="profile-heading">Edit Profile</h1>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
        <div class="profile-details">
            <img src="images/<?php echo htmlspecialchars($profile_pic); ?>" alt="Profile Picture" class="profile-picture">
            <div class="mb-3">
                <label for="profile_pic" class="form-label">Profile Picture</label>
                <input type="file" class="form-control" id="profile_pic" name="profile_pic">
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Name:</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
            </div>
            <div class="mb-3">
                <label for="username" class="form-label">Username:</label>
                <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
            </div>
            <div class="mb-3">
                <label for="dob" class="form-label">Date of Birth:</label>
                <input type="date" class="form-control" id="dob" name="dob" value="<?php echo htmlspecialchars($dob); ?>" required>
            </div>
            <div class="mb-3">
                <label for="gender" class="form-label">Gender:</label>
                <select class="form-select" id="gender" name="gender" required>
                    <option value="Male" <?php if ($gender == 'Male') echo 'selected'; ?>>Male</option>
                    <option value="Female" <?php if ($gender == 'Female') echo 'selected'; ?>>Female</option>
                    <option value="Other" <?php if ($gender == 'Other') echo 'selected'; ?>>Other</option>
                </select>
            </div>
            <p class="form-text text-center mt-3"><a href="vol_forgotPassword.php">Forgot Your Password? Change Now!</a></p>

            <!-- Save button -->
            <div class="text-center">
                <button type="submit" class="btn-save-profile">Save Profile</button>
            </div>
        </div>
    </form>
    </div>

    <script>
        function togglePassword() {
            var passwordField = document.getElementById("password");
            var passwordFieldType = passwordField.getAttribute("type");
            var toggleIcon = document.querySelector(".toggle-password i");
            if (passwordFieldType == "password") {
                passwordField.setAttribute("type", "text");
                toggleIcon.classList.remove("fa-eye");
                toggleIcon.classList.add("fa-eye-slash");
            } else {
                passwordField.setAttribute("type", "password");
                toggleIcon.classList.remove("fa-eye-slash");
                toggleIcon.classList.add("fa-eye");
            }
        }
    </script>
</body>

</html>
