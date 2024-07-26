<?php
include "dbFunctions.php";
session_start();

if (!isset($_SESSION['username'])) {
    // Redirect to login page if not logged in
    header('Location: login.php');
    exit;
}

$username = $_SESSION['username'];

$query = "SELECT * FROM offers";
$result = mysqli_query($link, $query) or die(mysqli_error($link));

$arrContent = array();
while ($row = mysqli_fetch_array($result)) {
    $arrContent[] = $row;
}
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

<body>
    <?php include "admin_cashierNavbar.php"; ?>
    <?php include "ft.php"; ?>

    <br>
    <h1>Welcome, <?php echo htmlspecialchars($username); ?>!</h1>
    <br><br>

    <div class="retailbuttons-container">
        <button class="retailbutton" id="button1">
            <a href="admin_cashierManage.php">
                <img src="images/coin.jpg" alt="Icon 1">
                <br>VIEW CURRENT OFFERS
            </a>
        </button>
        <button class="retailbutton" id="button2">
            <a href="admin_cashierPinVerification.php">
                <img src="images/pin.png" alt="Icon 2">
                <br>PIN
            </a>
        </button>
    </div>  
        <?php include "admin_footer.php"; ?>

    <script src="script.js"></script>
</body>

</html>
