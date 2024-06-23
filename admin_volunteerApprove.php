<?php
session_start();
include "dbFunctions.php";

if (isset($_GET['volunteerId'])) {
    $volunteerId = $_GET['volunteerId'];

    // Fetch volunteer details
    $sql = "SELECT username, email, password FROM volunteers WHERE volunteerId = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $volunteerId);
    $stmt->execute();
    $result = $stmt->get_result();
    $volunteer = $result->fetch_assoc();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['approve'])) {
            // Approve volunteer
            $sql = "UPDATE volunteers SET approval_status = 1 WHERE volunteerId = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $volunteerId);
            $stmt->execute();
            echo "<p>Volunteer approved successfully.</p>";
        } elseif (isset($_POST['reject'])) {
            // Reject (delete) volunteer
            $sql = "DELETE FROM volunteers WHERE volunteerId = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $volunteerId);
            $stmt->execute();
            echo "<p>Volunteer rejected and deleted successfully.</p>";
        }
        $stmt->close();
        $conn->close();
        exit();
    }
} else {
    echo "<p>Invalid volunteer ID.</p>";
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Approve Volunteer</title>
</head>
<body>
    <h1>Approve Volunteer</h1>
    <?php if ($volunteer): ?>
        <p>Username: <?php echo htmlspecialchars($volunteer['username']); ?></p>
        <p>Email: <?php echo htmlspecialchars($volunteer['email']); ?></p>
        <p>Password: <?php echo htmlspecialchars($volunteer['password']); ?></p>
        <form method="post">
            <button type="submit" name="approve">Approve</button>
            <button type="submit" name="reject">Reject</button>
        </form>
    <?php else: ?>
        <p>Volunteer not found.</p>
    <?php endif; ?>
</body>
</html>

<?php
$conn->close();
?>