<?php
include "dbFunctions.php";
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    echo "User not logged in.";
    exit();
}

// Ensure eventID is provided and is numeric
if (!isset($_GET['eventID']) || !is_numeric($_GET['eventID'])) {
    echo "Invalid event ID.";
    exit();
}

$eventID = $_GET['eventID'];
$username = $_SESSION['username'];

// Fetch points for the event
$query = "SELECT points FROM events WHERE eventID = ?";
$stmt = $link->prepare($query);
$stmt->bind_param("i", $eventID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    $eventData = $result->fetch_assoc();
    $eventPoints = $eventData['points'];
} else {
    echo "Event not found.";
    exit();
}

$stmt->close();

// Update user's points
$updateQuery = "UPDATE volunteers SET points = points + ? WHERE username = ?";
$updateStmt = $link->prepare($updateQuery);
$updateStmt->bind_param("is", $eventPoints, $username);

if ($updateStmt->execute()) {
    echo "Points updated successfully.";
} else {
    echo "Error updating points.";
}

$updateStmt->close();
$link->close();
?>
