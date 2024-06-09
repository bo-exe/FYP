<?php
include "dbFunctions.php";
include "ft.php";

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
    

            // Update the offer in the database
            $updateQuery = "UPDATE offers SET title=?, dateTimeStart=?, dateTimeEnd=?, locations=?, tandc=?, points=?, amount=?, images=? WHERE offerId=?";
            $stmt = mysqli_prepare($link, $updateQuery);
            mysqli_stmt_bind_param($stmt, "ssssssssi", $title, $dateTimeStart, $dateTimeEnd, $locations, $termsAndConditions, $points, $amount, $image, $offerId);
            mysqli_stmt_execute($stmt);

            if (mysqli_stmt_affected_rows($stmt) > 0) {
                echo "Offer updated successfully.";
            } else {
                echo "Error updating offer: " . mysqli_error($link);
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }

?>
