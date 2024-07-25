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
            margin: 0;
            padding: 0;
            font-family: 'Lato', sans-serif;
            background-color: #f8f8f8;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .card {
            background-color: #fff;
            border-radius: 10px; /* Increased border-radius for a more rounded look */
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1); /* Increased shadow for more emphasis */
            padding: 30px; /* Increased padding for more space */
            width: 600px; /* Increased width of the card */
            max-width: 90%;
            position: relative;
        }

        .card img {
            width: 100%;
            height: auto;
            border-radius: 10px; /* Increased border-radius for the image */
            margin-bottom: 15px; /* Increased bottom margin */
        }

        .card h2 {
            margin: 0 0 15px 0; /* Added margin below the heading */
            font-size: 24px; /* Increased font size of the heading */
        }

        .card p {
            margin-bottom: 10px; /* Increased bottom margin for paragraphs */
            font-size: 16px; /* Increased font size for better readability */
        }

        .apply-button {
            text-align: center;
            margin-top: 2rem; /* Increased top margin */
        }

        .btn-primary {
            background-color: #FFD036;
            color: #333;
            border: none;
            padding: 15px 30px; /* Increased padding for a larger button */
            border-radius: 30px; /* Kept same rounded corners */
            font-weight: bold;
            text-align: center;
            transition: background-color 0.3s ease;
            text-decoration: none;
            font-size: 18px; /* Increased font size */
        }

        .btn-primary:hover {
            background-color: #e6bb2e;
        }

        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }
            
            .card {
                width: 100%; /* Make the card full width on smaller screens */
                padding: 20px; /* Adjusted padding for smaller screens */
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
            <div class="card">
                <img src="data:image/jpeg;base64,<?php echo $image_data; ?>" alt="<?php echo htmlspecialchars($event['title']); ?>-image">
                <h2><?php echo htmlspecialchars($event['title']); ?></h2>
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
        echo "<div class='container'><p>Event not found.</p></div>";
    }
    ?>

    <?php include "vol_footer.php"; ?>
</body>
</html>
