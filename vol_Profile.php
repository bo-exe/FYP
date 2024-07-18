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
            width: 100%;
            max-width: 1200px;
            margin: auto;
        }

        .profile-details {
            flex: 1;
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

        .list-group {
            display: flex;
            flex-wrap: wrap;
            gap: 10px; /* Adjust as needed */
            margin-top: 20px;
        }

        .list-group a {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            width: 150px; /* Adjust width as needed */
            padding: 10px;
            background: #f0f0f0;
            color: #333;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .list-group a .icon-container {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 50px; /* Adjust as needed */
            height: 50px; /* Adjust as needed */
            background-color: #ddd; /* Adjust as needed */
            border-radius: 50%;
            margin-bottom: 5px;
        }

        .list-group a .icon-container i {
            font-size: 24px; /* Adjust icon size as needed */
            color: #333; /* Adjust icon color */
        }

        .list-group a span {
            font-size: 14px; /* Adjust text size */
        }

        .list-group a:hover {
            background: #e0e0e0;
        }

        .container {
            display: flex;
            flex-wrap: wrap;
            margin-top: 50px;
        }

        .profile-section {
            flex: 1;
            min-width: 300px;
            margin-bottom: 20px;
        }

        .slider-container {
            flex: 2;
        }

        .slider-wrapper {
            position: relative;
            max-width: 48rem;
            margin: 20px auto;
        }

        .slider {
            display: flex;
            overflow: hidden;
            position: relative;
            z-index: 1;
        }

        .slider img {
            width: 100%;
            flex: 0 0 100%;
            transition: transform 0.5s ease;
        }

        .slider-nav {
            display: flex;
            justify-content: center;
            position: absolute;
            bottom: 1.25rem;
            left: 50%;
            transform: translateX(-50%);
            z-index: 2;
        }

        .slider-nav .dot {
            height: 10px;
            width: 10px;
            background-color: #fff;
            opacity: 0.75;
            border: 2px solid #fff;
            border-radius: 50%;
            margin: 0 5px;
            cursor: pointer;
            transition: opacity 0.3s;
        }

        .slider-nav .dot.active {
            opacity: 1;
            background-color: #FFD036;
        }

        .slider::-webkit-scrollbar {
            display: none;
        }

        .slider {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .about-btn {
            display: inline-block;
            padding: 0.3rem 0.7rem;
            background: #FFD036;
            border-radius: .6rem;
            box-shadow: 0 .1rem .25rem #333;
            font-size: 0.8rem;
            color: #333;
            letter-spacing: .1rem;
            font-weight: 600;
            border: .2rem solid transparent;
            transition: .5s ease;
            margin-top: 30px;
            text-decoration: none;
        }

        .about-btn:hover {
            background: #deb530;
            color: #333;
            text-decoration: none;
        }

        .header {
            display: flex;
            align-items: center;
        }

        .greeting {
            flex-grow: 1;
        }

        .points-container {
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            color: #333;
            background-color: #ECECE7;
            border-radius: .6rem;
            box-shadow: 0 .2rem .5rem #333;
            letter-spacing: .2rem;
            font-weight: 800;
            padding: 10px;
        }

        .points-container i {
            margin-right: 5px;
        }

        .points-container .vomo-points {
            display: flex;
            align-items: center;
        }

        .points-container .vomo-points span:first-child {
            margin-right: 100px;
        }

        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                align-items: center;
            }

            .points-container {
                margin-top: 20px;
            }

            .profile-container {
                flex-direction: column;
                align-items: center;
            }

            .profile-details img.profile-logo,
            .profile-details img.profile-picture {
                width: 100px;
                height: 100px;
            }

            .profile-details p {
                text-align: center;
            }

            .password-container {
                justify-content: center;
            }

            .list-group {
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
            }

            .list-group a {
                flex: 0 0 50%;
                max-width: 50%;
                text-align: center;
                margin-bottom: 10px;
            }

            .slider-container {
                width: 100%;
            }

            .slider-wrapper {
                max-width: 100%;
            }
        }
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
                    <img src="images/Giant.jpg" alt="store 2">
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