<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Details</title>
    <link rel="stylesheet" href="style.css">
    <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet'>
    <link rel="icon" type="image/x-icon" href="images/logo.jpg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
<?php include "vol_navbar.php"; ?>

<div class="event-details-container">
    <?php
    include "dbFunctions.php";

    // Get the eventID and volunteerID from the URL parameters
    $eventID = isset($_GET['eventID']) ? intval($_GET['eventID']) : 0;
    $volunteerID = isset($_GET['volunteerID']) ? intval($_GET['volunteerID']) : 0;

    // Query to fetch event with the specified eventID
    $query = "SELECT * FROM events WHERE eventID = $eventID";
    $result = mysqli_query($link, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $event = mysqli_fetch_assoc($result);
        ?>
        <div class="event-details">
            <h1><?php echo htmlspecialchars($event['title']); ?></h1>
            <p><strong>Date and Time Start:</strong> <?php echo htmlspecialchars($event['dateTimeStart']); ?></p>
            <p><strong>Date and Time End:</strong> <?php echo htmlspecialchars($event['dateTimeEnd']); ?></p>
            <p><strong>Location:</strong> <?php echo htmlspecialchars($event['locations']); ?></p>
            <p><strong>Description:</strong> <?php echo htmlspecialchars($event['descs']); ?></p>
            <p><strong>Points:</strong> <?php echo htmlspecialchars($event['points']); ?></p>
            <p><strong>Image:</strong></p>
            <img src="https://placehold.co/600" alt="<?php echo htmlspecialchars($event['title']); ?>" style="max-width:100%;">
            <div class="text-center mt-4">
                <a href="vol_signUpActivities.php?eventID=<?php echo $eventID; ?>&volunteerID=<?php echo $volunteerID; ?>"><button class="btn btn-primary">Apply Now</button></a>
            </div>
        </div>
        <?php
    } else {
        echo "<p>Event not found.</p>";
    }
    ?>
</div>

<?php include "footer.php"; ?>
</body>
</html>
