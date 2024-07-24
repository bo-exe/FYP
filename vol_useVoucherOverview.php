<?php
include "dbFunctions.php";
include "ft.php";

session_start();
$volunteerId = $_SESSION['volunteerId'];

if (isset($_GET['offerId'])) {
    $offerId = $_GET['offerId'];

    // Fetch offer details
    $query = "SELECT *, amount - redeemed_vouchers AS amount_after_redemption FROM offers WHERE offerId=?";
    $stmt = mysqli_prepare($link, $query);
    if (!$stmt) {
        die('mysqli_prepare failed for offer details: ' . mysqli_error($link));
    }

    mysqli_stmt_bind_param($stmt, "i", $offerId);
    $execute = mysqli_stmt_execute($stmt);
    if (!$execute) {
        die('mysqli_stmt_execute failed: ' . mysqli_stmt_error($stmt));
    }

    $result = mysqli_stmt_get_result($stmt);
    if (!$result) {
        die('mysqli_stmt_get_result failed: ' . mysqli_stmt_error($stmt));
    }

    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

    if ($row) {
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
        $type = $row['type'];

        $imageData = $row['images'];
        $image = 'data:image/jpeg;base64,' . base64_encode($imageData);

        // Check if the voucher is expired
        $currentDate = date("Y-m-d H:i:s");
        $voucherExpired = ($currentDate > $dateTimeEnd);

        // Fetch user's current points
        $userQuery = "SELECT points FROM volunteers WHERE volunteerId=?";
        $userStmt = mysqli_prepare($link, $userQuery);
        if (!$userStmt) {
            die('mysqli_prepare failed for user points: ' . mysqli_error($link));
        }

        mysqli_stmt_bind_param($userStmt, "i", $volunteerId);
        $executeUser = mysqli_stmt_execute($userStmt);
        if (!$executeUser) {
            die('mysqli_stmt_execute failed for user points: ' . mysqli_stmt_error($userStmt));
        }

        $userResult = mysqli_stmt_get_result($userStmt);
        if (!$userResult) {
            die('mysqli_stmt_get_result failed for user points: ' . mysqli_stmt_error($userStmt));
        }

        $userRow = mysqli_fetch_array($userResult, MYSQLI_ASSOC);
        $userPoints = $userRow['points'];

        // Handle voucher usage
        $voucherUsed = false;
        $errorMessage = '';
        if (isset($_POST['redeem'])) {
            if ($voucherExpired) {
                $errorMessage = "This voucher has expired.";
            } elseif ($amount <= 0) {
                $errorMessage = "The voucher is no longer available.";
            } else {
                // Check if the voucher has already been used by this user
                $checkQuery = "SELECT * FROM redeemed_vouchers WHERE volunteerId=? AND offerId=?";
                $checkStmt = mysqli_prepare($link, $checkQuery);
                if (!$checkStmt) {
                    die('mysqli_prepare failed for voucher check: ' . mysqli_error($link));
                }

                mysqli_stmt_bind_param($checkStmt, "ii", $volunteerId, $offerId);
                $executeCheck = mysqli_stmt_execute($checkStmt);
                if (!$executeCheck) {
                    die('mysqli_stmt_execute failed for voucher check: ' . mysqli_stmt_error($checkStmt));
                }

                $checkResult = mysqli_stmt_get_result($checkStmt);
                if (!$checkResult) {
                    die('mysqli_stmt_get_result failed for voucher check: ' . mysqli_stmt_error($checkStmt));
                }

                if (mysqli_num_rows($checkResult) > 0) {
                    $errorMessage = "You have already used this voucher.";
                } else {
                    // Update the redeemed_vouchers count in the offers table
                    $newRedeemedVouchers = $redeemedVouchers + 1;
                    $updateRedeemedQuery = "UPDATE offers SET redeemed_vouchers=? WHERE offerId=?";
                    $updateRedeemedStmt = mysqli_prepare($link, $updateRedeemedQuery);
                    if (!$updateRedeemedStmt) {
                        die('mysqli_prepare failed for update redeemed vouchers: ' . mysqli_error($link));
                    }

                    mysqli_stmt_bind_param($updateRedeemedStmt, "ii", $newRedeemedVouchers, $offerId);
                    $executeUpdate = mysqli_stmt_execute($updateRedeemedStmt);
                    if (!$executeUpdate) {
                        die('mysqli_stmt_execute failed for update redeemed vouchers: ' . mysqli_stmt_error($updateRedeemedStmt));
                    }

                    // Generate voucher code or barcode
                    if ($type == 'online') {
                        $code = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 10);
                    } else {
                        $code = substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 12);
                    }

                    $insertRedeemedQuery = "INSERT INTO redeemed_vouchers (volunteerId, offerId, code, redeem) VALUES (?, ?, ?, 'used')";
                    $insertRedeemedStmt = mysqli_prepare($link, $insertRedeemedQuery);
                    if (!$insertRedeemedStmt) {
                        die('mysqli_prepare failed for insert redeemed voucher: ' . mysqli_error($link));
                    }

                    mysqli_stmt_bind_param($insertRedeemedStmt, "iis", $volunteerId, $offerId, $code);
                    $executeInsert = mysqli_stmt_execute($insertRedeemedStmt);
                    if (!$executeInsert) {
                        die('mysqli_stmt_execute failed for insert redeemed voucher: ' . mysqli_stmt_error($insertRedeemedStmt));
                    }

                    $voucherUsed = true;
                    echo "<script type='text/javascript'>
                            window.onload = function() {
                                document.getElementById('popup').style.display = 'block';
                                document.getElementById('popup-title').innerText = '".htmlspecialchars($title)."';
                                document.getElementById('popup-code').innerText = '$code';
                                document.getElementById('popup-message').innerText = '".($type == 'online' ? 'Use code upon checkout' : 'Scan to use voucher')."';
                                document.getElementById('popup-link').innerText = 'Click here to see your vouchers!';
                                document.getElementById('popup-link').href = 'vol_userVoucher.php';
                            };
                          </script>";
                }
            }
        }
    } else {
        echo "Offer not found.";
    }
} else {
    echo "Offer ID not provided.";
}
?>
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
    <div class="container">
        <div class="card">
            <div class="stores-card-content">
                <h2><?php echo $title; ?></h2>
                <img src="<?php echo $image; ?>" alt="Offer Image" class="store-image">
                <p><strong>Start Date:</strong> <?php echo $dateTimeStart; ?></p>
                <p><strong>End Date:</strong> <?php echo $dateTimeEnd; ?></p>
                <p><strong>Locations:</strong> <?php echo $locations; ?></p>
                <p><strong>Points Required:</strong> <?php echo $pointsRequired; ?></p>
                <p><strong>Amount:</strong> <?php echo $amount; ?></p>
                <div class="instructions">
                    <h4>Instructions</h4>
                    <p><?php echo $instructions; ?></p>
                </div>
                <?php if ($errorMessage): ?>
                    <div class="error-message"><?php echo $errorMessage; ?></div>
                <?php endif; ?>
                <?php if ($voucherUsed): ?>
                    <div class="redeemed-btn">Voucher Redeemed</div>
                <?php else: ?>
                    <form method="post">
                        <button type="submit" name="redeem" class="redeem-btn">Use</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div id="popup" class="popup">
        <span class="close-btn" onclick="document.getElementById('popup').style.display='none'">&times;</span>
        <h2 id="popup-title"></h2>
        <p id="popup-code"></p>
        <p id="popup-message"></p>
        <a id="popup-link" href=""></a>
    </div>
</body>
</html>
