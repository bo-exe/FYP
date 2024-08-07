<?php
// Include your database connection file
include 'dbFunctions.php';

// Start session and get volunteer ID
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$volunteerID = $_SESSION['volunteerId'];

// Get eventID from query parameters
$eventID = $_GET['eventID'];

// Fetch event details
$query = "
    SELECT e.title, e.dateTimeStart, e.dateTimeEnd, e.locations, e.descs, e.points, e.images
    FROM events e
    WHERE e.eventID = ?
";
$stmt = $link->prepare($query);
$stmt->bind_param("i", $eventID);
$stmt->execute();
$result = $stmt->get_result();
$event = $result->fetch_assoc();
$stmt->close();

// Convert the image blob to a base64-encoded string
$imageData = base64_encode($event['images']);
$imageSrc = "data:image/jpeg;base64,{$imageData}";

// Handle cancellation
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $deleteQuery = "
        DELETE FROM event_volunteers
        WHERE eventID = ? AND volunteerID = ?
    ";
    $deleteStmt = $link->prepare($deleteQuery);
    $deleteStmt->bind_param("ii", $eventID, $volunteerID);
    $deleteStmt->execute();
    $deleteStmt->close();

    // Redirect to the activities page
    header("Location: vol_allYourActivities.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cancel Activity</title>
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
            margin-top: 100px;
            margin-bottom: 50px;
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
            background-color: red;
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

        .yellow-container {
            background-color: #FFD036;
            color: #333;
            text-align: left;
            padding: 15px;
            box-sizing: border-box;
            margin-bottom: 20px;
            display: none;
        }

        .yellow-container h1 {
            margin: 0;
            padding: 0;
            font-size: 24px;
            font-weight: bold;
            padding-left: 20px;
        }

        @media screen and (max-width: 768px) {
            body {
                padding-bottom: 20px; 
            }

            .yellow-container {
                display: block;
                width: 100%;
                text-align: center;
                padding: 10px 0;
            }

            .yellow-container h1, .yellow-container p {
                text-align: left;
                padding-left: 20px;
            }

            .header-section {
                display: none;
            }
        
            .home {
                display: none;
            }
              
            .container {
                padding: 20px;
                margin-top: -20px;
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
    <div class="yellow-container">
        <h1>Cancel Activity</h1>
        <br>
    </div>
    <div class="container">
        <div class="card">
            <img src="<?php echo $imageSrc; ?>" alt="Event Image">
            <h2><?php echo htmlspecialchars($event['title']); ?></h2>
            <p><strong>Date & Time:</strong> <?php echo date('l, d M Y g:i A', strtotime($event['dateTimeStart'])); ?> - <?php echo date('g:i A', strtotime($event['dateTimeEnd'])); ?></p>
            <p><strong>Location:</strong> <?php echo htmlspecialchars($event['locations']); ?></p>
            <p><strong>Description:</strong> <?php echo htmlspecialchars($event['descs']); ?></p>
            <p><strong>Points:</strong> <?php echo htmlspecialchars($event['points']); ?></p>
            <div class="apply-button">
                <form method="post">
                    <button type="submit" class="btn-primary">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

