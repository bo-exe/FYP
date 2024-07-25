<?php
session_start();
include "dbFunctions.php";
include "ft.php";
include "phpqrcode/qrlib.php"; // Ensure path is correct

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize form data
    $title = mysqli_real_escape_string($link, $_POST['title']);
    $dateTimeStart = mysqli_real_escape_string($link, $_POST['dateTimeStart']);
    $dateTimeEnd = mysqli_real_escape_string($link, $_POST['dateTimeEnd']);
    $locations = mysqli_real_escape_string($link, $_POST['locations']);
    $descs = isset($_POST['descs']) ? mysqli_real_escape_string($link, $_POST['descs']) : '';
    $points = intval($_POST['points']);

    // Handle image upload
    if (isset($_FILES['images']) && $_FILES['images']['error'] == UPLOAD_ERR_OK) {
        $imageTmpPath = $_FILES['images']['tmp_name'];
        $imageType = $_FILES['images']['type'];

        // Check if the uploaded file is an image
        if ($imageType == 'image/jpeg' || $imageType == 'image/png' || $imageType == 'image/gif') {
            $imageData = addslashes(file_get_contents($imageTmpPath));  // Convert image to BLOB
        } else {
            $errorMessage = "Unsupported image format. Please upload JPEG, PNG, or GIF.";
            header("Location: admin_volCreate.php?error=" . urlencode($errorMessage));
            exit();
        }
    } else {
        $errorMessage = "No image uploaded.";
        header("Location: admin_volCreate.php?error=" . urlencode($errorMessage));
        exit();
    }

    // Retrieve adminID from session
    if (isset($_SESSION['adminID'])) {
        $adminID = $_SESSION['adminID'];
    } else {
        $errorMessage = "Admin session not found.";
        header("Location: admin_volCreate.php?error=" . urlencode($errorMessage));
        exit();
    }

    // Insert the new offer into the database
    $insertQuery = "INSERT INTO events (title, dateTimeStart, dateTimeEnd, locations, descs, points, images, adminID) 
                    VALUES ('$title', '$dateTimeStart', '$dateTimeEnd', '$locations', '$descs', '$points', '$imageData', '$adminID')";
    
    if (mysqli_query($link, $insertQuery)) {
        // Get the last inserted eventID
        $eventID = mysqli_insert_id($link);

        // Generate QR code
        $qrData = "Event ID: $eventID";
        $qrFileName = 'qrcodes/qr_' . $eventID . '.png'; // Save QR code image
        QRcode::png($qrData, $qrFileName, QR_ECLEVEL_L, 4);

        // Save QR code path to the database
        $qrFileData = addslashes(file_get_contents($qrFileName));
        $qrInsertQuery = "INSERT INTO qr (qrImage, eventID) VALUES ('$qrFileData', '$eventID')";
        mysqli_query($link, $qrInsertQuery);

        $message = "Gig added and QR code generated successfully.";
        header("Location: admin_volDoCreate.php?message=" . urlencode($message));
        exit();
    } else {
        $errorMessage = "Error adding gig: " . mysqli_error($link);
        header("Location: admin_volCreate.php?error=" . urlencode($errorMessage));
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Add Offer</title>
    <style>
        body {
            background-color: #f4f4f4;
        }

        .container {
            margin-top: 50px;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 0 auto;
        }
        .message {
            margin-bottom: 20px;
            font-size: 18px;
        }
        .back-link {
            display: inline-block;
            padding: 10px 20px;
            background-color: #FFD036;
            margin-left: 15px;
            margin-top: 20px;
            text-decoration: none;
            color: #fff;
            border-radius: 30px;
            font-weight: bold;
        }
        .back-link:hover {
            background-color: #FFC300;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        form {
            margin-top: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }

        input[type="text"],
        input[type="datetime-local"],
        input[type="number"],
        input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #FFD036;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #E7BC32;
        }

        .error {
            color: red;
        }
    </style>
</head>
<body>
    <?php include "admin_volunteerNavbar.php"; ?>
    <div class="container">
        <h2>Add Gig</h2>
        <?php if (isset($errorMessage)): ?>
            <p class="error">Error: <?php echo $errorMessage; ?></p>
        <?php endif; ?>
        <?php if (isset($message)): ?>
            <p><?php echo $message; ?></p>
            <p><a href="admin_volManage.php" class="back-link">Back to Gigs</a></p>
        <?php else: ?>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
                <label>Title:</label><br>
                <input type="text" name="title" required><br>
                <label>Date Time Start:</label><br>
                <input type="datetime-local" name="dateTimeStart" required><br>
                <label>Date Time End:</label><br>
                <input type="datetime-local" name="dateTimeEnd" required><br>
                <label>Locations:</label><br>
                <input type="text" name="locations" required><br>
                <label>Description:</label><br>
                <input type="text" name="descs" required><br>
                <label>Points:</label><br>
                <input type="number" name="points" required><br>
                <label>Image:</label><br>
                <input type="file" name="images" accept="image/jpeg, image/png, image/gif" required><br>
                <input type="submit" value="Add Gig">
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
