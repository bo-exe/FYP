<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if user is logged in
if (!isset($_SESSION['volunteerId'])) {
    // Redirect to the login page if user is not logged in
    header("Location: vol_login.php");
    exit();
}

include "dbFunctions.php";

// Connect to the database
$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user data from database based on session volunteerId
$userId = $_SESSION['volunteerId'];
$query = "SELECT * FROM volunteers WHERE volunteerId = ?";
$stmt = mysqli_prepare($conn, $query);
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

// Fetch VOMOPoints
$vomoPoints = 0;
if (isset($username)) {
    $sql = "SELECT points FROM volunteers WHERE username = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $vomoPoints = $row['points'];
    }
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
        /* Your CSS styles */
    </style>
</head>
<body>
    <?php include "vol_NavBar.php"; ?>
    <?php include "ft.php"; ?>

    <div class="profile-section">
    <div class="profile-container">
        <div class="profile-details">
            <img src="images/logo.jpg" alt="Logo" class="profile-logo">
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
            <div class="text-center">
                <a href="vol_volunteerEditProfile.php" class="btn-edit-profile">Edit Profile</a>
            </div>

            <div class="list-group d-flex flex-wrap mt-4">
            <a href="vol_contactUs.php" class="list-group-item list-group-item-action">
                <div class="icon-container">
                    <i class="fas fa-envelope"></i>
                </div>
                <span>Contact</span>
            </a>
            <a href="vol_feedback.php" class="list-group-item list-group-item-action">
                <div class="icon-container">
                    <i class="fas fa-comment"></i>
                </div>
                <span>Feedback</span>
            </a>
            <a href="vol_history.php" class="list-group-item list-group-item-action">
                <div class="icon-container">
                    <i class="fas fa-history"></i>
                </div>
                <span>History</span>
            </a>
            <a href="#" class="list-group-item list-group-item-action">
                <div class="icon-container">
                    <i class="fas fa-save"></i>
                </div>
                <span>Saved Activities</span>
            </a>
            <a href="vol_Settings.php" class="list-group-item list-group-item-action">
                <div class="icon-container">
                    <i class="fas fa-cog"></i>
                </div>
                <span>Settings</span>
            </a>
        </div>
        </div>

        <div class="slider-container">
            <section class="slider-wrapper">
                <h2>Your Activities</h2>
                <div class="slider" id="activity-slider">
                    <img src="images/volunteer-booth.jpg" alt="activity 1">
                    <img src="images/education.jpg" alt="activity 2">
                    <img src="images/clean.jpg" alt="activity 3">
                </div>
                <div class="slider-nav" id="activity-slider-nav">
                    <span class="dot" onclick="currentSlide(1, 'activity-slider')"></span>
                    <span class="dot" onclick="currentSlide(2, 'activity-slider')"></span>
                    <span class="dot" onclick="currentSlide(3, 'activity-slider')"></span>
                </div>
                <a href="all_activities.php" class="about-btn">See More</a>
            </section>

            <section class="slider-wrapper">
                <h2>Your Vouchers</h2>
                <div class="slider" id="store-slider">
                    <img src="images/ikea.jpg" alt="store 1">
                    <img src="images/giant.jpg" alt="store 2">
                    <img src="images/thebodyshop.jpg" alt="store 3">
                </div>
                <div class="slider-nav" id="store-slider-nav">
                    <span class="dot" onclick="currentSlide(1, 'store-slider')"></span>
                    <span class="dot" onclick="currentSlide(2, 'store-slider')"></span>
                    <span class="dot" onclick="currentSlide(3, 'store-slider')"></span>
                </div>
                <a href="all_stores.php" class="about-btn">See More</a>
            </section>
        </div>
    </div>
</div>

    <?php include "footer.php"; ?>

    <script>
        let slideIndex = 1;
        showSlides(slideIndex, 'activity-slider');
        showSlides(slideIndex, 'store-slider');

        function currentSlide(n, sliderId) {
            showSlides(slideIndex = n, sliderId);
        }

        function showSlides(n, sliderId) {
            let i;
            let slides = document.querySelectorAll(`#${sliderId} img`);
            let dots = document.querySelectorAll(`#${sliderId}-nav .dot`);
            if (n > slides.length) {slideIndex = 1}
            if (n < 1) {slideIndex = slides.length}
            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";  
            }
            for (i = 0; i < dots.length; i++) {
                dots[i].className = dots[i].className.replace(" active", "");
            }
            slides[slideIndex-1].style.display = "block";  
            dots[slideIndex-1].className += " active";
        }

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
