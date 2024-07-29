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
    echo "Event points: $eventPoints<br>"; // Debugging line
} else {
    echo "Event not found.";
    $stmt->close();
    $link->close();
    exit();
}

$stmt->close();

// Fetch current points of the volunteer
$volunteerQuery = "SELECT points FROM volunteers WHERE username = ?";
$volunteerStmt = $link->prepare($volunteerQuery);
$volunteerStmt->bind_param("s", $username);
$volunteerStmt->execute();
$volunteerResult = $volunteerStmt->get_result();

if ($volunteerResult->num_rows == 1) {
    $volunteerData = $volunteerResult->fetch_assoc();
    $currentPoints = $volunteerData['points'];
    echo "Current points: $currentPoints<br>"; // Debugging line
} else {
    echo "Volunteer not found.";
    $volunteerStmt->close();
    $link->close();
    exit();
}

$volunteerStmt->close();

// Calculate new total points
$newPoints = $currentPoints + $eventPoints;
echo "New points total: $newPoints<br>"; // Debugging line

// Update user's points
$updateQuery = "UPDATE volunteers SET points = ? WHERE username = ?";
$updateStmt = $link->prepare($updateQuery);
$updateStmt->bind_param("is", $newPoints, $username);

if ($updateStmt->execute()) {
    echo "Points updated successfully.";
} else {
    echo "Error updating points.";
}

$updateStmt->close();
$link->close();
?>
