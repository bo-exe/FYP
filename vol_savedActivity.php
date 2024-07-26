<?php
// Include the file that contains the common database connection code
include "dbFunctions.php";

// Start session if it is not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['volunteerId']) || empty($_SESSION['volunteerId'])) {
    echo "User not logged in.";
    exit();
}

$volunteerID = $_SESSION['volunteerId'];

// Fetch saved activities for the logged-in volunteer
$query = "
    SELECT e.eventID, e.title, e.dateTimeStart, e.dateTimeEnd, e.locations, e.descs, e.points, e.images
    FROM saved_activity sa
    JOIN events e ON sa.eventID = e.eventID
    WHERE sa.volunteerID = ?
    ORDER BY sa.saved_date DESC
";

$stmt = mysqli_prepare($link, $query);
mysqli_stmt_bind_param($stmt, 'i', $volunteerID);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Fetch the results
$saved_activities = [];
while ($row = mysqli_fetch_assoc($result)) {
    $saved_activities[] = $row;
}

// Free result and close connection
mysqli_free_result($result);
mysqli_close($link);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Saved Activities</title>
        <link rel="icon" type="image/x-icon" href="images/logo.jpg">
        <link rel="stylesheet" href="style.css">
        <style>
            .saved-activity-page h1 {
                margin-top: 100px;
                text-align: center;
            }
            .activities-container {
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
                max-width: 1200px;
                margin: auto;
                padding: 50px 0;
            }
            .activity-card {
                border: 1px solid #ddd;
                border-radius: 4px;
                padding: 10px;
                margin: 10px;
                text-align: center;
                flex: 1 0 300px; /* Add this to control the width of the cards */
                max-width: 400px; /* Add this to control the maximum width of the cards */
            }
            .activity-card img {
                max-width: 100%;
                height: auto;
            }
            .activity-card h3 {
                margin: 10px 0;
            }
            .activity-card p {
                margin: 5px 0;
            }
            .points {
                font-size: 1.5em;
                font-weight: bold;
                color: #f39c12;
            }
            .more-container {
                margin: 25px 0;
            }
            .more-container a {
                text-decoration: none;
                padding: 0.3rem 0.7rem;
                background: #FFD036;
                border-radius: 0.6rem;
                box-shadow: 0 0.1rem 0.25rem #333;
                font-size: 0.8rem;
                color: #333;
                letter-spacing: 0.1rem;
                font-weight: 600;
                border: 0.2rem solid transparent;
                transition: 0.5s ease;
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

        .yellow-container .points-container {
            display: none;
        }

        @media screen and (max-width: 768px) {
            body {
                padding-bottom: 20px; 
                margin-bottom: 50px;
            }

            .saved-activity-page h1{
                display: none;
            }

            /* .saved-activity-page{
                padding-top: 25px;
            } */

            .yellow-container {
                display: block;
                width: 100%;
                text-align: center;
                padding: 10px 0;
            }

            .yellow-container h1, .yellow-container p {
                text-align: left;
                padding-left: 20px;
                display: block;
            }

            .header-section {
                display: none;
            }
        
                .home {
                    display: none;
                }
            }
        </style>
    </head>
    <body class="saved-activity-page">
        <?php include "vol_navbar.php"; ?>
        <div class="yellow-container">
        <h1>Saved Activities</h1>
        <br>
    </div>
        <h1>Saved Activities</h1>
        <div class="activities-container">
            <?php if (count($saved_activities) > 0): ?>
                <?php foreach ($saved_activities as $activity): ?>
                    <div class="activity-card">
                        <img src="data:image/jpeg;base64,<?= base64_encode($activity['images']) ?>" alt="<?= htmlspecialchars($activity['title']) ?>">
                        <h3><?= htmlspecialchars($activity['title']) ?></h3>
                       
                        <p class="points">
                            <?= htmlspecialchars($activity['points']) ?> VOMOPoints
                        </p>
                        <div class="more-container">
                            <a href="vol_moreInfoActivities.php?eventID=<?= $activity['eventID'] ?>&volunteerID=<?= $volunteerID ?>" class="btn btn-primary">More</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No saved activities found.</p>
            <?php endif; ?>
        </div>
        <?php include "vol_footer.php"; ?>
    </body>
</html>
