<?php
include "dbFunctions.php";
include "ft.php";
session_start();
$volunteerId = $_SESSION['volunteerId'];

if (isset($_GET['offerId'])) {
    $offerId = $_GET['offerId'];

    // Fetch voucher details
    $query = "SELECT *, amount - redeemed_vouchers AS amount_after_redemption FROM offers WHERE offerId=?";
    $stmt = mysqli_prepare($link, $query);
    mysqli_stmt_bind_param($stmt, "i", $offerId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_array($result);

    if (!empty($row)) {
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
        $voucherRedeemed = false;
        
        if (isset($_POST['redeem']) && !$voucherExpired && $amount > 0) {
            // Generate a 6-digit random code
            $code = rand(100000, 999999);
        
            // Update the voucher in the database
            $updateQuery = "
                UPDATE redeemed_vouchers
                SET redeem = 'used', code = ?
                WHERE volunteerId = ? AND offerId = ? AND redeem = 'use'
            ";
            $stmt = $link->prepare($updateQuery);
            if ($stmt) {
                $stmt->bind_param('sii', $code, $volunteerId, $offerId);
                $stmt->execute();

                if ($stmt->affected_rows > 0) {
                    $voucherRedeemed = true;
                    // Show modal with success message
                    echo "<script>
                        window.onload = function() {
                            document.getElementById('popup-message').innerText = 'Voucher redeemed successfully!';
                            document.getElementById('popup-code').innerText = 'Code: $code';
                            document.getElementById('popup').style.display = 'block';
                            document.getElementById('popup-link').href = 'vol_voucherSuccess.php?offerId=$offerId&code=$code';
                        };
                    </script>";
                } else {
                    $errorMessage = "Failed to redeem voucher.";
                }
            } else {
                die("Prepare statement failed: " . $link->error);
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
    <title>Voucher Information</title>
    <link rel="icon" type="image/x-icon" href="images/logo.jpg">
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
<?php include "vol_navbar.php"; ?>

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
            <p><b>Locations:</b> <?php echo htmlspecialchars($locations); ?></p>
            <p><b>Terms and Conditions:</b> <?php echo htmlspecialchars($termsAndConditions); ?></p>
            <p><b>Instructions:</b> <?php echo htmlspecialchars($instructions); ?></p>
            <p><b>Points Required:</b> <?php echo htmlspecialchars($pointsRequired); ?></p>
            <p><b>Available Amount:</b> <?php echo htmlspecialchars($amount); ?></p>

            <div class="stores-card-content">
                <?php if ($amount <= 0 || $voucherRedeemed || $voucherExpired) { ?>
                    <button class="redeemed-btn" disabled><?php echo $voucherExpired ? 'Expired' : 'Redeemed'; ?></button>
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
            <p><a href="vol_userVouchers.php">Back to Offers</a></p>
        </div>
    <?php } ?>
</div>


    <div id="popup">
        <p id="popup-message"></p>
        <p id="popup-code"></p>
        <a id="popup-link" href="#">Use Code Upon Checkout</a>
    </div>

    <?php include "vol_footer.php"; ?>
</body>
</html>
