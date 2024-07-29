<?php
include "dbFunctions.php";
session_start();

// Ensure eventID is set and numeric
if (!isset($_GET['eventID']) || !is_numeric($_GET['eventID'])) {
    echo "Invalid event ID.";
    exit();
}

$eventID = $_GET['eventID'];

// Prepare and execute query to get event details
$query = "SELECT * FROM events WHERE eventID = ?";
$stmt = $link->prepare($query);
$stmt->bind_param("i", $eventID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    $eventData = $result->fetch_assoc();

    // Retrieve event image
    $imageData = base64_encode($eventData['images']);
    $imageSrc = 'data:image/jpeg;base64,' . $imageData;

    $qrStmt->close();
} else {
    echo "Gig not found.";
    exit();
}

$stmt->close();
$link->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($eventData['title']); ?></title>
    <style>
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .card {
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 400px;
        }

        .card img {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .expired {
            color: #EF1E1E;
            font-weight: bold;
            font-size: 18px;
        }

        .del-btn, .edit-btn {
            display: inline-block;
            padding: 10px 20px;
            margin: 5px;
            color: #fff;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
        }

        .del-btn {
            background-color: #EF1E1E;
        }

        .edit-btn {
            background-color: #007bff;
        }

        .qr-code-container {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <?php include "admin_teamNavBar.php"; ?>
    <?php include "ft.php"; ?>

    <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
    <div class="container">
        <div class="card">
            <img src="<?php echo htmlspecialchars($imageSrc); ?>" alt="<?php echo htmlspecialchars($eventData['title']); ?>">
            <h2><?php echo htmlspecialchars($eventData['title']); ?></h2>
            <p><b>Start Date:</b> <?php echo htmlspecialchars($eventData['dateTimeStart']); ?></p>
            <p><b>End Date:</b> <?php echo htmlspecialchars($eventData['dateTimeEnd']); ?></p>
            <p><b>Locations:</b> <?php echo htmlspecialchars($eventData['locations']); ?></p>
            <p><b>Event Description:</b> <?php echo htmlspecialchars($eventData['descs']); ?></p>
            <p><b>Points:</b> <?php echo htmlspecialchars($eventData['points']); ?></p>
            <div class="event-qr-code-container">
                <p><b>QR Code:</b></p>
                <img src="<?php echo htmlspecialchars($qrImageSrc); ?>" alt="QR Code for <?php echo htmlspecialchars($eventData['title']); ?>" style="width: 150px; height: 150px;">
            </div>
            <a href="admin_retailDelete.php?eventID=<?php echo htmlspecialchars($eventData['eventID']); ?>" class="del-btn">Delete</a>
            <a href="admin_retailEdit.php?eventID=<?php echo htmlspecialchars($eventData['eventID']); ?>" class="edit-btn">Edit</a>
        </div>
    </div>

    <?php include "admin_footer.php"; ?>
<script src="script.js"></script>
</body>

</html>
