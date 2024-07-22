<?php
include "dbFunctions.php";
include "admin_volunteerNavbar.php";
include "ft.php";

$msg = "";

if (isset($_GET['eventID'])) {
    $eventID = $_GET['eventID'];

    $query = "DELETE FROM events WHERE eventID=?";
    $stmt = mysqli_prepare($link, $query);
    mysqli_stmt_bind_param($stmt, "i", $eventID);
    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        $msg = "Gig successfully deleted";
    } else {
        $msg = "Gig could not be deleted. Error: " . mysqli_error($link);
    }
} else {
    // Handle gracefully if eventID is not available
    $msg = "Gig ID not provided. Gig has not been deleted.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Gig</title>
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
        <h2>Delete Gig</h2>
        <div class="message"><?php echo $msg; ?></div>
        <p><a href="admin_retailManage.php" class="back-link">Back to Gigs</a></p>
    </div>
</body>
</html>
