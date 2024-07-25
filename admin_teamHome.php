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
    <style>
        .admin-team-home {
            font-family: Arial, sans-serif;
        }

        .admin-team-home h1 {
            text-align: center;
        }

        .admin-team-home .retailbuttons-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            margin: 20px;
        }

        .admin-team-home .retailbutton {
            background-color: #f1f1f1;
            border: none;
            padding: 10px;
            text-align: center;
            transition: 0.3s;
            cursor: pointer;
            width: 200px;
        }

        .admin-team-home .retailbutton a {
            text-decoration: none;
            color: black;
        }

        .admin-team-home .retailbutton img {
            width: 100px;
            height: 100px;
            object-fit: contain;
        }

        .admin-team-home .footer {
            background-color: #333;
            color: white;
            padding: 10px;
            text-align: center;
        }

        .admin-team-home .footer-content {
            margin: 10px 0;
        }

        @media screen and (max-width: 768px) {
            .admin-team-home .retailbuttons-container {
                flex-direction: column;
                align-items: center;
            }

            .admin-team-home .retailbutton {
                width: 100%;
            }

            .admin-team-home .footer-content {
                text-align: center;
            }
        }
    </style>
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
