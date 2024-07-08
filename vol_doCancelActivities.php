<?php
include "dbFunctions.php"; // Include your database connection file

// Check if activityId is provided via GET parameter
if (isset($_GET['activityId'])) {
    $activityId = $_GET['activityId'];

    // Perform deletion query
    $query = "DELETE FROM activities WHERE activityId=?";
    $stmt = mysqli_prepare($link, $query);
    mysqli_stmt_bind_param($stmt, "i", $activityId);

    // Execute query
    if (mysqli_stmt_execute($stmt)) {
        // Deletion successful
        echo "Activity canceled successfully.";
        // Optionally redirect user to another page after successful cancellation
        // header("Location: somePage.php");
        // exit;
    } else {
        // Error in execution
        echo "Error: Unable to cancel activity.";
    }

} else {
    // Activity ID not provided
    echo "Activity ID not provided.";
}
?>
