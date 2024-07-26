<?php
include "dbFunctions.php";
include "ft.php";
require_once 'vendor/autoload.php';

session_start();
$volunteerId = $_SESSION['volunteerId'];

if (isset($_GET['offerId'])) {
    $offerId = $_GET['offerId'];

    $query = "SELECT *, amount - redeemed_vouchers AS amount_after_redemption FROM offers WHERE offerId=?";
    $stmt = mysqli_prepare($link, $query);
    
    if ($stmt) {
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
            
            if ($userStmt) {
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
                        echo "<script type='text/javascript'>
                                window.onload = function() {
                                    document.getElementById('popup').style.display = 'block';
                                    document.getElementById('popup-message').innerText = 'Voucher has expired!';
                                    document.getElementById('popup-link').innerText = 'Click here to return back to home page!';
                                    document.getElementById('popup-link').href = 'index.php';
                                };
                            </script>";
                    } elseif ($userPoints >= $pointsRequired && $amount > 0) {
                        // Generate a random 6-digit/alphabet PIN
                        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                        $pin = '';
                        for ($i = 0; $i < 6; $i++) {
                            $pin .= $characters[mt_rand(0, strlen($characters) - 1)];
                        }

                        // Insert redemption record into database
                        $redeemDate = date("Y-m-d H:i:s");
                        $redeemQuery = "INSERT INTO redeemed_vouchers (volunteerId, offerId, redeemed_date, code, redeem) VALUES (?, ?, ?, ?, 'used')";
                        $redeemStmt = mysqli_prepare($link, $redeemQuery);
                        
                        if ($redeemStmt) {
                            mysqli_stmt_bind_param($redeemStmt, "iiss", $volunteerId, $offerId, $redeemDate, $pin);
                            mysqli_stmt_execute($redeemStmt);

                            // Update the amount of available vouchers in the 'offers' table
                            $updateQuery = "UPDATE offers SET redeemed_vouchers = redeemed_vouchers + 1, amount = amount - 1 WHERE offerId=?";
                            $updateStmt = mysqli_prepare($link, $updateQuery);

                            if ($updateStmt) {
                                mysqli_stmt_bind_param($updateStmt, "i", $offerId);
                                mysqli_stmt_execute($updateStmt);
                            } else {
                                echo "Error updating offer: " . mysqli_error($link);
                            }

                            // Redirect after a short delay to ensure the modal can be seen
                            echo "<script type='text/javascript'>
                                    window.onload = function() {
                                        var modal = document.getElementById('pinModal');
                                        var pinText = document.getElementById('pinText');
                                        pinText.innerText = '$pin';
                                        modal.style.display = 'block';

                                        // Redirect after a few seconds
                                        setTimeout(function() {
                                            window.location.href = 'vol_userVoucher.php';
                                        }, 5000); // Adjust the delay as needed
                                    };
                                </script>";
                        } else {
                            echo "Error preparing redeem statement: " . mysqli_error($link);
                        }
                    } else {
                        $errorMessage = "You do not have enough points or the voucher is no longer available.";
                    }
                }
            } else {
                echo "Error preparing user statement: " . mysqli_error($link);
            }
        } else {
            echo "Offer not found.";
        }
    } else {
        echo "Error preparing offer statement: " . mysqli_error($link);
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
        /* Your existing styles */
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

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
            text-align: center;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <img src="<?php echo $image; ?>" alt="Voucher Image">
            <div class="stores-card-content">
                <h3><?php echo $title; ?></h3>
                <p>Starts: <?php echo $dateTimeStart; ?></p>
                <p>Ends: <?php echo $dateTimeEnd; ?></p>
                <p>Locations: <?php echo $locations; ?></p>
                <p>Points Required: <?php echo $pointsRequired; ?></p>
                <p>Terms and Conditions: <?php echo $termsAndConditions; ?></p>
                <p>Instructions: <?php echo $instructions; ?></p>
                <p>Available Amount: <?php echo $amount; ?></p>
                <?php if ($amount <= 0 || $voucherExpired): ?>
                    <div class="redeemed-btn">Voucher not available</div>
                <?php else: ?>
                    <form method="post">
                        <button type="submit" name="redeem" class="redeem-btn">Redeem</button>
                    </form>
                <?php endif; ?>
                <div class="error-message"><?php echo $errorMessage; ?></div>
            </div>
        </div>
    </div>

    <!-- Popup Modal -->
    <div id="popup">
        <p id="popup-message"></p>
        <a id="popup-link" href="#">Link</a>
    </div>

    <!-- PIN Modal -->
    <div id="pinModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="document.getElementById('pinModal').style.display='none'">&times;</span>
            <h2><?php echo $title; ?></h2>
            <p>Your PIN: <span id="pinText"></span></p>
            <p>Use Code Upon Checkout!</p>
        </div>
    </div>

    <script>
        var modal = document.getElementById('pinModal');
        var span = document.getElementsByClassName('close')[0];

        span.onclick = function() {
            modal.style.display = 'none';
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }
    </script>
</body>
</html>
