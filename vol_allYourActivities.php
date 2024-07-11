<?php
// Include your database connection file
include 'dbFunctions.php';

// Assume you have a session to get the current volunteer's ID
session_start();
$volunteerID = $_SESSION['volunteerId'];

// Fetch events for the current volunteer
$query = "
    SELECT e.eventID, e.title, e.dateTimeStart, e.dateTimeEnd, e.locations, e.descs, e.points, e.images
    FROM events e
    JOIN event_volunteers ev ON e.eventID = ev.eventID
    WHERE ev.volunteerID = ?
    ORDER BY e.dateTimeStart ASC
";
$stmt = $link->prepare($query); // Use $link instead of $conn
$stmt->bind_param("i", $volunteerID);
$stmt->execute();
$result = $stmt->get_result();

$events = [];
while ($row = $result->fetch_assoc()) {
    $events[] = [
        'title' => $row['title'],
        'start' => $row['dateTimeStart'],
        'end' => $row['dateTimeEnd'],
        // Additional fields can be added here if needed
    ];
}

$stmt->close();
$link->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Your Activities</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .calendar-container {
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
        }
    </style>
</head>
<body>
    <div class="calendar-container">
        <div id="calendar"></div>
    </div>

    <div class="activity-list">
        <h3>Activities</h3>
        <?php foreach ($events as $event) { ?>
            <div class="activity-item">
                <div>
                    <strong><?php echo $event['title']; ?></strong><br>
                    <?php echo date('m/d/Y g:i A', strtotime($event['start'])); ?> - <?php echo date('g:i A', strtotime($event['end'])); ?>
                </div>
            </div>
        <?php } ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.14/index.global.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                timeZone: 'UTC',
                initialView: 'dayGridMonth',
                events: <?php echo json_encode($events); ?>,
                editable: true,
                selectable: true
            });

            calendar.render();
        });
    </script>
</body>
</html>
