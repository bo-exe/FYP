<?php
include "dbFunctions.php";
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize form data
    $title = mysqli_real_escape_string($link, $_POST['title']);
    $dateTimeStart = mysqli_real_escape_string($link, $_POST['dateTimeStart']);
    $dateTimeEnd = mysqli_real_escape_string($link, $_POST['dateTimeEnd']);
    $locations = mysqli_real_escape_string($link, $_POST['locations']);
    $tandc = mysqli_real_escape_string($link, $_POST['tandc']);
    $points = intval($_POST['points']);
    $amount = floatval($_POST['amount']);
    $images = mysqli_real_escape_string($link, $_POST['images']);

    // Get the highest existing offerId from the database
    $query = "SELECT MAX(offerId) AS maxOfferId FROM offers";
    $result = mysqli_query($link, $query);
    $row = mysqli_fetch_assoc($result);
    $maxOfferId = $row['maxOfferId'];

    // Increment the highest offerId by 1 to get the new offerId
    $newOfferId = $maxOfferId + 1;

    // Insert the new offer into the database
    $insertQuery = "INSERT INTO offers (offerId, title, dateTimeStart, dateTimeEnd, locations, tandc, points, amount, images) 
                    VALUES ('$newOfferId', '$title', '$dateTimeStart', '$dateTimeEnd', '$locations', '$tandc', '$points', '$amount', '$images')";
    if (mysqli_query($link, $insertQuery)) {
        $message = "Offer added successfully.";
    } else {
        $errorMessage = "Error adding offer: " . mysqli_error($link);
    }
}

// Redirect back to the form page with a success or error message
if (isset($message)) {
    header("Location: form.php?message=" . urlencode($message));
} elseif (isset($errorMessage)) {
    header("Location: form.php?error=" . urlencode($errorMessage));
} else {
    header("Location: form.php");
}
exit();
?>
