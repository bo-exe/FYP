<?php
session_start(); // Start session to maintain state

include "dbFunctions.php";
include "ft.php";
include "admin_teamNavbar.php";

$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $offerId = $_POST['offerId'];
    $title = $_POST['title'];
    $dateTimeStart = $_POST['dateTimeStart'];
    $dateTimeEnd = $_POST['dateTimeEnd'];
    $locations = $_POST['locations'];
    $termsAndConditions = $_POST['tandc'];
    $instructions = $_POST['instructions'];
    $points = $_POST['points'];
    $amount = $_POST['amount'];

    // Handle image upload if new image is provided
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $imageData = file_get_contents($_FILES['image']['tmp_name']);
        $imageType = $_FILES['image']['type'];

        // Update the offer in the database with new image
        $updateQuery = "UPDATE offers SET title=?, dateTimeStart=?, dateTimeEnd=?, locations=?, tandc=?, instructions=?, points=?, amount=?, images=?, imageType=? WHERE offerId=?";
        $stmt = mysqli_prepare($link, $updateQuery);
        mysqli_stmt_bind_param($stmt, "sssssssssii", $title, $dateTimeStart, $dateTimeEnd, $locations, $termsAndConditions, $instructions, $points, $amount, $imageData, $imageType, $offerId);
        mysqli_stmt_execute($stmt);

        if (mysqli_stmt_affected_rows($stmt) > 0) {
            $msg = "Offer updated successfully.";
        } else {
            $msg = "Error updating offer: " . mysqli_error($link);
        }
    } else {
        // Update the offer in the database without changing the image
        $updateQuery = "UPDATE offers SET title=?, dateTimeStart=?, dateTimeEnd=?, locations=?, tandc=?, instructions=?, points=?, amount=? WHERE offerId=?";
        $stmt = mysqli_prepare($link, $updateQuery);
        mysqli_stmt_bind_param($stmt, "ssssssssi", $title, $dateTimeStart, $dateTimeEnd, $locations, $termsAndConditions, $instructions, $points, $amount, $offerId);
        mysqli_stmt_execute($stmt);

        if (mysqli_stmt_affected_rows($stmt) > 0) {
            $msg = "Offer updated successfully.";
        } else {
            $msg = "Error updating offer: " . mysqli_error($link);
        }
    }
} else {
    $msg = "Method not allowed.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Offer</title>
    <style>
        body {
            background-color: #f0f0f0;
            text-align: center;
        }
        .container {
            margin-top: 50px;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 0 auto;
        }
        .message {
            margin-bottom: 20px;
            font-size: 18px;
        }
        .back-link {
            display: inline-block;
            padding: 10px 20px;
            background-color: #FFD036;
            text-decoration: none;
            color: #fff;
            border-radius: 30px;
            font-weight: bold;
        }
        .back-link:hover {
            background-color: #FFC300;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Edit Offer</h2>
        <div class="message"><?php echo $msg; ?></div>
        <p><a href="admin_teamManageOffers.php" class="back-link">Back to Offers</a></p>
    </div>
</body>
</html>
