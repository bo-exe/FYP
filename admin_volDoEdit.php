<?php
include "dbFunctions.php";
include "ft.php";
include "admin_volunteerNavbar.php";

$msg = "";

session_start(); // Start session to maintain state

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $eventID = $_POST['eventID'];
    $title = $_POST['title'];
    $dateTimeStart = $_POST['dateTimeStart'];
    $dateTimeEnd = $_POST['dateTimeEnd'];
    $locations = $_POST['locations'];
    $descs = $_POST['descs'];
    $points = $_POST['points'];

    // Handle image upload if new image is provided
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $imageData = file_get_contents($_FILES['image']['tmp_name']);
        $imageType = $_FILES['image']['type'];

        // Update the offer in the database with new image
        $updateQuery = "UPDATE events SET title=?, dateTimeStart=?, dateTimeEnd=?, locations=?, descs=?, points=?, images=?, imageType=? WHERE eventID=?";
        $stmt = mysqli_prepare($link, $updateQuery);
        mysqli_stmt_bind_param($stmt, "sssssssii", $title, $dateTimeStart, $dateTimeEnd, $locations, $descs, $points, $imageData, $imageType, $eventID);
        mysqli_stmt_execute($stmt);

        if (mysqli_stmt_affected_rows($stmt) > 0) {
            $msg = "Gig updated successfully.";
        } else {
            $msg = "Error updating gig: " . mysqli_error($link);
        }
    } else {
        // Update the offer in the database without changing the image
        $updateQuery = "UPDATE events SET title=?, dateTimeStart=?, dateTimeEnd=?, locations=?, descs=?, points=? WHERE eventID=?";
        $stmt = mysqli_prepare($link, $updateQuery);
        mysqli_stmt_bind_param($stmt, "ssssssi", $title, $dateTimeStart, $dateTimeEnd, $locations, $descs, $points, $eventID);
        mysqli_stmt_execute($stmt);

        if (mysqli_stmt_affected_rows($stmt) > 0) {
            $msg = "Gig updated successfully.";
        } else {
            $msg = "Error updating gig: " . mysqli_error($link);
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
    <title>Edit Gig</title>
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
        <h2>Edit Gig</h2>
        <div class="message"><?php echo $msg; ?></div>
        <p><a href="admin_volManage.php" class="back-link">Back to Gigs</a></p>
    </div>
</body>
</html>
