<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Volunteer Admin Home</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<br>
<?php include "admin_volunteerNavbar.php"; ?>
<?php include "ft.php"; ?>
<br></br>

    <?php
    session_start();
    if (isset($_SESSION['username'])) 
        {
        $username = $_SESSION['username'];
        echo "@" . htmlspecialchars($username); 
        }
    ?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-6">
            <div class="volunteeradmin-card">
                <a href="admin_gigOverview.php">
                    <div class="volunteeradmin-cardbody">
                        <img src="images/exercise.png" alt="Icon 1">
                    </div>
                    <div class="volunteeradmin-cardfooter">
                        Manage <br>
                        Current Gigs
                    </div>
                </a>
            </div>
        </div>

        <div class="col-md-6">
            <div class="volunteeradmin-card">
                <a href="admin_addGig.php">
                    <div class="volunteeradmin-cardbody">
                        <img src="images/wand.jpg" alt="Icon 2">
                    </div>
                    <div class="volunteeradmin-cardfooter">
                        Create <br>
                        New Gigs
                    </div>
                </a>
            </div>
        </div>

        <div class="col-md-12">
            <div class="volunteeradmin-card">
                <a href="admin_gigMilestone.php">
                    <div class="volunteeradmin-cardbody">
                        <img src="images/milestones.jpg" alt="Icon 3">
                    </div>
                    <div class="volunteeradmin-cardfooter">
                        Milestones Reached
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

        </div>
<footer class="footer">
    <div class="footer-content">
        <div class="logo-container">
            <img src="images/admin_logo.jpg" alt="logo" style="width:100px;">
        </div>
    </div>
    <div class="footer-content">
        <h4>ABOUT</h4>
        <ul>
            <li><a href="index.html#about">About VOMO</a></li>
        </ul>
    </div>
    <div class="footer-content">
        <h4>CONTACT US</h4>
        <ul>
            <li><a href="index.html#contact">Feedback</a></li>
            <li><a href="index.html#contact">Support Us</a></li>
        </ul>
    </div>
    <div class="footer-content">
        <div class="social-section">
            <h4 class="social-text">Socials:</h4>
            <div class="social-icons">
                <a href="https://www.instagram.com/vomo/?hl=en"><i class='bx bxl-instagram'></i></a>
                <a href="https://web.telegram.org/a/#vomo"><i class='bx bxl-telegram'></i></a>
                <a href="https://api.whatsapp.com/send/?phone=%2B90716235&text&type=phone_number&app_absent=0"><i
                        class='bx bxl-whatsapp'></i></a>
                <a href="https://mail.google.com/mail/u/0/?hl=en#inbox?compose=new"><i class='bx bx-envelope'></i></a>
            </div>
        </div>
    </div>
    <div class="footer-iconTop">
        <a href="index.php"><i class='bx bx-up-arrow-alt'></i></a>
    </div>
    <div class="copyright">
        <p>Copyright © VOMO.</p>
    </div>
</footer>
<script src="script.js"></script>
</body>

</html>