<?php
include "dbFunctions.php"; // Include your database connection file
include "vol_navbar.php"; // Include your navigation bar
include "ft.php"; // Include your footer or other necessary includes

// Check if offerId is provided via GET parameter
if (isset($_GET['activityId'])) {
    $activityId = $_GET['activityId'];

    // Query to fetch activity details from database
    $query = "SELECT * FROM activities WHERE activityId=?";
    $stmt = mysqli_prepare($link, $query);
    mysqli_stmt_bind_param($stmt, "i", $activityId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $activity = mysqli_fetch_array($result);

    // Check if activity exists
    if (!empty($activity)) {
        $title = $activity['title'];
        $dateTimeStart = $activity['dateTimeStart'];
        $dateTimeEnd = $activity['dateTimeEnd'];
        $locations = $activity['locations'];
        $description = $activity['description'];
        $points = $activity['points'];
        $image = $activity['image'];
    } else {
        // Activity not found
        echo "Activity not found.";
        exit; // Exit script if activity not found
    }

} else {
    // Activity ID not provided
    echo "Activity ID not provided.";
    exit; // Exit script if activity ID not provided
}
?>

<html>
<head>
    <meta charset="UTF-8">
    <title>Cancel Activity</title>
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

    .cancel-btn {
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

    .cancel-btn:hover {
        background-color: #d81b1b;
    }
</style>
<body>
    <div class="container">
        <div class="card">
            <img src="Images/<?php echo $image; ?>" alt="Activity Image">
            <h2><?php echo $title; ?></h2>
            <p><b>Start Date:</b> <?php echo $dateTimeStart; ?></p>
            <p><b>End Date:</b> <?php echo $dateTimeEnd; ?></p>
            <p><b>Locations:</b> <?php echo $locations; ?></p>
            <p><b>Description:</b> <?php echo $description; ?></p>
            <p><b>Points:</b> <?php echo $points; ?></p>
            <a href="doCancelActivity.php?activityId=<?php echo $activityId; ?>" class="cancel-btn">Cancel Activity</a>
        </div>
    </div>
</body>
</html>
