<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Details</title>
    <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet'>
    <link rel="icon" type="image/x-icon" href="images/logo.jpg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .btn-primary {
            background-color: #FFD700;
            color: black;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 4px;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #e5c500;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }
    </style>
</head>
<body>
<?php include "vol_navbar.php"; ?>

<?php
include "dbFunctions.php";

// Get the eventID and volunteerID from the URL parameters
$eventID = isset($_GET['eventID']) ? intval($_GET['eventID']) : 0;
$volunteerID = isset($_GET['volunteerID']) ? intval($_GET['volunteerID']) : 0;

// Query to fetch event with the specified eventID
$query = "SELECT * FROM events WHERE eventID = $eventID";
$result = mysqli_query($link, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $event = mysqli_fetch_assoc($result);
    // Fetch the image URL from the 'images' column
    $image_src = htmlspecialchars($event['images']); 
    ?>
    <table style="width: 100%; padding: 20px;">
        <tr>
            <td style="width: 40%; padding: 20px; vertical-align: top;">
                <h1 style="text-align: center;"><?php echo htmlspecialchars($event['title']); ?></h1>
                <!-- Use the image source from the 'images' column -->
                <img src="<?php echo $image_src; ?>" class="card-img-top" alt="<?php echo htmlspecialchars($event['title']); ?>-image" style="width: 100%; max-width: 100%; height: auto;">
            </td>
            <td style="width: 60%; padding: 20px; vertical-align: middle;">
                <div style="display: flex; flex-direction: column; justify-content: center; height: 100%;">
                    <p><strong>Date and Time Start:</strong> <?php echo htmlspecialchars($event['dateTimeStart']); ?></p>
                    <p><strong>Date and Time End:</strong> <?php echo htmlspecialchars($event['dateTimeEnd']); ?></p>
                    <p><strong>Location:</strong> <?php echo htmlspecialchars($event['locations']); ?></p>
                    <p><strong>Description:</strong> <?php echo htmlspecialchars($event['descs']); ?></p>
                    <p><strong>Points:</strong> <?php echo htmlspecialchars($event['points']); ?></p>
                    <div style="text-align: center; margin-top: 1.5rem;">
                        <a href="vol_signUpActivities.php?eventID=<?php echo $eventID; ?>&volunteerID=<?php echo $volunteerID; ?>">
                            <button class="btn-primary">
                                Apply Now
                            </button>
                        </a>
                    </div>
                </div>
            </td>
        </tr>
    </table>
    <?php
} else {
    echo "<p>Event not found.</p>";
}
?>

<?php include "footer.php"; ?>
</body>
</html>



