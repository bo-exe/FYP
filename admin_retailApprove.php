<?php
session_start();
include "dbFunctions.php";

if (isset($_GET['adminID']) && isset($_GET['requestNumber'])) {
    $adminID = $_GET['adminID'];
    $requestNumber = $_GET['requestNumber'];

    // Fetch retailer details
    $sql = "SELECT company, username, password, name, number, email, role FROM admins WHERE adminID = ?";
    $stmt = mysqli_prepare($link, $sql);
    mysqli_stmt_bind_param($stmt, "s", $adminID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $retailer = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['approve'])) {
            // Approve retail org
            $sql = "UPDATE admins SET approval_status = 1 WHERE adminID = ?";
            $stmt = mysqli_prepare($link, $sql);
            mysqli_stmt_bind_param($stmt, "s", $adminID);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            header("Location: admin_RetailReq.php");
        } elseif (isset($_POST['reject'])) {
            // Reject (delete) request
            $sql = "DELETE FROM admins WHERE adminID = ?";
            $stmt = mysqli_prepare($link, $sql);
            mysqli_stmt_bind_param($stmt, "s", $adminID);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            header("Location: admin_RetailReq.php");
        }
        mysqli_close($link);
        exit();
    }
} else {
    echo "<p>Invalid retail organization ID.</p>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Approve Retail Admin Request</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="volunteer-approval-page">
    <h1>Retail Admin Request #<?php echo htmlspecialchars($requestNumber); ?></h1>
    <?php if ($retailer): ?>
        <div class="req-card">
            <p>Company: <?php echo htmlspecialchars($retailer['company']); ?></p>
            <p>Username: <?php echo htmlspecialchars($retailer['username']); ?></p>
            <p>Password: <?php echo htmlspecialchars($retailer['password']); ?></p>
            <p>Name: <?php echo htmlspecialchars($retailer['name']); ?></p>
            <p>Number: <?php echo htmlspecialchars($retailer['number']); ?></p>
            <p>Email: <?php echo htmlspecialchars($retailer['email']); ?></p>
            <p>Role: <?php echo htmlspecialchars($retailer['role']); ?></p>
            <form method="post">
                <button type="submit" name="approve" class="approve-button">APPROVE</button>
                <button type="submit" name="reject" class="reject-button">REJECT</button>
            </form>
        </div>
    <?php else: ?>
        <p>Retailer not found.</p>
    <?php endif; ?>
</body>
</html>

<?php
mysqli_close($link);
?>

