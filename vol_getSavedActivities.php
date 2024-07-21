<?php
session_start();

if (!isset($_SESSION['volunteerId']) || empty($_SESSION['volunteerId'])) {
    echo json_encode([]);
    exit();
}

include "dbFunctions.php";

$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die(json_encode([]));
}

$volunteerID = $_SESSION['volunteerId'];
$sql = "SELECT eventID FROM saved_activity WHERE volunteerID = '$volunteerID'";
$result = mysqli_query($conn, $sql);

$savedActivities = [];
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $savedActivities[] = $row['eventID'];
    }
}

mysqli_close($conn);
echo json_encode($savedActivities);