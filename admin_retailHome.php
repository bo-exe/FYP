<?php
include "dbFunctions.php";
session_start();

if (!isset($_SESSION['username'])) {
    // Redirect to login page if not logged in
    header('Location: login.php');
    exit;
}

$username = $_SESSION['username'];
$adminID = $_SESSION['adminID']; // Assuming you store adminID in session

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
<br>
<?php include "admin_retailNavbar.php"; ?>
<?php include "ft.php"; ?>
<br></br>
<h1>Welcome, <?php echo htmlspecialchars($username); ?>!</h1>
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
    <button class="retailbutton" id="button2">
        <a href="admin_retailPinVerification.php">
            <img src="images/pin.png" alt="Icon 2">
            <br>PIN
        </a>
    </button>
</div>


<!-- Footer Section -->
<?php include "admin_footer.php"; ?>
<script src="script.js"></script>
</body>

</html>