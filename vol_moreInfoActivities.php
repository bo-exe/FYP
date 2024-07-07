<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Details</title>
    <link rel="stylesheet" href="style.css">
    <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet'>
    <link rel="icon" type="image/x-icon" href="images/logo.jpg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: 'Lato', sans-serif;
            background-color: #f0f2f5;
        }
        .event-details-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            display: flex;
            align-items: flex-start; /* Align items at the top */
        }
        .event-details {
            flex: 1; /* Take remaining space */
            padding-left: 20px; /* Space between image and details */
        }
        .event-details h1 {
            font-size: 2rem;
            margin-bottom: 10px;
        }
        .event-details p {
            margin-bottom: 10px;
        }
        .event-details img {
            max-width: 100%;
            height: auto;
        }
        .text-center {
            text-align: center;
        }
        .btn {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }
        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <?php include "vol_navbar.php"; ?>

    <div class="event-details-container">
        <?php
        include "dbFunctions.php";

        // Get the eventID from the URL parameter
        $eventID = isset($_GET['eventID']) ? intval($_GET['eventID']) : 0;

        // Query to fetch event with the specified eventID
        $query = "SELECT * FROM events WHERE eventID = $eventID";
        $result = mysqli_query($link, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $event = mysqli_fetch_assoc($result);
            ?>
            <div>
                <img src="https://placehold.co/600" alt="<?php echo htmlspecialchars($event['title']); ?>">
            </div>
            <div class="event-details">
                <h1><?php echo htmlspecialchars($event['title']); ?></h1>
                <p><strong>Date and Time Start:</strong> <?php echo htmlspecialchars($event['dateTimeStart']); ?></p>
                <p><strong>Date and Time End:</strong> <?php echo htmlspecialchars($event['dateTimeEnd']); ?></p>
                <p><strong>Location:</strong> <?php echo htmlspecialchars($event['locations']); ?></p>
                <p><strong>Description:</strong> <?php echo htmlspecialchars($event['descs']); ?></p>
                <p><strong>Points:</strong> <?php echo htmlspecialchars($event['points']); ?></p>
                <div class="text-center mt-4">
                    <a href="vol_signUpActivities.php?eventID=<?php echo $eventID; ?>" class="btn">Apply Now</a>
                </div>
            </div>
            <?php
        } else {
            echo "<p>Event not found.</p>";
        }
        ?>
    </div>

    <?php include "footer.php"; ?>
</body>
</html>
