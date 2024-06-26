<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Navigation Bar</title>
    <link rel="stylesheet" href="style.css">
</head>
<style>
/* Navbar styling */
.navbar-volunteeradmin {
    width: 100%;
    background-color: #FFD036; 
    position: fixed;
    top: 0;
    left: 0;
    display: flex;
    justify-content: space-between; 
    align-items: center;
    padding: 0 20px; 
}

.logo {
    width: 100%;
}

.navbar-volunteeradmin ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
    display: flex;
}

.navbar-volunteeradmin ul li {
    margin: 0;
}

.navbar-volunteeradmin ul li a {
    display: block;
    padding: 14px 20px;
    text-decoration: none;
    color: #333; 
    text-align: center;
}

.navbar-volunteeradmin ul li img {
    width: 15%;
}

.navbar-volunteeradmin ul li a:hover {
    background-color: #FFC107; 
    color: #555;
}

.content {
    margin-top: 50px;
    padding: 20px;
}

@media (max-width: 768px) {
    .navbar-volunteeradmin {
        top: auto;
        bottom: 0;
        flex-direction: column;
        align-items: flex-start; 
        padding: 20px; 
    }
    
    .logo,
    .search-bar,
    #profile {
        display: none;
    }
}
</style>
<body>
<?php include "ft.php"; ?>
    <nav class="navbar-volunteeradmin">
        <div class="logo">
            <img src="images/admin_logo.jpg" alt="Logo" style="width: 100px;">
        </div>
        <ul>
            <li>
                <a href="admin_volunteerHome.php">
                    <img src="images/navhome.png" alt="Home Icon" class="volunteernav-icon">
                    HOME
                </a>
            </li>

            <li>
                <a href="admin_allGigs.php">
                    <img src="images/navmanage.png" alt="Manage Icon" class="volunteernav-icon">
                    MANAGE
                </a>
            </li>

            <li>
                <a href="admin_gigMilestone.php">
                    <img src="images/navmilestones.png" alt="Milestones Icon" class="volunteernav-icon">
                    MILESTONES
                </a>
            </li>

            <li>
                <a href="admin_volunteerProfile.php">
                <img src="images/navprofile.png" alt="Profile Icon" class="volunteernav-icon">
                    PROFILE
                </a>
            </li>
        </ul>
    </nav>

    <!-- Footer Section -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-row">
            <a href="index.php">
                <div class="logo-container">
                    <img src="images/admin_logo.jpg" alt="logo" class="logo">
                </div>
            </a>
                <div class="footer-columns">
                    <div class="footer-column">
                        <h4>CONTACT US</h4>
                        <ul>
                            <li><a href="feedback.php">Feedback</a></li>
                            <li><a href="contactUs.php">Support Us</a></li>
                        </ul>
                    </div>
                    <div class="footer-column">
                        <h4 class="social-text">SOCIALS:</h4>
                        <div class="social-icons">
                            <a href="https://www.instagram.com/vomo/?hl=en"><i class='bx bxl-instagram'></i></a>
                            <a href=""><i class='bx bxl-telegram'></i></a>
                            <a href=""><i class='bx bxl-tiktok'></i></a>
                            <a href="https://mail.google.com/mail/u/0/?hl=en#inbox?compose=new"><i class='bx bx-envelope'></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-iconTop">
                <a href="#"><i class='bx bx-up-arrow-alt'></i></a>
            </div>
            <div class="copyright">
                <p>&copy; VOMO. All Rights Reserved.</p>
            </div>
        </div>
    </footer>
    <script src="script.js"></script>
</body>
</html>
