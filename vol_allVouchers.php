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

// Initialize $arrContent
$arrContent = [];

$sqlOffers = "SELECT offerId, title, dateTimeEnd, images FROM offers"; // Replace with your actual query
$resultOffers = $conn->query($sqlOffers);

if ($resultOffers) {
    while ($offerData = $resultOffers->fetch_assoc()) {
        $arrContent[] = $offerData;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Vouchers</title>
    <link rel="icon" type="image/x-icon" href="images/logo.jpg">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css">
    <style>
        /* Navbar styling */
        nav {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
        }

        /* Homepage */
        .home {
            margin-top: 100px;
        }

        .home p,
        h3 {
            margin-right: 800px;
            text-align: left;
        }

        .home h1 {
            margin-right: 800px;
            text-align: left;
            text-shadow: 0 .1rem .1rem #333;
        }

        .offer-card-container {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 20px;
        }

        .offer-card {
            width: 325px;
            background-color: #ECECE7;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.2);
            margin: 20px;
            height: 300px;
            text-decoration: none;
            color: inherit;
            position: relative;
        }

        .offer-card img {
            width: 100%;
            height: 165px;
            object-fit: cover;
        }

        .offer-card-content {
            padding: 1px;
        }

        .offer-card-content h2 {
            font-size: 28px;
            margin-bottom: 10px;
            margin-top: 10px;
        }

        .offer-card-content p {
            color: #333333;
            font-size: 15px;
            line-height: 1.3;
            margin-left: 10px;
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
            justify-content: left;
            font-size: 14px;
            color: #333;
            background-color: #ECECE7;
            border-radius: .6rem;
            box-shadow: 0 .2rem .5rem #333;
            letter-spacing: .2rem;
            font-weight: 800;
            padding: 10px;
            margin-top: 20px;
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

        @media (max-width: 1200px) {
            .voucher-card {
                width: 30%;
            }
        }

        @media (max-width: 992px) {
            .voucher-card {
                width: 45%;
            }
        }

        @media (max-width: 768px) {
            .voucher-card {
                width: 70%;
            }
        }

        @media (max-width: 576px) {
            .voucher-card {
                width: 90%;
                margin: 10px;
            }
        }

        /* More button styling */
        .more-button {
            display: inline-block;
            padding: 8px 20px;
            background-color: #FFD036;
            text-decoration: none;
            border-radius: 30px;
            margin-top: 16px;
            margin-left: 120px;
            margin-bottom: 10px;
            color: #FFF5F5;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <?php include "vol_navbar.php"; ?>
    <?php include "ft.php"; ?>

    <section class="home" id="home">
        <div class="header">
            <div class="greeting">
                <h1>Good Morning,</h1>
            </div>
        </div>
        <p>@<?php echo isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest'; ?></p>
    </section>

    <h1>Organisation Vouchers</h1>
    <div class="points-container">
        <i class='bx bx-gift'></i>
        <div class="vomo-points">
            <span>VOMOPoints</span>
            <span><?php echo $vomoPoints; ?></span>
        </div>
    </div>

    <div class="offer-card-container">
        <?php if (!empty($arrContent)) : ?>
            <?php foreach ($arrContent as $offerData) : ?>
                <?php
                $offerId = $offerData['offerId'];
                $title = $offerData['title'];
                $dateTimeEnd = $offerData['dateTimeEnd'];
                $picture = $offerData['images'];

                // Convert BLOB data to base64 encoded image
                $imageSrc = 'data:image/jpeg;base64,' . base64_encode($picture);

                // If no picture is available, use a default image
                if (empty($picture)) {
                    $imageSrc = 'images/none.png'; // Provide path to your default image
                }
                ?>
                <div class="offer-card">
                    <img src="<?php echo $imageSrc; ?>" alt="<?php echo $title; ?>" class="card-img-top">
                    <div class="offer-card-content">
                        <h2 class="card-title"><?php echo $title; ?></h2>
                        <p class="card-text">Use By: <?php echo $dateTimeEnd; ?></p>
                    </div>
                    <div class="offer-card-content">
                        <a href="vol_voucherOverview.php?offerId=<?php echo $offerId; ?>" class="more-button">More</a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <p>No vouchers available at this time.</p>
        <?php endif; ?>
    </div>

    <?php include "footer.php"; ?>

    <script src="script.js"></script>
</body>

</html>
