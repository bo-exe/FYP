<?php
include "dbFunctions.php";
include "ft.php";

session_start(); // Start session to maintain state

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $offerId = $_POST['offerId'];
    $title = $_POST['title'];
    $dateTimeStart = $_POST['dateTimeStart'];
    $dateTimeEnd = $_POST['dateTimeEnd'];
    $locations = $_POST['locations'];
    $termsAndConditions = $_POST['tandc'];
    $points = $_POST['points'];
    $amount = $_POST['amount'];

    // Handle image upload if new image is provided
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $imageData = file_get_contents($_FILES['image']['tmp_name']);
        $imageType = $_FILES['image']['type'];

        // Update the offer in the database with new image
        $updateQuery = "UPDATE offers SET title=?, dateTimeStart=?, dateTimeEnd=?, locations=?, tandc=?, points=?, amount=?, images=?, imageType=? WHERE offerId=?";
        $stmt = mysqli_prepare($link, $updateQuery);
        mysqli_stmt_bind_param($stmt, "sssssssssi", $title, $dateTimeStart, $dateTimeEnd, $locations, $termsAndConditions, $points, $amount, $imageData, $imageType, $offerId);
        mysqli_stmt_execute($stmt);

        if (mysqli_stmt_affected_rows($stmt) > 0) {
            echo "Offer updated successfully.";
        } else {
            echo "Error updating offer: " . mysqli_error($link);
        }
    } else {
        // Update the offer in the database without changing the image
        $updateQuery = "UPDATE offers SET title=?, dateTimeStart=?, dateTimeEnd=?, locations=?, tandc=?, points=?, amount=? WHERE offerId=?";
        $stmt = mysqli_prepare($link, $updateQuery);
        mysqli_stmt_bind_param($stmt, "sssssssi", $title, $dateTimeStart, $dateTimeEnd, $locations, $termsAndConditions, $points, $amount, $offerId);
        mysqli_stmt_execute($stmt);

        if (mysqli_stmt_affected_rows($stmt) > 0) {
            echo "Offer updated successfully.";
        } else {
            echo "Error updating offer: " . mysqli_error($link);
        }
    }
} else {
    echo "Method not allowed.";
}
?>
