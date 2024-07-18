<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['adminID'])) {
    // Redirect to the login page if user is not logged in
    header("Location: login.php");
    exit();
}
include "dbFunctions.php";

// Fetch user data from database based on session adminID
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
    $profile_pic = $row['profile_pic']; 
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
</head>
<style>
    /* Existing styles for .btn-edit-profile */
.btn-edit-profile {
    display: inline-block;
    padding: 10px 20px;
    font-size: 16px;
    color: #fff;
    background-color: #ffc107;
    border: none;
    border-radius: 5px;
    text-decoration: none;
    transition: background-color 0.3s ease;
}

.btn-edit-profile:hover {
    background-color: #e0a800; /* Darker yellow on hover */
}

/* New styles for .btn-logout */
.btn-logout {
    display: inline-block;
    padding: 10px 20px;
    font-size: 16px;
    color: #fff;
    background-color: #dc3545; /* Red */
    border: none;
    border-radius: 30px;
    text-decoration: none;
    transition: background-color 0.3s ease;
}

.btn-logout:hover {
    background-color: #c82333; /* Darker red on hover */
}

</style>

<body>
<?php include "admin_retailNavBar.php"; ?>
<?php include "ft.php"; ?>
    <div class="profile-container">
        <img src="images/admin_logo.jpg" alt="Admin Logo" class="profile-logo">
        <h1 class="profile-heading">User Profile</h1>
        
        <div class="profile-details">
            <img src="images/<?php echo htmlspecialchars($profile_pic); ?>" alt="Profile Picture" class="profile-picture">
            <p><strong>Username:</strong> <?php echo htmlspecialchars($username); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
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
        </div>

        <div class="text-center mt-3">
            <form action="admin_logout.php" method="post">
                <button type="submit" class="btn-logout">Logout</button>
            </form>
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
