<?php
include "dbFunctions.php"; // Adjust this to your actual database connection script
include "ft.php"; // Assuming this is your footer include
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize form data
    $title = mysqli_real_escape_string($link, $_POST['title']);
    $dateTimeStart = mysqli_real_escape_string($link, $_POST['dateTimeStart']);
    $dateTimeEnd = mysqli_real_escape_string($link, $_POST['dateTimeEnd']);
    $locations = mysqli_real_escape_string($link, $_POST['locations']);
    $tandc = mysqli_real_escape_string($link, $_POST['tandc']);
    $instructions = mysqli_real_escape_string($link, $_POST['instructions']);
    $points = intval($_POST['points']);
    $amount = floatval($_POST['amount']);
    $company = mysqli_real_escape_string($link, $_POST['company']);

    // Handle image upload
    if (isset($_FILES['images']) && $_FILES['images']['error'] == UPLOAD_ERR_OK) {
        $imageTmpPath = $_FILES['images']['tmp_name'];
        $imageType = $_FILES['images']['type'];
        
        // Check if the uploaded file is an image
        if ($imageType == 'image/jpeg' || $imageType == 'image/png' || $imageType == 'image/gif') {
            $imageData = addslashes(file_get_contents($imageTmpPath));  // Convert image to BLOB
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

    // Retrieve adminID from session
    if (isset($_SESSION['adminID'])) {
        $adminID = $_SESSION['adminID'];
    } else {
        $errorMessage = "Admin session not found.";
        header("Location: admin_retailCreate.php?error=" . urlencode($errorMessage));
        exit();
    }

    // Insert the new offer into the database
    $insertQuery = "INSERT INTO offers (title, dateTimeStart, dateTimeEnd, locations, tandc, instructions, points, amount, images, QR, adminID, company) 
                    VALUES ('$title', '$dateTimeStart', '$dateTimeEnd', '$locations', '$tandc', '$instructions', '$points', '$amount', '$imageData', '$qrData', '$adminID', '$company')";
    
    if (mysqli_query($link, $insertQuery)) {
        $message = "Offer added successfully.";
        header("Location: admin_retailManage.php?message=" . urlencode($message));
        exit();
    } else {
        $errorMessage = "Error adding offer: " . mysqli_error($link);
        header("Location: admin_retailDoCreate.php?error=" . urlencode($errorMessage));
        exit();
    }
}
?>
