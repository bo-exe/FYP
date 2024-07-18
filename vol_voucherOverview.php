<?php
include "dbFunctions.php";
include "vol_navbar.php";
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
        $amount = $row['amount_after_redemption']; 
        $redeemedVouchers = $row['redeemed_vouchers'];

        $imageData = $row['images'];
        // $imageType = $row['imageType'];

        $image = 'data:image/'  . ';base64,' . base64_encode($imageData);
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

    .yellow-container {
        background-color: #FFD036;
        color: #333;
        text-align: left;
        padding: 15px;
        box-sizing: border-box;
    }

    .yellow-container h1 {
        margin: 0;
        padding: 0;
        font-size: 24px;
        font-weight: bold;
        padding-left: 20px;
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
        position: absolute;
        bottom: 20px;
        right: 20px;
        width: auto;
        text-align: center;
    }

    .del-btn {
        display: inline-block;
        padding: 8px 16px;
        background-color: #FFD036;
        text-decoration: none;
        border-radius: 30px;
        color: #333;
        font-weight: bold;
        text-align: center;
        transition: background-color 0.3s ease;
    }

    .del-btn:hover {
        background-color: #d81b1b;
    }

    @media screen and (max-width: 768px) {
        .yellow-container {
            display: block;
            width: 100%;
            text-align: center;
        }

        .yellow-container h1 {
            text-align: left;
            padding-left: 20px;
        }

        .container {
            padding-top: 20px;
            padding-bottom: 40px;
        }

        .card {
            margin-bottom: 70px; 
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
            <p><b>Points:</b> <?php echo htmlspecialchars($points); ?></p>
            <p><b>Amount:</b> <?php echo htmlspecialchars($amount); ?></p>
            <div class="stores-card-content">
                <a href="vol_storeVouchers.php?storeId=<?php echo $storeData['storeId']; ?>" class="del-btn">Redeem Now</a>
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
