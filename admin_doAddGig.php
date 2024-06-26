<?php
include "dbFunctions.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize form data
    $title = mysqli_real_escape_string($link, $_POST['title']);
    $dateTimeStart = mysqli_real_escape_string($link, $_POST['dateTimeStart']);
    $dateTimeEnd = mysqli_real_escape_string($link, $_POST['dateTimeEnd']);
    $locations = mysqli_real_escape_string($link, $_POST['locations']);
    $descs = mysqli_real_escape_string($link, $_POST['descs']);
    $points = intval($_POST['points']);
    $images = $_POST['images'];
    
    // Handle image upload
    if (isset($_FILES['images']) && $_FILES['images']['error'] == UPLOAD_ERR_OK) {
        $imageTmpPath = $_FILES['images']['tmp_name'];
        $imageName = basename($_FILES['images']['name']);
        $uploadDir = 'images/';
        $destPath = $uploadDir . $imageName;

        if (move_uploaded_file($imageTmpPath, $destPath)) {
            $images = mysqli_real_escape_string($link, $imageName);
        } else {
            $errorMessage = "Error uploading the image file.";
            header("Location: admin_addGig.php?error=" . urlencode($errorMessage));
            exit();
        }
    } else {
        $images = 'none.png';  // Default image if no image uploaded
    }

    // Get the highest existing eventID from the database
    $query = "SELECT MAX(eventID) AS maxeventID FROM events";
    $result = mysqli_query($link, $query);
    $row = mysqli_fetch_assoc($result);
    $maxeventID = $row['maxeventID'];

    // Increment the highest eventID by 1 to get the new eventID
    $neweventID = $maxeventID + 1;

    // Insert the new offer into the database
    $insertQuery = "INSERT INTO events (eventID, title, dateTimeStart, dateTimeEnd, locations, descs, points, images) 
                    VALUES ('$neweventID', '$title', '$dateTimeStart', '$dateTimeEnd', '$locations', '$descs', '$points', '$images')";
    if (mysqli_query($link, $insertQuery)) {
        $message = "Gig added successfully.";
    } else {
        $errorMessage = "Error adding gig: " . mysqli_error($link);
    }
}

// Redirect back to the form page with a success or error message
if (isset($message)) {
    header("Location: admin_addGig.php?message=" . urlencode($message));
} elseif (isset($errorMessage)) {
    header("Location: admin_addGig.php?error=" . urlencode($errorMessage));
} else {
    header("Location: admin_addGig.php");
}
exit();
?>
