<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['adminID'])) {
    // Redirect to the login page if user is not logged in
    header("Location: admin_login.php");
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
    <link rel="stylesheet" type="text/css" href="volunteeradminstyle.css">
    <style>
        .btn-logout {
            background-color: #8B0000;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            text-decoration: none;
        }

        .btn-logout:hover {
            background-color: #A52A2A;
        }
    </style>
</head>

<body>
    <?php include "admin_teamNavBar.php"; ?>
    <?php include "ft.php"; ?>
    <div class="container mt-5">
        <div class="profile-container mx-auto p-4">
            <img src="images/admin_logo.jpg" alt="Admin Logo" class="profile-logo mb-4">
            <h1 class="profile-heading text-center mb-4">User Profile</h1>

            <div class="profile-details text-center mb-4">
                <img src="images/<?php echo htmlspecialchars($profile_pic); ?>" alt="Profile Picture" class="profile-picture mb-3">
                <p><strong>Username:</strong> <?php echo htmlspecialchars($username); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
            </div>

            <div class="text-center mb-4">
                <a href="admin_teamEditProfile.php" class="btn-edit-profile me-2">Edit Profile</a>
                <a href="vol_forgotPassword.php" class="btn-edit-profile">Change Password</a>
            </div>
            <div class="text-center">
                <form action="admin_logout.php" method="post">
                    <button type="submit" class="btn-logout">Logout</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
