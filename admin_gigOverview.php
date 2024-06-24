<?php
include "dbFunctions.php";
session_start();

// Ensure eventID is set and numeric
if (!isset($_GET['eventID']) || !is_numeric($_GET['eventID'])) {
    echo "Invalid event ID.";
    exit();
}

$eventID = $_GET['eventID'];

$query = "SELECT * FROM events WHERE eventID = ?";
$stmt = $link->prepare($query);
$stmt->bind_param("i", $eventID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    $eventData = $result->fetch_assoc();

    // Retrieve BLOB data and convert to base64 encoded string
    $imageData = base64_encode($eventData['images']);
    $imageSrc = 'data:image/jpeg;base64,' . $imageData;
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
    <title>Manage Gigs</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <style>
        .event-card-container {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 20px;
        }

        .event-card {
            width: 325px;
            background-color: #ECECE7;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.2);
            margin: 20px;
            height: auto;
            text-decoration: none;
            color: inherit;
            position: relative;
        }

        .event-card img {
            width: 100%;
            height: 165px;
            object-fit: cover;
        }

        .event-card-content {
            padding: 15px;
        }

        .event-card-content h2 {
            font-size: 28px;
            margin-bottom: 10px;
            margin-top: 10px;
            text-align: center;
            /* Center align the title */
        }

        .event-card-content p {
            color: #333333;
            font-size: 15px;
            line-height: 1.3;
            margin-bottom: 10px;
        }

        .event-card-content .del-btn {
            display: inline-block;
            padding: 8px 16px;
            background-color: #EF1E1E;
            text-decoration: none;
            border-radius: 30px;
            margin-top: 16px;
            color: #FFF5F5;
            font-weight: bold;
            margin-left: 10px;
            margin-bottom: 10px;
        }

        .event-card-content .edit-btn {
            display: inline-block;
            padding: 8px 16px;
            background-color: #FFD036;
            text-decoration: none;
            border-radius: 30px;
            margin-top: 16px;
            margin-left: 110px;
            margin-bottom: 10px;
            color: #FFF5F5;
            font-weight: bold;
        }

        .add-btn {
            display: inline-block;
            padding: 8px 16px;
            background-color: #BFB7B7;
            text-decoration: none;
            border-radius: 30px;
            color: #FFF5F5;
            font-weight: bold;
            margin-top: 20px;
        }

        .add-btn-container {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <?php include "admin_volunteerNavBar.php"; ?>
    <?php include "ft.php"; ?>

    <div class="event-card-container">
        <div class="event-card">
            <br>
            <h1 style="text-align: center;"><?php echo $eventData['title'] ?></h1>
            <br>
            <img src="<?php echo $imageSrc; ?>" alt="<?php echo $eventData['title']; ?>" class="card-img-top">
            <div class="event-card-content">
                <p class="card-text"><b>Start Date:</b> <?php echo $eventData['dateTimeStart']; ?></p>
                <p class="card-text"><b>End Date:</b> <?php echo $eventData['dateTimeEnd']; ?></p>
                <p class="card-text"><b>Locations:</b> <?php echo $eventData['locations']; ?></p>
                <p class="card-text"><b>Event Description:</b> <?php echo $eventData['descs']; ?></p>
                <p class="card-text"><b>Points:</b> <?php echo $eventData['points']; ?></p>
            </div>
            <div class="event-card-content">
                <a href="admin_retailDelete.php?eventID=<?php echo $eventData['eventID']; ?>" class="del-btn">Delete</a>
                <a href="admin_retailEdit.php?eventID=<?php echo $eventData['eventID']; ?>" class="edit-btn">Edit</a>
            </div>
        </div>
    </div>

    <?php include "admin_footer.php"; ?>
</body>

</html>