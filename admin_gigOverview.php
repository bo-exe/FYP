<?php
include "dbFunctions.php";
session_start();

// Ensure eventID is set and numeric
if (!isset($_GET['eventID']) || !is_numeric($_GET['eventID'])) {
    echo "Invalid event ID.";
    exit();
}

$eventID = $_GET['eventID'];

// Prepare and execute query to get event details
$query = "SELECT * FROM events WHERE eventID = ?";
$stmt = $link->prepare($query);
$stmt->bind_param("i", $eventID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    $eventData = $result->fetch_assoc();

    // Retrieve QR code path from QR table
    $qrQuery = "SELECT qrImage FROM QR WHERE EventID = ?";
    $qrStmt = $link->prepare($qrQuery);
    $qrStmt->bind_param("i", $eventID);
    $qrStmt->execute();
    $qrResult = $qrStmt->get_result();

    if ($qrResult->num_rows == 1) {
        $qrData = $qrResult->fetch_assoc();
        $qrImageSrc = $qrData['qrImage'];
        $imageData = base64_encode($eventData['images']);
        $imageSrc = 'data:image/jpeg;base64,' . $imageData;
    } 
    $qrStmt->close();
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
    <link rel="stylesheet" type="text/css" href="volunteeradminstyle.css">
</head>

<body>
    <?php include "admin_volunteerNavBar.php"; ?>
    <?php include "ft.php"; ?>

    <div class="gigoverview-event-card-container">
        <div class="event-card">
            <br>
            <h1 style="text-align: center;"><?php echo htmlspecialchars($eventData['title']); ?></h1>
            <br>
            <img src="<?php echo htmlspecialchars($imageSrc); ?>" alt="<?php echo htmlspecialchars($eventData['title']); ?>" class="card-img-top">
            <div class="event-card-content">
                <p class="card-text"><b>Start Date:</b> <?php echo htmlspecialchars($eventData['dateTimeStart']); ?></p>
                <p class="card-text"><b>End Date:</b> <?php echo htmlspecialchars($eventData['dateTimeEnd']); ?></p>
                <p class="card-text"><b>Locations:</b> <?php echo htmlspecialchars($eventData['locations']); ?></p>
                <p class="card-text"><b>Event Description:</b> <?php echo htmlspecialchars($eventData['descs']); ?></p>
                <p class="card-text"><b>Points:</b> <?php echo htmlspecialchars($eventData['points']); ?></p>
            </div>
            <div class="event-card-content">
                <a href="admin_retailDelete.php?eventID=<?php echo htmlspecialchars($eventData['eventID']); ?>" class="del-btn">Delete</a>
                <a href="admin_retailEdit.php?eventID=<?php echo htmlspecialchars($eventData['eventID']); ?>" class="edit-btn">Edit</a>
            </div>
            <div class="qr-code-container" style="text-align: center; margin-top: 20px;">
                <p><b>QR Code:</b></p>
                <img src="<?php echo htmlspecialchars($qrImageSrc); ?>" alt="QR Code for <?php echo htmlspecialchars($eventData['title']); ?>" class="card-img-top" style="width: 150px; height: 150px;">
            </div>
        </div>
    </div>

    <?php include "admin_footer.php"; ?>
</body>

</html>
