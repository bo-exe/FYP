<?php
session_start();
include "dbFunctions.php";

if (isset($_GET['adminID']) && isset($_GET['requestNumber'])) {
    $adminID = $_GET['adminID'];
    $requestNumber = $_GET['requestNumber'];

    // Fetch volunteer details
    $sql = "SELECT username, email, password FROM admins WHERE adminID = ?";
    $stmt = mysqli_prepare($link, $sql);
    mysqli_stmt_bind_param($stmt, "s", $adminID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $volunteer = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['approve'])) {
            // Approve volunteer
            $sql = "UPDATE admins SET approval_status = 1 WHERE adminID = ?";
            $stmt = mysqli_prepare($link, $sql);
            mysqli_stmt_bind_param($stmt, "s", $adminID);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            echo "<p>Volunteer approved successfully.</p>";
        } elseif (isset($_POST['reject'])) {
            // Reject (delete) request
            $sql = "DELETE FROM admins WHERE adminID = ?";
            $stmt = mysqli_prepare($link, $sql);
            mysqli_stmt_bind_param($stmt, "s", $adminID);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            echo "<p>Request rejected and deleted successfully.</p>";
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
    <title>Approve Volunteer Admin Request</title>
</head>
<body>
    <h1>Volunteer Admin Request #<?php echo htmlspecialchars($requestNumber); ?></h1>
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
