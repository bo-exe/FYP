<?php
include "dbFunctions.php";
include "ft.php";
include "admin_retailNavbar.php";

$msg = "";

session_start(); // Start session to maintain state

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $offerId = $_POST['offerId'];
    $title = $_POST['title'];
    $dateTimeStart = $_POST['dateTimeStart'];
    $dateTimeEnd = $_POST['dateTimeEnd'];
    $locations = $_POST['locations'];
    $termsAndConditions = $_POST['tandc'];
    $instructions = $_POST['instructions'];
    $points = $_POST['points'];
    $amount = $_POST['amount'];
    $company = $_POST['company'];

    // Handle image upload if new image is provided
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $imageData = file_get_contents($_FILES['image']['tmp_name']);
        $imageType = $_FILES['image']['type'];

        // Update the offer in the database with new image
        $updateQuery = "UPDATE offers SET title=?, dateTimeStart=?, dateTimeEnd=?, locations=?, tandc=?, instructions=?, points=?, amount=?, images=?, imageType=?, company=? WHERE offerId=?";
        $stmt = mysqli_prepare($link, $updateQuery);
        mysqli_stmt_bind_param($stmt, "sssssssssisi", $title, $dateTimeStart, $dateTimeEnd, $locations, $termsAndConditions, $instructions, $points, $amount, $imageData, $imageType, $company, $offerId);
        mysqli_stmt_execute($stmt);

        if (mysqli_stmt_affected_rows($stmt) > 0) {
            $msg = "Offer updated successfully.";
        } else {
            $msg = "Error updating offer: " . mysqli_error($link);
        }
    } else {
        // Handle QR code upload if new QR is provided
        if (isset($_FILES['QR']) && $_FILES['QR']['error'] === UPLOAD_ERR_OK) {
            $qrData = file_get_contents($_FILES['QR']['tmp_name']);
            $qrType = $_FILES['QR']['type'];

            // Update the offer in the database with new QR code
            $updateQuery = "UPDATE offers SET title=?, dateTimeStart=?, dateTimeEnd=?, locations=?, tandc=?, instructions=?, points=?, amount=?, QR=?, QRType=?, company=? WHERE offerId=?";
            $stmt = mysqli_prepare($link, $updateQuery);
            mysqli_stmt_bind_param($stmt, "sssssssssisi", $title, $dateTimeStart, $dateTimeEnd, $locations, $termsAndConditions, $instructions, $points, $amount, $qrData, $qrType, $company, $offerId);
            mysqli_stmt_execute($stmt);

            if (mysqli_stmt_affected_rows($stmt) > 0) {
                $msg = "Offer updated successfully.";
            } else {
                $msg = "Error updating offer: " . mysqli_error($link);
            }
        } else {
            // Update the offer in the database without changing the image or QR code
            $updateQuery = "UPDATE offers SET title=?, dateTimeStart=?, dateTimeEnd=?, locations=?, tandc=?, instructions=?, points=?, amount=?, company=? WHERE offerId=?";
            $stmt = mysqli_prepare($link, $updateQuery);
            mysqli_stmt_bind_param($stmt, "sssssssssi", $title, $dateTimeStart, $dateTimeEnd, $locations, $termsAndConditions, $instructions, $points, $amount, $company, $offerId);
            mysqli_stmt_execute($stmt);

            if (mysqli_stmt_affected_rows($stmt) > 0) {
                $msg = "Offer updated successfully.";
            } else {
                $msg = "Error updating offer: " . mysqli_error($link);
            }
        }
    }
} else {
    $msg = "Method not allowed.";
}
?>
