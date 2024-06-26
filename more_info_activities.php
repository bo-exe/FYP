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
            margin: 0;
            padding: 0;
        }
        .navbar {
            margin-bottom: 0; /* Remove any existing bottom margin */
        }
        .event-details-container {
            padding: 20px;
            max-width: 1200px;
            margin: 100px auto 0 auto; /* Add margin-top to create space below the navbar */
        }
        .event-header {
            text-align: left;
            margin-bottom: 20px;
        }
        .event-content {
            display: flex;
            gap: 20px;
        }
        .event-image {
            flex: 1;
            max-width: 40%;
        }
        .event-image img {
            width: 100%;
            border-radius: 5px;
        }
        .event-info {
            flex: 2;
            max-width: 60%;
        }
        .event-info p {
            margin-bottom: 10px;
        }
        .text-center {
            text-align: center;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
            padding: 10px 20px;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        footer {
            margin-top: 100px; /* Adjust this value to create space above the footer */
        }
    </style>
</head>
<body>
<?php include "navbar.php"; ?>

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
        <div class="event-header">
            <h1><?php echo htmlspecialchars($event['title']); ?></h1>
        </div>
        <div class="event-content">
            <div class="event-image">
                <img src="https://placehold.co/600" alt="<?php echo htmlspecialchars($event['title']); ?>">
            </div>
            <div class="event-info">
                <p><strong>Description:</strong> <?php echo htmlspecialchars($event['descs']); ?></p>
                <p><strong>Date and Time Start:</strong> <?php echo htmlspecialchars($event['dateTimeStart']); ?></p>
                <p><strong>Date and Time End:</strong> <?php echo htmlspecialchars($event['dateTimeEnd']); ?></p>
                <p><strong>Location:</strong> <?php echo htmlspecialchars($event['locations']); ?></p>
                <p><strong>Points:</strong> <?php echo htmlspecialchars($event['points']); ?></p>
                <div class="text-center mt-4">
                    <a href="signup_activities.php?eventID=<?php echo $eventID; ?>"><button class="btn btn-primary">Apply Now</button></a>
                </div>
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


