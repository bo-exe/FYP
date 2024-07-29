<?php
include "dbFunctions.php";
session_start();

// Check if the user is logged in
if (!isset($_SESSION['volunteerId'])) {
    echo "User not logged in.";
    exit();
}

// Ensure eventID is provided and is numeric
if (!isset($_GET['eventID']) || !is_numeric($_GET['eventID'])) {
    echo "Invalid event ID.";
    exit();
}

$eventID = $_GET['eventID'];
$volunteerId = $_SESSION['volunteerId'];

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
    $stmt->close();
    $link->close();
    exit();
}

$stmt->close();

// Fetch current points of the volunteer
$volunteerQuery = "SELECT points FROM volunteers WHERE volunteerId = ?";
$volunteerStmt = $link->prepare($volunteerQuery);
$volunteerStmt->bind_param("i", $volunteerId);
$volunteerStmt->execute();
$volunteerResult = $volunteerStmt->get_result();

if ($volunteerResult->num_rows == 1) {
    $volunteerData = $volunteerResult->fetch_assoc();
    $currentPoints = $volunteerData['points'];
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
$updateQuery = "UPDATE volunteers SET points = ? WHERE volunteerId = ?";
$updateStmt = $link->prepare($updateQuery);
$updateStmt->bind_param("ii", $newPoints, $volunteerId);

if ($updateStmt->execute()) {
    error_log("Points updated successfully for username $username");
    header("Location: index.php");
} else {
    error_log("Update failed: " . $updateStmt->error);
    header("Location: vol_scanQR.php?error=update_failed");
}

$updateStmt->close();
$link->close();
?>
