<?php
session_start();
include "dbFunctions.php";

$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $sql = "SELECT points FROM volunteers WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result) {
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $vomoPoints = $row['points'];
        } else {
            $vomoPoints = 0;
        }
    } else {
        $vomoPoints = 0; 
    }
} else {
    $vomoPoints = 0;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="icon" type="image/x-icon" href="images/logo.jpg">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .profile-container {
            background-color: #FFF;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);    
        }

        .profile-details img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            margin-bottom: 20px;
        }

        .profile-details p {
            margin: 10px 0;
        }

        .password-container {
            display: flex;
            align-items: center;
        }

        .password-container input {
            border: none;
            background: none;
            font-size: 1rem;
            margin-right: 10px;
        }

        .toggle-password {
            cursor: pointer;
        }

        .btn-edit-profile {
            display: inline-block;
            padding: 0.5rem 1rem;
            background: #FFD036;
            border-radius: .3rem;
            text-decoration: none;
            color: #333;
            font-weight: 600;
        }

        .btn-edit-profile:hover {
            background: #deb530;
        }

        .list-group a {
            text-decoration: none;
            color: #333;
        }

        .list-group a:hover {
            background: #f0f0f0;
        }

        .container {
            display: flex;
            flex-wrap: wrap;
            margin-top: 50px;
        }

        .list-group {
            width: 20%;
            margin-right: 20px;
        }

        .profile-section {
            flex: 1;
            min-width: 300px;
        }
    </style>
</head>
<body>
<?php include "vol_NavBar.php"; ?>
<?php include "ft.php"; ?>

<section class="home" id="home">
    <div class="header">
        <div class="greeting">
            <h1>User Profile</h1>
        </div>
        <div class="points-container">
            <i class='bx bx-gift'></i>
            <div class="vomo-points">
                <span>VOMOPoints</span>
                <span><?php echo htmlspecialchars($vomoPoints); ?></span>
            </div>
        </div>
    </div>
</section>

<div class="container mt-5">
    <div class="list-group">
        <a href="vol_Profile.php" class="list-group-item list-group-item-action active">
            <i class="fas fa-user"></i> Profile
        </a>
        <a href="vol_contactUs.php" class="list-group-item list-group-item-action">
            <i class="fas fa-envelope"></i> Contact
        </a>
        <a href="vol_feedback.php" class="list-group-item list-group-item-action">
            <i class="fas fa-comment"></i> Feedback
        </a>
        <a href="vol_history.php" class="list-group-item list-group-item-action">
            <i class="fas fa-history"></i> History
        </a>
        <a href="#" class="list-group-item list-group-item-action">
            <i class="fas fa-save"></i> Saved Activities
        </a>
        <a href="settings.php" class="list-group-item list-group-item-action">
            <i class="fas fa-cog"></i> Settings
        </a>
    </div>

    <div class="profile-section">
        <div class="profile-container">
            <img src="images/logo.jpg" alt="Logo" class="profile-logo">
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
                <a href="vol_volunteerEditProfile.php" class="btn-edit-profile">Edit Profile</a>
            </div>
        </div>
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
