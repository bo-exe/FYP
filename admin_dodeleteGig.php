<?php
include "dbFunctions.php";
include "admin_volunteerNavbar.php";
include "ft.php";

if (isset($_GET['eventID'])) {
    $EventID = $_GET['eventID'];

    $msg = "";
    $query = "DELETE FROM events WHERE eventID=?";
    $stmt = mysqli_prepare($link, $query);
    mysqli_stmt_bind_param($stmt, "i", $EventID);
    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        $msg = "Gig successfully deleted";
    } else {
        $msg = "Gig has not been deleted. Error: " . mysqli_error($link);
    }
} else {
    // Handle gracefully if EventID is not available
    $msg = "Event ID not provided. Gig has not been deleted.";
}
?>

<html>
<head>
    <meta charset="UTF-8">
    <title>Delete Gig</title>
</head>

<body>
    <div style="text-align: center;">
        <?php echo $msg; ?>
        <p><a href="admin_allGigs.php">Back to Gigs.</a></p>
    </div>
</body>

</html>
