<?php
session_start();
include "dbFunctions.php";

// Fetch volunteers with approval_status = 0
$queryCheck = "SELECT * FROM volunteers WHERE approval_status = 0";
$resultCheck = mysqli_query($link, $queryCheck) or die(mysqli_error($link));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Volunteer Approval Requests</title>
    <link rel="stylesheet" type="text/css" href="volunteeradminstyle.css">
</head>
<body>
    <h1>Volunteer Approval Requests</h1>
    <?php
    if (mysqli_num_rows($resultCheck) > 0) {
        $requestNumber = 1; // Initialize the request counter
        while($row = mysqli_fetch_assoc($resultCheck)) {
            echo "<div class='req-card'>";
            echo "<h2>Volunteer Request #" . $requestNumber . "</h2>"; // Heading with request number
            echo "<h3>" . htmlspecialchars($row["name"]) . "</h3>";
            echo "<p>Username: " . htmlspecialchars($row["username"]) . "</p>";
            echo "<p>Email: " . htmlspecialchars($row["email"]) . "</p>";
            echo "<p>Role: " . htmlspecialchars($row["role"]) . "</p>";
            echo "<a href='admin_volunteerApprove.php?volunteerId=" . urlencode($row["volunteerId"]) . "&requestNumber=" . $requestNumber . "'>Review Volunteer</a>";
            echo "</div>";
            $requestNumber++; // Increment the request counter
        }
    } else {
        echo "<p>No volunteers awaiting approval.</p>";
    }

    mysqli_close($link);
    ?>
</body>
</html>
