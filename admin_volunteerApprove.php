<?php
session_start();
include "dbFunctions.php";

if (isset($_GET['volunteerId']) && isset($_GET['requestNumber'])) {
    $volunteerId = $_GET['volunteerId'];
    $requestNumber = $_GET['requestNumber'];

    // Fetch volunteer details
    $sql = "SELECT username, email, password FROM volunteers WHERE volunteerId = ?";
    $stmt = mysqli_prepare($link, $sql);
    mysqli_stmt_bind_param($stmt, "s", $volunteerId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $volunteer = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['approve'])) {
            // Approve volunteer
            $sql = "UPDATE volunteers SET approval_status = 1 WHERE volunteerId = ?";
            $stmt = mysqli_prepare($link, $sql);
            mysqli_stmt_bind_param($stmt, "s", $volunteerId);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            echo "<p>Volunteer approved successfully.</p>";
        } elseif (isset($_POST['reject'])) {
            // Reject (delete) volunteer
            $sql = "DELETE FROM volunteers WHERE volunteerId = ?";
            $stmt = mysqli_prepare($link, $sql);
            mysqli_stmt_bind_param($stmt, "s", $volunteerId);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            echo "<p>Volunteer rejected and deleted successfully.</p>";
        }
        mysqli_close($link);
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
    <h1>Volunteer Request #<?php echo htmlspecialchars($requestNumber); ?></h1>
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
mysqli_close($link);
?>
