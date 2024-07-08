<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['adminID'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

include "dbFunctions.php";
include "ft.php";

// Fetch user data from database based on session userId
$userId = $_SESSION['adminID'];
$query = "SELECT * FROM admins WHERE adminID = ?";
$stmt = mysqli_prepare($link, $query);
mysqli_stmt_bind_param($stmt, "i", $userId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);
    $username = $row['username'];
    $email = $row['email'];
    $password = $row['password'];
    $number = $row['number'];
    $profile_pic = $row['profile_pic'];
    // Add more fields as needed
} else {
    // Handle error if user data not found
    echo "Error: User data not found.";
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
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
            box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.1);
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
            margin-right: 10px;
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

        .btn-edit-profile {
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

        .btn-edit-profile:hover {
            background-color: #ffcd00;
            color: #d9d9d9;
        }

        .btn-logout {
            display: inline-block;
            padding: 8px 16px;
            background-color: #EF1E1E;
            text-decoration: none;
            border-radius: 30px;
            margin-top: 16px;
            color: #FFF5F5;
            font-weight: bold;
            margin-left: 10px;
            margin-bottom: 10px;
        }

        .btn-logout:hover {
            background-color: #EF1E1E;
            color: #d9d9d9;
        }

    </style>
</head>
<body>
    <?php include "admin_retailNavBar.php"; ?>
    <div class="profile-container">
        <img src="images/admin_logo.jpg" alt="Admin Logo" class="profile-logo">
        <h1 class="profile-heading">User Profile</h1>

        <div class="profile-details">
            <img src="images/<?php echo htmlspecialchars($profile_pic); ?>" alt="Profile Picture" class="profile-picture">
            <p><strong>Username:</strong> <?php echo htmlspecialchars($username); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
            <p><strong>Company Number:</strong> <?php echo htmlspecialchars($number); ?></p>
            <p><strong>Password: </strong></p>
            <div class="password-container">
                <input type="password" id="password" value="<?php echo htmlspecialchars($password); ?>" readonly>
                <span class="toggle-password" onclick="togglePassword()">
                    <i class="fas fa-eye"></i>
                </span>
            </div>
        </div>

        <div class="text-center">
            <a href="admin_retailEditProfile.php" class="btn-edit-profile">Edit Profile</a>
            <!-- Link to edit profile page -->
            <a href="admin_logout.php" class="btn-logout">Logout</a>
            <!-- Logout button -->
        </div>
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
