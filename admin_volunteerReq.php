
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
    <style>
        .card {
            border: 1px solid #ccc;
            padding: 20px;
            margin: 10px;
            border-radius: 5px;
            box-shadow: 2px 2px 12px #aaa;
        }
        .card a {
            text-decoration: none;
            color: blue;
        }
    </style>
</head>
<body>
    <h1>Volunteer Approval Requests</h1>
    <?php
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<div class='card'>";
            echo "<h2>" . htmlspecialchars($row["name"]) . "</h2>";
            echo "<p>Username: " . htmlspecialchars($row["username"]) . "</p>";
            echo "<p>Email: " . htmlspecialchars($row["email"]) . "</p>";
            echo "<p>Role: " . htmlspecialchars($row["role"]) . "</p>";
            echo "<a href='admin_volunteerApprove.php?volunteerId=" . urlencode($row["volunteerId"]) . "'>Review Volunteer</a>";
            echo "</div>";
        }
    } else {
        echo "<p>No volunteers awaiting approval.</p>";
    }

    mysqli_close($link);
    ?>
</body>
</html>