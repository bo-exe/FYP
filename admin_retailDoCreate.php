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
            header("Location: admin_retailCreate.php?error=" . urlencode($errorMessage));
            exit();
        }
    } else {
        $errorMessage = "No image uploaded.";
        header("Location: admin_retailCreate.php?error=" . urlencode($errorMessage));
        exit();
    }

    // Get adminID from session (assuming you store it in session after login)
    $adminID = $_SESSION['adminID']; // Adjust according to your session variable name

    // Insert the new offer into the database
    $insertQuery = "INSERT INTO offers (title, dateTimeStart, dateTimeEnd, locations, tandc, points, amount, images, adminID) 
                    VALUES ('$title', '$dateTimeStart', '$dateTimeEnd', '$locations', '$tandc', '$points', '$amount', '$images', '$adminID')";
    
    if (mysqli_query($link, $insertQuery)) {
        $message = "Offer added successfully.";
    } else {
        $errorMessage = "Error adding offer: " . mysqli_error($link);
    }
}

// Redirect back to the form page with a success or error message
if (isset($message)) {
    header("Location: admin_retailCreate.php?message=" . urlencode($message));
} elseif (isset($errorMessage)) {
    header("Location: admin_retailCreate.php?error=" . urlencode($errorMessage));
} else {
    header("Location: admin_retailCreate.php");
}
exit();
?>
