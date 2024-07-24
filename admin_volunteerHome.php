<?php
include "dbFunctions.php";
session_start();

if (!isset($_SESSION['username'])) {
    // Redirect to login page if not logged in
    header('Location: admin_login.php');
    exit;
}

$username = $_SESSION['username'];
$adminID = $_SESSION['adminID']; // Assuming you store adminID in session

$query = "SELECT * FROM events WHERE adminID = ?";
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
<br>
<?php include "admin_volunteerNavbar.php"; ?>
<?php include "ft.php"; ?>
<br></br>
<h1>Welcome, <?php echo htmlspecialchars($username); ?>!</h1>
    <div class="retailbuttons-container">
        <button class="retailbutton" id="button1">
            <a href="admin_volManage.php">
                <img src="images/exercise.png" alt="Icon 1">
                <br>MANAGE CURRENT GIGS
            </a>
        </button>
        <button class="retailbutton" id="button2">
            <a href="admin_volCreate.php">
                <img src="images/wand.jpg" alt="Icon 2">
                <br>CREATE CURRENT OFFERS
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