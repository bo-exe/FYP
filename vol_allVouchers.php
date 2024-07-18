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
        /* Common styles */
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


        /* Styles specific to vol_allVouchers.php */
        .voucher-card-container {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 20px;
        }

        .voucher-card {
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

        .voucher-card img {
            width: 100%;
            height: 165px;
            object-fit: cover;
        }

        .card-content {
            padding: 1px;
        }

        .card-content h3 {
            font-size: 28px;
            margin-bottom: 10px;
            margin-top: 10px;
        }

        .card-content p {
            color: #333333;
            font-size: 15px;
            line-height: 1.3;
            margin-left: 10px;
        }

        .card-content .btn {
            display: inline-block;
            padding: 8px 16px;
            background-color: #FFD036;
            text-decoration: none;
            border-radius: 30px;
            margin-top: 16px;
            color: #FFF5F5;
            font-weight: bold;
            margin-left: auto; /* Adjusted to align the button to the right */
            margin-right: 10px; /* Added margin-right for spacing */
            width: fit-content; /* Ensures button width fits its content */
        }

        @media screen and (max-width: 768px) {
            .offer-card {
                width: 100%;
            }

            .offer-card img {
                height: 200px;
            }
        }
    </style>
</head>

<body>
    <?php include "vol_navbar.php"; ?>
    <?php include "ft.php"; ?>

    <div class="yellow-container">
        <h1>All Vouchers</h1>
        <br>
        <div class="points-container">
            <i class='bx bx-gift'></i>
            <div class="vomo-points">
                <span>VOMOPoints</span>
                <span><?php echo $vomoPoints; ?></span>
            </div>
        </div>
    </div>

    <div class="voucher-card-container">
        <?php
        $sql = "SELECT * FROM offers";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $title = $row['title'];
                $points = $row['points'];
                $image = base64_encode($row['images']);
                ?>
                <div class="voucher-card">
                    <a href="vol_voucherOverview.php?offerId=<?php echo $row['offerId']; ?>" style="text-decoration: none; color: inherit;">
                        <img src="data:image/jpeg;base64,<?php echo $image; ?>" alt="<?php echo $title; ?>" class="card-img-top">
                        <div class="card-content">
                            <h3 class="card-title"><?php echo $title; ?></h3>
                            <p class="card-text">Points: <?php echo $points; ?></p>
                        </div>
                    </a>
                    <div class="card-content">
                        <a href="vol_voucherOverview.php?offerId=<?php echo $row['offerId']; ?>" class="btn">More</a>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "No vouchers found.";
        }
        ?>
    </div>

    <?php include "footer.php"; ?>

    <script src="script.js"></script>
</body>

</html>
