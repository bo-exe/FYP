<?php
session_start();

if (!isset($_SESSION['volunteerId']) || empty($_SESSION['volunteerId'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in.']);
    exit();
}

include "dbFunctions.php";

$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Connection failed: ' . $conn->connect_error]));
}

$data = json_decode(file_get_contents('php://input'), true);
$eventID = $data['eventID'];
$volunteerID = $_SESSION['volunteerId'];
$action = $data['action'];

if ($action === 'save') {
    $checkSql = "SELECT * FROM saved_activity WHERE eventID = '$eventID' AND volunteerID = '$volunteerID'";
    $checkResult = mysqli_query($conn, $checkSql);

    if ($checkResult && mysqli_num_rows($checkResult) === 0) {
        $sql = "INSERT INTO saved_activity (eventID, volunteerID) VALUES ('$eventID', '$volunteerID')";
    } else {
        echo json_encode(['success' => false, 'message' => 'Activity already saved.']);
        exit();
    }
} elseif ($action === 'remove') {
    $sql = "DELETE FROM saved_activity WHERE eventID = '$eventID' AND volunteerID = '$volunteerID'";
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid action.']);
    exit();
}

if (mysqli_query($conn, $sql)) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $sql . '<br>' . mysqli_error($conn)]);
}

mysqli_close($conn);
