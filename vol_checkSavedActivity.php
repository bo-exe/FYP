<?php
session_start();

if (!isset($_SESSION['volunteerId']) || empty($_SESSION['volunteerId'])) {
    echo json_encode(['saved' => false]);
    exit();
}

include "dbFunctions.php";

$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die(json_encode(['saved' => false, 'message' => 'Connection failed: ' . $conn->connect_error]));
}

$data = json_decode(file_get_contents('php://input'), true);
$eventID = $data['eventID'];
$volunteerID = $_SESSION['volunteerId'];

$sql = "SELECT * FROM saved_activity WHERE eventID = '$eventID' AND volunteerID = '$volunteerID'";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    echo json_encode(['saved' => true]);
} else {
    echo json_encode(['saved' => false]);
}

mysqli_close($conn);
?>
