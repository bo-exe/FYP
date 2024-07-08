<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="icon" type="image/x-icon" href="images/admin_logo.jpg">
</head>
<br>
<?php include "admin_retailNavbar.php"; ?>
<?php include "ft.php"; ?>
<br></br>

    <div class="retailbuttons-container">
        <button class="retailbutton" id="button1">
            <a href="admin_retailManage.php">
                <img src="images/coin.jpg" alt="Icon 1">
                <br>MANAGE CURRENT OFFERS
            </a>
        </button>
        <button class="retailbutton" id="button2">
            <a href="admin_retailCreate.php">
                <img src="images/wand.jpg" alt="Icon 2">
                <br>CREATE CURRENT OFFERS
            </a>
        </button>
        <button class="retailbutton" id="button3">
            <a href="admin_retailMilestones.php">
                <img src="images/milestones.jpg" alt="Icon 3">
                <br>DASHBOARD
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
    <?php include "admin_footer.php"; ?>
<script src="script.js"></script>
</body>

</html>