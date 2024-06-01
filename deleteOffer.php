<?php
include "dbFunctions.php";
include "retail_navbar.php";
include "ft.php";

if (isset($_GET['offerId'])) {
    $offerId = $_GET['offerId'];

    $query = "SELECT * FROM offers WHERE offerId=?";
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
        $termsAndConditions = $row['t&c'];
        $points = $row['points'];
        $amount = $row['amount'];
        $image = $row['images'];
    }

} else {
    // Offer ID not provided
    echo "Offer ID not provided.";
}
?>

<html>

<head>
    <meta charset="UTF-8">
    <title>Delete Offer</title>
</head>
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

    .del-btn {
        display: inline-block;
        padding: 8px 16px;
        background-color: #EF1E1E;
        text-decoration: none;
        border-radius: 30px;
        margin-top: 16px;
        color: #FFF5F5;
        font-weight: bold;
        text-align: center;
        margin-left: 130px;
    }

    .del-btn:hover {
        background-color: #d81b1b;
    }
</style>

<body>
<div class="container">
        <?php if (!empty($offerId)) { ?>
            <div class="card">
                <img src="Images/<?php echo $image; ?>" alt="Offer Image">
                <h2><?php echo $title; ?></h2>
                <p><b>Start Date:</b> <?php echo $dateTimeStart; ?></p>
                <p><b>End Date:</b> <?php echo $dateTimeEnd; ?></p>
                <p><b>Locations:</b> <?php echo $locations; ?></p>
                <p><b>Terms and Conditions:</b> <?php echo $termsAndConditions; ?></p>
                <p><b>Points:</b> <?php echo $points; ?></p>
                <p><b>Amount:</b> <?php echo $amount; ?></p>
                <a href="doDeleteOffer.php?offerId=<?php echo $offerId; ?>" class="del-btn">Delete</a>
            </div>
    <?php } else { ?>
        <div style="text-align: center;">
            <p>Invalid offer ID. Please try again.</p>
            <p><a href="retail_manage.php">Back to Offers</a></p>
        </div>
    <?php } ?>
</body>

</html>