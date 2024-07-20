<?php
include "dbFunctions.php";
include "vol_navbar.php";
include "ft.php";

session_start();
$volunteerId = $_SESSION['volunteerId'];

if (isset($_GET['offerId'])) {
    $offerId = $_GET['offerId'];

    $query = "SELECT *, amount - redeemed_vouchers AS amount_after_redemption FROM offers WHERE offerId=?";
    $stmt = mysqli_prepare($link, $query);
    mysqli_stmt_bind_param($stmt, "i", $offerId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_array($result);

    if (!empty($row)) {
        $offerId = $row['offerId'];
        $title = $row['title'];
        $dateTimeStart = $row['dateTimeStart'];
        $dateTimeEnd = $row['dateTimeEnd'];
        $locations = $row['locations'];
        $termsAndConditions = $row['tandc'];
        $instructions = $row['instructions'];
        $pointsRequired = $row['points'];
        $amount = $row['amount_after_redemption'];
        $redeemedVouchers = $row['redeemed_vouchers'];

        $imageData = $row['images'];
        $image = 'data:image/jpeg;base64,' . base64_encode($imageData);

        // Check if the voucher is expired
        $currentDate = date("Y-m-d H:i:s");
        $voucherExpired = ($currentDate > $dateTimeEnd);

        // Fetch user's current points
        $userQuery = "SELECT points FROM volunteers WHERE volunteerId=?";
        $userStmt = mysqli_prepare($link, $userQuery);
        mysqli_stmt_bind_param($userStmt, "i", $volunteerId);
        mysqli_stmt_execute($userStmt);
        $userResult = mysqli_stmt_get_result($userStmt);
        $userRow = mysqli_fetch_array($userResult);
        $userPoints = $userRow['points'];

        // Handle voucher redemption
        $voucherRedeemed = false;
        $errorMessage = '';
        if (isset($_POST['redeem'])) {
            if ($voucherExpired) {
                $errorMessage = "This voucher has expired.";
            } elseif ($userPoints >= $pointsRequired && $amount > 0) {
                // Deduct points from the user
                $newPoints = $userPoints - $pointsRequired;
                $updatePointsQuery = "UPDATE volunteers SET points=? WHERE volunteerId=?";
                $updatePointsStmt = mysqli_prepare($link, $updatePointsQuery);
                mysqli_stmt_bind_param($updatePointsStmt, "ii", $newPoints, $volunteerId);
                mysqli_stmt_execute($updatePointsStmt);

                // Update the redeemed_vouchers count in the offers table
                $newRedeemedVouchers = $redeemedVouchers + 1;
                $updateRedeemedQuery = "UPDATE offers SET redeemed_vouchers=? WHERE offerId=?";
                $updateRedeemedStmt = mysqli_prepare($link, $updateRedeemedQuery);
                mysqli_stmt_bind_param($updateRedeemedStmt, "ii", $newRedeemedVouchers, $offerId);
                mysqli_stmt_execute($updateRedeemedStmt);

                $insertRedeemedQuery = "INSERT INTO redeemed_vouchers (volunteerId, offerId) VALUES (?, ?)";
                $insertRedeemedStmt = mysqli_prepare($link, $insertRedeemedQuery);
                mysqli_stmt_bind_param($insertRedeemedStmt, "ii", $volunteerId, $offerId);
                mysqli_stmt_execute($insertRedeemedStmt);

                $voucherRedeemed = true;
                echo "<script type='text/javascript'>
                        window.onload = function() {
                            document.getElementById('popup').style.display = 'block';
                            document.getElementById('popup-message').innerText = 'Voucher Redeemed Successfully!';
                            document.getElementById('popup-link').innerText = 'Click here to see your vouchers!';
                            document.getElementById('popup-link').href = 'vol_userVoucher.php';
                        };
                      </script>";
            } else {
                $errorMessage = "You do not have enough points or the voucher is no longer available.";
            }
        }
    }
} else {
    // Offer ID not provided
    echo "Offer ID not provided.";
}
?>
<html>

<head>
    <meta charset="UTF-8">
    <title>Voucher Information</title>
    <style>
        body {
            margin: 0;
            padding: 0;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding-top: 100px;
            padding-bottom: 55px;
            position: relative;
        }

        .card {
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 400px;
            max-width: 90%;
            position: relative;
        }

        .card img {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .card p {
            margin-bottom: 5px;
        }

        .stores-card-content {
            position: relative;
            text-align: center;
            padding-bottom: 30px;
        }

        .error-message {
            color: red;
            font-weight: bold;
            text-align: center;
            margin-top: 10px;
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
        }

        .redeemed-btn {
            display: inline-block;
            padding: 8px 16px;
            background-color: #FFE17D;
            text-decoration: none;
            border-radius: 30px;
            color: #333;
            font-weight: bold;
            text-align: center;
            transition: background-color 0.3s ease;
            pointer-events: none;
        }

        .redeemed-btn:hover {
            background-color: #e6bb2e;
        }

        .redeem-btn {
            display: block;
            width: 100%;
            padding: 12px;
            background-color: #FFD036;
            text-decoration: none;
            border-radius: 30px;
            color: #333333;
            font-weight: bold;
            text-align: center;
            transition: background-color 0.3s ease;
        }

        .redeem-btn:hover {
            background-color: #e6bb2e;
        }

        /* Yellow Container */
        .yellow-container {
            background-color: #FFD036;
            color: #333;
            text-align: left;
            padding: 15px;
            box-sizing: border-box;
            margin-bottom: 20px;
            display: none;
        }

        .yellow-container h1 {
            margin: 0;
            padding: 0;
            font-size: 24px;
            font-weight: bold;
            padding-left: 20px;
        }

        @media screen and (max-width: 768px) {
            .container {
                padding-top: 20px;
                padding-bottom: 40px;
            }

            .card {
                margin-bottom: 70px;
            }

            .redeem-btn {
                width: auto;
                display: inline-block;
                padding: 8px 16px;
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
        }

        #popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            border-radius: 10px;
            text-align: center;
        }

        #popup a {
            display: block;
            margin-top: 10px;
            text-decoration: none;
            color: #FFD036;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="yellow-container">
        <h1>Vouchers</h1>
    </div>

    <div class="container">
        <?php if (!empty($offerId)) { ?>
            <div class="card">
                <img src="<?php echo $image; ?>" alt="Offer Image">
                <h2><?php echo htmlspecialchars($title); ?></h2>
                <p><b>Start Date:</b> <?php echo htmlspecialchars($dateTimeStart); ?></p>
                <p><b>End Date:</b> <?php echo htmlspecialchars($dateTimeEnd); ?></p>
                <br>
                <p><b>Locations:</b> <?php echo htmlspecialchars($locations); ?></p>
                <br>
                <p><b>Terms and Conditions:</b> <?php echo htmlspecialchars($termsAndConditions); ?></p>
                <br>
                <p><b>Instructions:</b> <?php echo htmlspecialchars($instructions); ?></p>
                <br>
                <p><b>Points Required:</b> <?php echo htmlspecialchars($pointsRequired); ?></p>
                <p><b>Available Amount:</b> <?php echo htmlspecialchars($amount); ?></p>

                <div class="stores-card-content">
                    <?php if ($voucherExpired) { ?>
                        <button class="redeemed-btn" disabled>Expired</button>
                    <?php } elseif ($amount <= 0 || $voucherRedeemed) { ?>
                        <button class="redeemed-btn" disabled>Used</button>
                    <?php } else { ?>
                        <form method="post">
                            <button type="submit" name="redeem" class="redeem-btn">Use</button>
                        </form>
                    <?php } ?>
                    <?php if (!empty($errorMessage)) { ?>
                        <div class="error-message">
                            <?php echo $errorMessage; ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        <?php } else { ?>
            <div style="text-align: center;">
                <p>Invalid offer ID. Please try again.</p>
                <p><a href="vol_allVouchers.php">Back to Offers</a></p>
            </div>
        <?php } ?>
    </div>

    <!-- Popup for successful redemption or expiration -->
    <div id="popup">
        <p id="popup-message"></p>
        <a id="popup-link" href="index.php">Click here to return back to home page!</a>
    </div>

    <?php include "vol_footer.php"; ?>
</body>

</html>
