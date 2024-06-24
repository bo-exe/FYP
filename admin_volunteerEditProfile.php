<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['adminID'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}
include "dbFunctions.php";

// Fetch user data from database based on session userId
$adminID = $_SESSION['adminID'];
$query = "SELECT * FROM admins WHERE adminID = ?";
$stmt = mysqli_prepare($link, $query);
mysqli_stmt_bind_param($stmt, "i", $adminID);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);
    $username = $row['username'];
    $email = $row['email'];
    $password = $row['password'];
    $profile_pic = $row['profile_pic']; 
    // Add more fields as needed
} else {
    // Handle error if user data not found
    echo "Error: User data not found.";
    exit();
}

// Handle form submission for updating user profile
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input data
    $username = mysqli_real_escape_string($link, $_POST['username']);
    $email = mysqli_real_escape_string($link, $_POST['email']);
    
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
        } else {
            echo "Error: There was a problem uploading the file.";
            exit();
        }
    }

    // Update user data in the database
    $query = "UPDATE admins SET username = ?, email = ?, profile_pic = ? WHERE adminID = ?";
    $stmt = mysqli_prepare($link, $query);
    mysqli_stmt_bind_param($stmt, "sssi", $username, $email, $profile_pic, $adminID);
    if (mysqli_stmt_execute($stmt)) {
        // Update session variables if necessary
        $_SESSION['username'] = $username; // Update session with new username if changed

        // Redirect to profile page with updated information
        header("Location: admin_volunteerProfile.php");
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
    <style>
        body {
            background-color: #f8f9fa;
            padding: 20px;
        }
        .profile-container {
            max-width: 500px;
            margin: 100px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 28px; 
            box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
        }
        .profile-heading {
            text-align: center;
            margin-bottom: 20px;
        }
        .profile-details {
            margin-bottom: 20px;
        }
        .btn-save-profile {
            display: inline-block;
            padding: 8px 20px;
            background-color: #FFD036;
            color: black;
            border: none;
            border-radius: 28px;
            text-decoration: none;
            transition: background-color 0.3s, color 0.3s;
        }
        .btn-save-profile:hover {
            background-color: #ffcd00;
            color: white;
        }
        .password-container {
            position: relative;
            display: flex;
            align-items: center;
        }
        .password-container input {
            width: 100%;
            padding-right: 40px;
        }
        .password-container .toggle-password {
            position: absolute;
            right: 10px;
            cursor: pointer;
        }
        .profile-picture {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            display: block;
            margin: 0 auto 20px auto;
            border: 1px solid #818080;
        }
        .logo {
            display: block;
            margin: 0 auto 20px auto;
        }
    </style>
</head>
<body>
<?php include "admin_volunteerNavBar.php"; ?>
<?php include "ft.php"; ?>
    <div class="profile-container">
        <img src="images/admin_logo.jpg" alt="Admin Logo" class="logo">
        <h1 class="profile-heading">Edit Profile</h1>
        
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="profile-details">
                <img src="images/<?php echo htmlspecialchars($profile_pic); ?>" alt="Profile Picture" class="profile-picture">
                <div class="mb-3">
                    <label for="profile_pic" class="form-label">Profile Picture</label>
                    <input type="file" class="form-control" id="profile_pic" name="profile_pic">
                 </div> 
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
                </div>
                <!-- Add more fields as needed for other user information -->
                
                <!-- Save button -->
                <div class="text-center">
                    <button type="submit" class="btn btn-primary btn-save-profile">Save Profile</button>
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
