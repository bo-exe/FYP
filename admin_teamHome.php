<?php
include "dbFunctions.php";
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

$username = $_SESSION['username'];
$adminID = $_SESSION['adminID'];

$query = "SELECT * FROM offers WHERE adminID = ?";
$stmt = $link->prepare($query);
$stmt->bind_param("i", $adminID);
$stmt->execute();
$result = $stmt->get_result();

$arrContent = array();
while ($row = $result->fetch_assoc()) {
    $arrContent[] = $row;
}

$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="icon" type="image/x-icon" href="images/admin_logo.jpg">
</head>
<body class="admin-team-home">
    <?php include "admin_teamNavbar.php"; ?>
    <?php include "ft.php"; ?>
    <h1>Welcome, <?php echo htmlspecialchars($username); ?>!</h1>
    <div class="retailbuttons-container">
        <button class="retailbutton" id="button1">
            <a href="admin_teamManageOffers.php">
                <img src="images/coin.jpg" alt="Icon 1">
                <br>MANAGE CURRENT OFFERS
            </a>
        </button>
        <button class="retailbutton" id="button1">
            <a href="admin_allGigs.php">
                <img src="images/exercise.png" alt="Icon 1">
                <br>MANAGE CURRENT GIGS
            </a>
        </button>
        <button class="retailbutton" id="button2">
            <a href="admin_volunteerReq.php">
                <img src="images/signup.png" alt="Icon 2">
                <br>VOLUNTEER ORGANISATION SIGN UPS
            </a>
        </button>
        <button class="retailbutton" id="button2">
            <a href="admin_teamRetailReq.php">
                <img src="images/signup.png" alt="Icon 2">
                <br>RETAIL ORGANISATION SIGN UPS
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
    </footer>
    <script src="script.js"></script>
</body>

</html>
