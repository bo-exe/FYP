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
    
    // Handle image upload
    if (isset($_FILES['images']) && $_FILES['images']['error'] == UPLOAD_ERR_OK) {
        $imageTmpPath = $_FILES['images']['tmp_name'];
        $imageType = $_FILES['images']['type'];
        
        // Check if the uploaded file is an image
        if ($imageType == 'image/jpeg' || $imageType == 'image/png' || $imageType == 'image/gif') {
            $imageData = file_get_contents($imageTmpPath);
            $images = mysqli_real_escape_string($link, $imageData);
        } else {
            $errorMessage = "Unsupported image format. Please upload JPEG, PNG, or GIF.";
            header("Location: form.php?error=" . urlencode($errorMessage));
            exit();
        }
    } else {
        $errorMessage = "No image uploaded.";
        header("Location: form.php?error=" . urlencode($errorMessage));
        exit();
    }

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
