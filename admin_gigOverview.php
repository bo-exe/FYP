<?php
include "dbFunctions.php";
session_start();

// Ensure eventID is set and numeric
if (!isset($_GET['eventID']) || !is_numeric($_GET['eventID'])) {
    echo "Invalid event ID.";
    exit();
}

$eventID = $_GET['eventID'];

$query = "SELECT * FROM events WHERE eventID = ?";
$stmt = $link->prepare($query);
$stmt->bind_param("i", $eventID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    $eventData = $result->fetch_assoc();

    // Retrieve BLOB data and convert to base64 encoded string
    $imageData = base64_encode($eventData['images']);
    $imageSrc = 'data:image/jpeg;base64,' . $imageData;
} else {
    echo "Gig not found.";
    exit();
}

$stmt->close();
$link->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Gigs</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <?php include "admin_volunteerNavBar.php"; ?>
    <?php include "ft.php"; ?>

    <div class="gigoverview-event-card-container">
        <div class="gigoverview-event-card">
            <br>
            <h1 style="text-align: center;"><?php echo $eventData['title'] ?></h1>
            <br>
            <img src="<?php echo $imageSrc; ?>" alt="<?php echo $eventData['title']; ?>" class="gigoverview-card-img-top">
            <div class="gigoverview-event-card-content">
                <p class="card-text"><b>Start Date:</b> <?php echo $eventData['dateTimeStart']; ?></p>
                <p class="card-text"><b>End Date:</b> <?php echo $eventData['dateTimeEnd']; ?></p>
                <p class="card-text"><b>Locations:</b> <?php echo $eventData['locations']; ?></p>
                <p class="card-text"><b>Event Description:</b> <?php echo $eventData['descs']; ?></p>
                <p class="card-text"><b>Points:</b> <?php echo $eventData['points']; ?></p>
            </div>
            <div class="gigoverview-event-card-content">
                <a href="admin_retailDelete.php?eventID=<?php echo $eventData['eventID']; ?>" class="del-btn">Delete</a>
                <a href="admin_retailEdit.php?eventID=<?php echo $eventData['eventID']; ?>" class="edit-btn">Edit</a>
            </div>
        </div>
    </div>

    <?php include "admin_footer.php"; ?>
</body>

</html>