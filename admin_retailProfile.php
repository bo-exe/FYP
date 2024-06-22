<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['userId'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

// Include the file that contains the common database connection code
include "dbFunctions.php";

// Fetch user data from database based on session userId
$userId = $_SESSION['userId'];
$query = "SELECT * FROM users WHERE userId = ?";
$stmt = mysqli_prepare($link, $query);
mysqli_stmt_bind_param($stmt, "i", $userId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);
    $username = $row['username'];
    $role = $row['role']; // Assuming 'role' is a column in your users table
    $dob = $row['dob']; // Assuming 'dob' is a column in your users table
    $gender = $row['gender']; // Assuming 'gender' is a column in your users table
    $mobile_number = $row['mobile_number']; // Assuming 'mobile_number' is a column in your users table
    $email = $row['email']; // Assuming 'email' is a column in your users table
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
    <style>
       body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            padding: 20px;
        }
        .profile-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px; 
            box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
        }
        .profile-heading {
            text-align: center;
            margin-bottom: 20px;
        }
        .profile-details {
            margin-bottom: 20px;
        }
        .btn-edit-profile {
            display: inline-block;
            padding: 8px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="profile-container">
        <h1 class="profile-heading">User Profile</h1>
        
        <div class="profile-details">
            <p><strong>Username:</strong> <?php echo $username; ?></p>
            <p><strong>Role:</strong> <?php echo $role; ?></p>
            <p><strong>Date of Birth:</strong> <?php echo $dob; ?></p>
            <p><strong>Gender:</strong> <?php echo $gender; ?></p>
            <p><strong>Mobile Number:</strong> <?php echo $mobile_number; ?></p>
            <p><strong>Email:</strong> <?php echo $email; ?></p>
            <!-- Add more profile details here as needed -->
        </div>
        
        <div class="text-center">
            <a href="admin_retailEditProfile.php" class="btn-edit-profile">Edit Profile</a>
            <!-- Link to edit profile page -->
        </div>
    </div>
</body>
</html>
