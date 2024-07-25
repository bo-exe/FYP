<?php
session_start();
include "dbFunctions.php";

// Fetch volunteer with approval_status = 0
$queryCheck = "SELECT * FROM admins WHERE approval_status = 0 AND role = 'volunteerAdmin'";
$resultCheck = mysqli_query($link, $queryCheck) or die(mysqli_error($link));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Volunteer Admin Approval Requests</title>
    <link rel="stylesheet" type="text/css" href="volunteeradminstyle.css">
</head>
<body class="volunteer-approval-page">
    <h1>Volunteer Approval Requests</h1>
    <?php
    if (mysqli_num_rows($resultCheck) > 0) {
        $requestNumber = 1;
        while($row = mysqli_fetch_assoc($resultCheck)) {
            echo "<div class='req-card'>";
            echo "<h2>Volunteer Admin Request #" . $requestNumber . "</h2>";
            echo "<h3>" . htmlspecialchars($row["company"]) . "</h3>";
            echo "<p>Username: " . htmlspecialchars($row["username"]) . "</p>";
            echo "<p>Name: " . htmlspecialchars($row["name"]) . "</p>";
            echo "<p>Number: " . htmlspecialchars($row["number"]) . "</p>";
            echo "<p>Email: " . htmlspecialchars($row["email"]) . "</p>";
            echo "<p>Role: " . htmlspecialchars($row["role"]) . "</p>";
            echo "<a href='admin_volunteerApprove.php?adminID=" . urlencode($row["adminID"]) . "&requestNumber=" . $requestNumber . "'>Review Request</a>";
            echo "</div>";
            $requestNumber++;
        }
    } else {
        echo "<p>No volunteer admin requests awaiting approval.</p>";
    }

    mysqli_close($link);
    ?>
</body>
</html>

