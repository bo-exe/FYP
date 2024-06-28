<?php
include "dbFunctions.php";
include "admin_volunteerNavbar.php";
include "ft.php";

if (isset($_GET['eventID'])) {
    $eventID = $_GET['eventID'];

    $query = "SELECT * FROM events WHERE eventID=?";
    $stmt = mysqli_prepare($link, $query);
    mysqli_stmt_bind_param($stmt, "i", $eventID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_array($result);

    if (!empty($row)) {
        $eventID = $row['eventID'];
        $title = $row['title'];
        $dateTimeStart = $row['dateTimeStart'];
        $dateTimeEnd = $row['dateTimeEnd'];
        $locations = $row['locations'];
        $descs = $row['descs'];
        $points = $row['points'];
        // Retrieve the image binary data from database
        $imageData = $row['images'];
        // Convert binary data to base64 encoded string
        $image = base64_encode($imageData);
    }

} else {
    // If EventID not provided
    echo "Event ID not provided.";
}
?>

<html>
<head>
    <meta charset="UTF-8">
    <title>Delete Gig</title>
    <link rel="stylesheet" type="text/css" href="volunteeradminstyle.css">
</head>
<body>
    <div class="deletegig-container">
        <?php if (!empty($eventID)) { ?>
            <div class="card">
                <!-- Use data URI scheme to embed image -->
                <img src="data:image/jpeg;base64,<?php echo $image; ?>" alt="Event Image">
                <h2><?php echo $title; ?></h2>
                <p><b>Start Date:</b> <?php echo $dateTimeStart; ?></p>
                <p><b>End Date:</b> <?php echo $dateTimeEnd; ?></p>
                <p><b>Locations:</b> <?php echo $locations; ?></p>
                <p><b>Event Description:</b> <?php echo $descs; ?></p>
                <p><b>Points:</b> <?php echo $points; ?></p>
                <a href="admin_dodeleteGig.php?eventID=<?php echo $eventID; ?>" class="del-btn">Delete</a>
            </div>
        <?php } else { ?>
            <div style="text-align: center;">
                <p>Invalid Event ID. Please try again.</p>
                <p><a href="admin_allGigs.php">Back to Gigs.</a></p>
            </div>
        <?php } ?>
    </div>
</body>
</html>
