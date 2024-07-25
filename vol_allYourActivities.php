<?php
// Include your database connection file
include 'dbFunctions.php';

// Assume you have a session to get the current volunteer's ID
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$volunteerID = $_SESSION['volunteerId'];

// Redirect to home page if not logged in
if (!isset($_SESSION['volunteerId'])) {
    header("Location: index.php");
    exit();
}
// Fetch events for the current volunteer
$query = "
    SELECT e.eventID, e.title, e.dateTimeStart, e.dateTimeEnd, e.locations, e.descs, e.points
    FROM events e
    JOIN event_volunteers ev ON e.eventID = ev.eventID
    WHERE ev.volunteerID = ?
    ORDER BY e.dateTimeStart ASC
";
$stmt = $link->prepare($query);
$stmt->bind_param("i", $volunteerID);
$stmt->execute();
$result = $stmt->get_result();

$events = [];
while ($row = $result->fetch_assoc()) {
    $events[] = [
        'id' => $row['eventID'],
        'title' => $row['title'],
        'start' => $row['dateTimeStart'],
        'end' => $row['dateTimeEnd'],
        'description' => $row['descs'],
        'location' => $row['locations'],
        'points' => $row['points']
    ];
}

$stmt->close();
$link->close();

// Encode events to JSON
$json_events = json_encode($events);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Your Activities</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.10.1/main.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .calendar-container, .activity-list {
            max-width: 900px;
            margin: auto;
            padding: 20px;
        }
        .activity-list {
            margin-top: 20px;
        }
        .activity-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 10px;
            cursor: pointer;
        }
        .activity-item:hover {
            background-color: #f0f0f0;
        }
    </style>
</head>
<body>
    <?php // include "vol_navbar.php"; ?>
    <div class="calendar-container">
        <div id="calendar"></div>
    </div>

    <div class="activity-list">
        <h3>Activities</h3>
        <?php foreach ($events as $event) { ?>
            <div class="activity-item" onclick="location.href='vol_cancelActivity.php?eventID=<?php echo $event['id']; ?>'">
                <div>
                    <strong><?php echo $event['title']; ?></strong><br>
                    <?php echo date('l, d M Y g:i A', strtotime($event['start'])); ?> - <?php echo date('g:i A', strtotime($event['end'])); ?>
                </div>
            </div>
        <?php } ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.14/index.global.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var events = <?php echo $json_events; ?>;

            var calendar = new FullCalendar.Calendar(calendarEl, {
                timeZone: 'UTC',
                initialView: 'dayGridMonth',
                events: events,
                editable: true,
                selectable: true
            });

            calendar.render();
        });
    </script>
</body>
</html>
