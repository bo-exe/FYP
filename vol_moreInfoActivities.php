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
        body {
            font-family: 'Lato', sans-serif;
        }

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

        .container {
            display: flex;
            flex-wrap: wrap;
            padding: 20px;
        }

        .image-container,
        .details-container {
            padding: 20px;
            box-sizing: border-box;
        }

        .image-container {
            width: 100%;
            text-align: center;
        }

        .image-container img {
            width: 100%;
            max-width: 100%;
            height: auto;
        }

        .details-container {
            width: 100%;
        }

        .details-container p {
            margin: 10px 0;
        }

        .apply-button {
            text-align: center;
            margin-top: 1.5rem;
        }

        @media (min-width: 768px) {
            .image-container {
                width: 40%;
            }

            .details-container {
                width: 60%;
                display: flex;
                flex-direction: column;
                justify-content: center;
            }
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
        // Fetch the image data from the 'images' column
        $image_data = base64_encode($event['images']); 
        ?>
        <div class="container">
            <div class="image-container">
                <h1><?php echo htmlspecialchars($event['title']); ?></h1>
                <!-- Use the base64-encoded image data -->
                <img src="data:image/jpeg;base64,<?php echo $image_data; ?>" alt="<?php echo htmlspecialchars($event['title']); ?>-image">
            </div>
            <div class="details-container">
                <p><strong>Date and Time Start:</strong> <?php echo htmlspecialchars($event['dateTimeStart']); ?></p>
                <p><strong>Date and Time End:</strong> <?php echo htmlspecialchars($event['dateTimeEnd']); ?></p>
                <p><strong>Location:</strong> <?php echo htmlspecialchars($event['locations']); ?></p>
                <p><strong>Description:</strong> <?php echo htmlspecialchars($event['descs']); ?></p>
                <p><strong>Points:</strong> <?php echo htmlspecialchars($event['points']); ?></p>
                <div class="apply-button">
                    <a href="vol_signUpActivities.php?eventID=<?php echo $eventID; ?>&volunteerID=<?php echo $volunteerID; ?>">
                        <button class="btn-primary">
                            Apply Now
                        </button>
                    </a>
                </div>
            </div>
        </div>
        <?php
    } else {
        echo "<p>Event not found.</p>";
    }
    ?>

    <?php include "vol_footer.php"; ?>
</body>
</html>
