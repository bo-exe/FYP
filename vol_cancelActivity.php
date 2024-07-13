<?php
// Include your database connection file
include 'dbFunctions.php';

// Start session and get volunteer ID
session_start();
$volunteerID = $_SESSION['volunteerId'];

// Get eventID from query parameters
$eventID = $_GET['eventID'];

// Fetch event details
$query = "
    SELECT e.title, e.dateTimeStart, e.dateTimeEnd, e.locations, e.descs, e.points, e.images
    FROM events e
    WHERE e.eventID = ?
";
$stmt = $link->prepare($query);
$stmt->bind_param("i", $eventID);
$stmt->execute();
$result = $stmt->get_result();
$event = $result->fetch_assoc();
$stmt->close();

// Handle cancellation
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $deleteQuery = "
        DELETE FROM event_volunteers
        WHERE eventID = ? AND volunteerID = ?
    ";
    $deleteStmt = $link->prepare($deleteQuery);
    $deleteStmt->bind_param("ii", $eventID, $volunteerID);
    $deleteStmt->execute();
    $deleteStmt->close();

    // Redirect to the activities page
    header("Location: vol_allYourActivities.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cancel Activity</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f5f5f5;
        }
        .event-container {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 100%;
        }
        .event-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .event-header img {
            max-width: 100px;
            border-radius: 10px;
        }
        .event-details {
            margin-top: 20px;
        }
        .event-details h2 {
            margin: 0;
        }
        .event-details p {
            margin: 5px 0;
        }
        .event-actions {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .event-actions button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .cancel-btn {
            background-color: red;
            color: white;
        }
    </style>
</head>
<body>
    <div class="event-container">
        <div class="event-header">
            <img src="<?php // echo $event['images']; ?>" alt="Event Image">
        </div>
        <div class="event-details">
            <h2><?php echo $event['title']; ?></h2>
            <p><strong>Date & Time:</strong> <?php echo date('l, d M Y g:i A', strtotime($event['dateTimeStart'])); ?> - <?php echo date('g:i A', strtotime($event['dateTimeEnd'])); ?></p>
            <p><strong>Location:</strong> <?php echo $event['locations']; ?></p>
            <p><strong>Description:</strong> <?php echo $event['descs']; ?></p>
            <p><strong>Points:</strong> <?php echo $event['points']; ?></p>
        </div>
        <div class="event-actions">
            <form method="post">
                <button type="submit" class="cancel-btn">Cancel</button>
            </form>
        </div>
    </div>
</body>
</html>
