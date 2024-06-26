<?php
include "dbFunctions.php";
include "ft.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $eventID = $_POST['eventID'];
    $title = $_POST['title'];
    $dateTimeStart = $_POST['dateTimeStart'];
    $dateTimeEnd = $_POST['dateTimeEnd'];
    $locations = $_POST['locations'];
    $descs = $_POST['descs'];
    $points = $_POST['points'];
    

            // Update the gig in the database
            $updateQuery = "UPDATE events SET title=?, dateTimeStart=?, dateTimeEnd=?, locations=?, descs=?, points=?, images=? WHERE eventID=?";
            $stmt = mysqli_prepare($link, $updateQuery);
            mysqli_stmt_bind_param($stmt, $title, $dateTimeStart, $dateTimeEnd, $locations, $descs, $points, $image, $eventID);
            mysqli_stmt_execute($stmt);

            if (mysqli_stmt_affected_rows($stmt) > 0) {
                echo "Gig updated successfully.";
            } else {
                echo "Error updating Gig: " . mysqli_error($link);
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }

?>
