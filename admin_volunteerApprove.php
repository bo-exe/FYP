<?php
session_start();
include "dbFunctions.php";

if (isset($_GET['adminID']) && isset($_GET['requestNumber'])) {
    $adminID = $_GET['adminID'];
    $requestNumber = $_GET['requestNumber'];

    // Fetch volunteer admin details
    $sql = "SELECT company, username, password, name, number, email, role FROM admins WHERE adminID = ?";
    $stmt = mysqli_prepare($link, $sql);
    mysqli_stmt_bind_param($stmt, "s", $adminID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $volunteeradmin = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['approve'])) {
            // Approve volunteer org
            $sql = "UPDATE admins SET approval_status = 1 WHERE adminID = ?";
            $stmt = mysqli_prepare($link, $sql);
            mysqli_stmt_bind_param($stmt, "s", $adminID);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            echo "<p>volunteer admin approved successfully.</p>";
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
    echo "<p>Invalid volunteer organization ID.</p>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Approve Volunteer Admin Request</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="volunteer-approval-page">
    <h1>Volunteer Admin Request #<?php echo htmlspecialchars($requestNumber); ?></h1>
    <?php if ($volunteeradmin): ?>
        <div class="req-card">
            <p>Company: <?php echo htmlspecialchars($volunteeradmin['company']); ?></p>
            <p>Username: <?php echo htmlspecialchars($volunteeradmin['username']); ?></p>
            <p>Password: <?php echo htmlspecialchars($volunteeradmin['password']); ?></p>
            <p>Name: <?php echo htmlspecialchars($volunteeradmin['name']); ?></p>
            <p>Number: <?php echo htmlspecialchars($volunteeradmin['number']); ?></p>
            <p>Email: <?php echo htmlspecialchars($volunteeradmin['email']); ?></p>
            <p>Role: <?php echo htmlspecialchars($volunteeradmin['role']); ?></p>
            <form method="post">
                <button type="submit" name="approve" class="approve-button">APPROVE</button>
                <button type="submit" name="reject" class="reject-button">REJECT</button>
            </form>
        </div>
    <?php else: ?>
        <p>volunteer admin not found.</p>
    <?php endif; ?>
</body>
</html>

<?php
mysqli_close($link);
?>