<?php
include "dbFunctions.php";
include "admin_retailNavbar.php";
include "ft.php";

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
        $points = $row['points'];
        $amount = $row['amount_after_redemption']; // Use the calculated amount after deduction
        $redeemedVouchers = $row['redeemed_vouchers'];

        // Fetch image blob data and convert to base64
        $imageData = $row['images'];
        $imageType = $row['imageType'];

        $image = 'data:image/' . $imageType . ';base64,' . base64_encode($imageData);

        // Check if current date and time is after offer's end date
        $currentDateTime = date('Y-m-d H:i:s');
        if ($currentDateTime > $dateTimeEnd) {
            $expired = true;
        } else {
            $expired = false;
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
    <title><?php echo htmlspecialchars($title); ?></title>
    <style>
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .card {
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 400px;
        }

        .card img {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .del-btn, .edit-btn {
            display: inline-block;
            padding: 8px 20px;
            border-radius: 30px;
            margin-top: 16px;
            color: #FFF5F5;
            font-weight: bold;
            text-decoration: none;
            text-align: center;
            margin-left: 10px; /* Adjust margin as needed */
        }

        .del-btn {
            background-color: #EF1E1E;
        }

        .del-btn:hover {
            background-color: #d81b1b;
        }

        .edit-btn {
            background-color: #FFD036;
        }

        .edit-btn:hover {
            background-color: #e6b800;
        }

        .expired {
            color: #EF1E1E;
            font-weight: bold;
            font-size: 18px;
        }
    </style>
</head>

<body>
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
            <p><b>Points:</b> <?php echo htmlspecialchars($points); ?></p>
            <p><b>Amount:</b> <?php echo htmlspecialchars($amount); ?></p>
            <p><b>Redeemed Vouchers:</b> <?php echo htmlspecialchars($redeemedVouchers); ?></p>
            <?php if ($expired) { ?>
                <p class="expired">This offer has expired.</p>
            <?php } ?>
            <a href="admin_retailDoDelete.php?offerId=<?php echo htmlspecialchars($offerId); ?>" class="del-btn">Delete</a>
            <a href="admin_retailEdit.php?offerId=<?php echo htmlspecialchars($offerId); ?>" class="edit-btn">Edit</a>
        </div>
    <?php } else { ?>
        <div style="text-align: center;">
            <p>Invalid offer ID. Please try again.</p>
            <p><a href="admin_retailManage.php">Back to Offers</a></p>
        </div>
    <?php } ?>
</div>
</body>

</html>
