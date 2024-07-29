<?php
include "dbFunctions.php";
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: vol_scanQR.php?error=not_logged_in");
    exit();
}

// Ensure eventID is provided and is numeric
if (!isset($_GET['eventID']) || !is_numeric($_GET['eventID'])) {
    header("Location: vol_scanQR.php?error=invalid_event_id");
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
    header("Location: vol_scanQR.php?error=event_not_found");
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
} else {
    header("Location: vol_scanQR.php?error=volunteer_not_found");
    $volunteerStmt->close();
    $link->close();
    exit();
}

$volunteerStmt->close();

// Calculate new total points
$newPoints = $currentPoints + $eventPoints;

// Update user's points
$updateQuery = "UPDATE volunteers SET points = ? WHERE username = ?";
$updateStmt = $link->prepare($updateQuery);
$updateStmt->bind_param("is", $newPoints, $username);

if ($updateStmt->execute()) {
    header("Location: index.php");
} else {
    header("Location: vol_scanQR.php?error=update_failed");
}

$updateStmt->close();
$link->close();
?>
