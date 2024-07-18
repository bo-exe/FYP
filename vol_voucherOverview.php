<?php
include "dbFunctions.php";
include "vol_navbar.php";
include "ft.php";

session_start();
$volunteerId = $_SESSION['volunteerId']; // Assuming you store the logged-in user's ID in the session

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
            if ($userPoints >= $pointsRequired && $amount > 0) {
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

                $voucherRedeemed = true;
                echo "Voucher redeemed successfully!";
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
            padding-top: 50px;
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
            /* Change to relative positioning */
            text-align: center;
            padding-bottom: 30px;
            /* Add some padding to create space for error message */
        }

        .error-message {
            color: red;
            font-weight: bold;
            text-align: center;
            margin-top: 10px;
            position: absolute;
            /* Position the error message absolutely */
            bottom: 0;
            /* Align at the bottom */
            left: 0;
            width: 100%;
            /* Full width */
        }


        .redeemed-btn {
            display: inline-block;
            padding: 8px 16px;
            background-color: #FFE17D;
            /* Changed color for redeemed button */
            text-decoration: none;
            border-radius: 30px;
            color: #333;
            /* Set text color */
            font-weight: bold;
            text-align: center;
            transition: background-color 0.3s ease;
            pointer-events: none;
            /* Disable clicking on the button */
        }

        .redeemed-btn:hover {
            background-color: #e6bb2e        }

        .redeem-btn {
            display: block;
            /* Change display to block for full-width responsiveness */
            width: 100%;
            /* Make button full width */
            padding: 12px;
            /* Adjust padding for better touch target */
            background-color: #FFD036;
            text-decoration: none;
            border-radius: 30px;
            color: #333333;
            /* Set text color */
            font-weight: bold;
            text-align: center;
            transition: background-color 0.3s ease;
        }

        .redeem-btn:hover {
            background-color: #e6bb2e
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
                /* Set back to auto width for larger screens */
                display: inline-block;
                /* Reset to inline-block for smaller padding and centered */
                padding: 8px 16px;
                /* Adjust padding for smaller screens */
            }
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
                    <?php if ($amount <= 0 || $voucherRedeemed) { ?>
                        <button class="redeemed-btn" disabled>Redeemed</button>
                    <?php } else { ?>
                        <form method="post">
                            <button type="submit" name="redeem" class="redeem-btn">Redeem Now</button>
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
                <p><a href="admin_retailManage.php">Back to Offers</a></p>
            </div>
        <?php } ?>
    </div>

    <?php include "footer.php"; ?>
</body>

</html>
