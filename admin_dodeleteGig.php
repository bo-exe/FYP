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
        // Redirect to the previous page
    $previousPage = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'admin_allgigs.php';
    header("Location: " . $previousPage . "?message=" . urlencode($message));
    exit();
    } else {
        $errormessage = "Gig deletion unsuccessful.";
        // Redirect to the previous page
    $previousPage = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'admin_allgigs.php';
    header("Location: " . $previousPage . "?message=" . urlencode($message));
    exit();
    }
} else {
    // Handle gracefully if EventID is not available
    $errormessage2 = "Event ID not provided. Gig deletion unsuccessful.";
        // Redirect to the previous page
    $previousPage = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'admin_allgigs.php';
    header("Location: " . $previousPage . "?message=" . urlencode($message));
    exit();
}