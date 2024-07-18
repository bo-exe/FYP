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
        $message = "Gig deleted successfully.";
        header("Location: admin_allgigs.php?message=" . urlencode($message));
        exit();
    } else {
        $errormessage = "Gig deletion unsuccessful.";
        header("Location: admin_allgigs.php?message=" . urlencode($errormessage));
        exit();
    }
} else {
    // Handle gracefully if EventID is not available
    $errormessage2 = "Event ID not provided. Gig deletion unsuccessful.";
        header("Location: admin_allgigs.php?message=" . urlencode($errormessage2));
        exit();
}