<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Scanning Page</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="qr-page">
    <?php include "vol_navbar.php"; ?>
    <div class="qr-container">
        <h1 class="qr-top-text">SCAN QR</h1>
        <div class="qr-section">
            <div id="qr-scanner"></div>
        </div>
        <h1 class="qr-bottom-text">HERE</h1>
        <?php if (isset($_GET['error'])): ?>
            <p class="error-message">
                <?php
                switch ($_GET['error']) {
                    case 'not_logged_in':
                        echo "You must be logged in to scan QR codes.";
                        break;
                    case 'invalid_event_id':
                        echo "Invalid event ID.";
                        break;
                    case 'event_not_found':
                        echo "Event not found.";
                        break;
                    case 'volunteer_not_found':
                        echo "Volunteer not found.";
                        break;
                    case 'update_failed':
                        echo "Failed to update points.";
                        break;
                    default:
                        echo "An unknown error occurred.";
                        break;
                }
                ?>
            </p>
        <?php endif; ?>
    </div>
    <script src="html5-qrcode.min.js"></script>
    <script src="script.js"></script>
</body>
</html>
