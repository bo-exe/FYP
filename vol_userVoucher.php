<?php
session_start();
include "dbFunctions.php";

$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

mysqli_autocommit($conn, TRUE);

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    // Fetch volunteer's VOMOPoints
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
        error_log("SQL error: " . $conn->error); 
        $vomoPoints = 0;
    }

    // Fetch redeemed vouchers with end date
    $sql = "
        SELECT 
            rv.redeemed_date,
            o.title,
            o.points,
            o.images,
            o.dateTimeEnd,
            rv.offerId
        FROM 
            redeemed_vouchers rv
        JOIN 
            offers o ON rv.offerId = o.offerId
        JOIN 
            volunteers v ON rv.volunteerId = v.volunteerId
        WHERE 
            v.username = '$username'
    ";

    $redeemedVouchers = $conn->query($sql);
    if (!$redeemedVouchers) {
        error_log("SQL error: " . $conn->error);
    }
} else {
    $vomoPoints = 0;
    $redeemedVouchers = null;
}

$conn->close(); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Vouchers</title>
    <link rel="icon" type="image/x-icon" href="images/logo.jpg">
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
        .home h1 {
            margin-right: 800px;
            text-align: left;
            text-shadow: 0 .1rem 0.05rem #333;
        }
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
            height: 325px;
            text-decoration: none;
            color: inherit;
            position: relative;
        }
        .voucher-card img {
            width: 100%;
            height: 125px;
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

        /* Yellow Container */
        .yellow-container {
            background-color: #FFD036;
            color: #333;
            text-align: left;
            padding: 15px;
            box-sizing: border-box;
            margin: 0 auto; 
            width: 100%; 
            display: block; 
        }
        .yellow-container h1 {
            margin: 0;
            padding: 0;
            font-size: 24px;
            font-weight: bold;
            padding-left: 20px;
        }
        .yellow-container .points-container {
            display: none;
        }
        .card-content .btn {
            display: inline-block;
            padding: 8px 16px;
            background-color: #FFD036;
            text-decoration: none;
            border-radius: 30px;
            margin-top: 16px;
            font-weight: bold;
            margin-left: auto;
            margin-right: 10px;
            width: fit-content;
            color: #333333;
        }
        .card-content .btn:hover {
            background-color: #e6bb2e;
        }

        @media screen and (max-width: 768px) {
            body {
                padding-bottom: 20px;
            }
            .voucher-card-container {
                margin-bottom: 150px;
            }
            .offer-card {
                width: 100%;
            }
            .offer-card img {
                height: 200px;
            }

            .yellow-container {
                display: block;
                width: 100%;
                text-align: center;
                padding: 10px 0;
            }

            .yellow-container h1, .yellow-container p {
                text-align: left;
                padding-left: 20px;
            }

        
                .home {
                    display: none;
                }

                .points-container {
                    display: flex;
                    align-items: center;
                    justify-content: left;
                    font-size: 14px;
                    color: #333;
                    background-color: #ECECE7;
                    border-radius: 0.6rem;
                    box-shadow: 0 0.2rem 0.5rem #333;
                    letter-spacing: 0.1rem;
                    font-weight: 800;
                    padding: 10px;
                    max-width: 300px;
                    white-space: nowrap;
                    overflow: hidden;
                    text-overflow: ellipsis;
                    margin-left: 20px;
                }

                .points-container i {
                    margin-right: 5px;
                }

                .points-container .vomo-points {
                    display: flex;
                    align-items: center;
                }

                .points-container .vomo-points span:first-child {
                    margin-right: 10px;
                }

                .yellow-container .points-container {
                    display: flex;
                    align-items: center;
                    justify-content: left;
                    font-size: 14px;
                    color: #333;
                    background-color: #ECECE7;
                    border-radius: 0.6rem;
                    box-shadow: 0 0.2rem 0.5rem #333;
                    letter-spacing: 0.2rem;
                    font-weight: 800;
                    padding: 10px;
                }
        }
    </style>
</head>
<body>
    <?php include "vol_navbar.php"; ?>
    <?php include "ft.php"; ?>

    <div class="yellow-container">
        <h1>Your Vouchers</h1>
        <br>
        <div class="points-container">
            <i class='bx bx-gift'></i>
            <div class="vomo-points">
                <span>VOMOPoints</span>
                <span><?php echo $vomoPoints; ?></span>
            </div>
        </div>
    </div>

    <section class="home" id="home">
        <div class="header">
            <div class="greeting">
                <h1>Your Vouchers</h1>
            </div>
            <div class="points-container">
                <i class='bx bx-gift'></i>
                <div class="vomo-points">
                    <span>VOMOPoints</span>
                    <span><?php echo $vomoPoints; ?></span>
                </div>
            </div>
        </div>
    </section>

    <div class="voucher-card-container">
    <?php
    if ($redeemedVouchers && $redeemedVouchers->num_rows > 0) {
        while ($row = $redeemedVouchers->fetch_assoc()) {
            $title = $row['title'];
            $points = $row['points'];
            $image = base64_encode($row['images']);
            $redeemedDate = $row['redeemed_date'];
            $offerId = $row['offerId'];
            $dateTimeEnd = new DateTime($row['dateTimeEnd']);
            $formattedDateTimeEnd = $dateTimeEnd->format('F j, Y'); // Format date to 'Month Day, Year'
            ?>
            <div class="voucher-card">
                <img src="data:image/jpeg;base64,<?php echo $image; ?>" alt="<?php echo htmlspecialchars($title); ?>" class="card-img-top">
                <div class="card-content">
                    <h3 class="card-title"><?php echo htmlspecialchars($title); ?></h3>
                    <p class="card-text">Points: <?php echo htmlspecialchars($points); ?></p>
                    <p class="card-text">Redeemed Date: <?php echo htmlspecialchars($redeemedDate); ?></p>
                    <p class="card-text">Expires On: <?php echo htmlspecialchars($formattedDateTimeEnd); ?></p>
                    <a href="vol_useVoucherOverview.php?offerId=<?php echo htmlspecialchars($offerId); ?>" class="btn">Use</a>
                </div>
            </div>
            <?php
        }
    } else {
        echo '<p>No vouchers redeemed yet.</p>';
    }
    ?>

    <?php include "vol_footer.php"; ?>
</div>

</body>
</html>
