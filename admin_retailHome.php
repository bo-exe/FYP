<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<br>
<?php include "admin_retailNavbar.php"; ?>
<?php include "ft.php"; ?>
<br></br>

    <div class="retailbuttons-container">
        <button class="retailbutton" id="button1">
            <a href="retail_manage.php">
                <img src="images/coin.jpg" alt="Icon 1">
                <br>MANAGE CURRENT OFFERS
            </a>
        </button>
        <button class="retailbutton" id="button2">
            <a href="retail_manage.php">
                <img src="images/wand.jpg" alt="Icon 2">
                <br>CREATE CURRENT OFFERS
            </a>
        </button>
        <button class="retailbutton" id="button3">
            <a href="retail_milestones.php">
                <img src="images/milestones.jpg" alt="Icon 3">
                <br>MILESTONES
            </a>
        </button>
</div>


<!-- Footer Section -->
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