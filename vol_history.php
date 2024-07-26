<?php
// Include your database connection file
include 'dbFunctions.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['volunteerId'])) {
    header("Location: index.php");
    exit();
}

$volunteerID = $_SESSION['volunteerId'];

// Fetch redeemed vouchers
$query = "
    SELECT rv.redeemed_date, o.title AS offerTitle, o.points AS offerPoints
    FROM redeemed_vouchers rv
    JOIN offers o ON rv.offerId = o.offerId
    WHERE rv.volunteerId = ? AND rv.redeem = 'used'
    ORDER BY rv.redeemed_date DESC
";
$stmt = $link->prepare($query); // Use $link instead of $conn
$stmt->bind_param('i', $volunteerID);
$stmt->execute();
$result_vouchers = $stmt->get_result();

// Fetch completed activities
$query = "
    SELECT ev.registration_date, e.title AS eventTitle, e.points AS eventPoints
    FROM event_volunteers ev
    JOIN events e ON ev.eventID = e.eventID
    WHERE ev.volunteerID = ? AND ev.status = 'completed'
    ORDER BY ev.registration_date DESC
";
$stmt = $link->prepare($query); // Use $link instead of $conn
$stmt->bind_param('i', $volunteerID);
$stmt->execute();
$result_activities = $stmt->get_result();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My History</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.10.1/main.min.css">
    <style>
        /* Add your styles here */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .history-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 10px;
            margin-bottom: 10px;
        }
        .history-item.completed {
            border-left: 5px solid green;
        }
        .history-item.redeemed {
            border-left: 5px solid red;
        }
        .history-item .details {
            flex: 1;
            margin-left: 10px;
        }
        .history-item .points {
            font-weight: bold;
        }
        .history-item .date {
            font-size: 0.9em;
            color: #888;
        }
    </style>
</head>
<body>
    <?php include "vol_navbar.php"; ?>
    
    <div class="container">
        <h2>My History</h2>
        
        <?php while($row = $result_vouchers->fetch_assoc()): ?>
            <div class="history-item redeemed">
                <div class="details">
                    <div class="title">Voucher Redemption</div>
                    <div class="description"><?= htmlspecialchars($row['offerTitle']) ?></div>
                    <div class="date"><?= date('m/d/Y', strtotime($row['redeemed_date'])) ?></div>
                </div>
                <div class="points">-<?= $row['offerPoints'] ?> Points</div>
            </div>
        <?php endwhile; ?>
        
        <?php while($row = $result_activities->fetch_assoc()): ?>
            <div class="history-item completed">
                <div class="details">
                    <div class="title">Activity Completion</div>
                    <div class="description"><?= htmlspecialchars($row['eventTitle']) ?></div>
                    <div class="date"><?= date('m/d/Y', strtotime($row['registration_date'])) ?></div>
                </div>
                <div class="points">+<?= $row['eventPoints'] ?> Points</div>
            </div>
        <?php endwhile; ?>
        
    </div>
    
    <?php include "vol_footer.php"; ?>
</body>
</html>
