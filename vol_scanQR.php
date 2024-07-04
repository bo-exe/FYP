<?php
session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Scanning Page</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include "vol_navbar.php"; ?>
    <div class="qr-container">
        <h1>Scan QR Codes</h1>
        <div class="qr-section">
            <div id="qr-scanner"></div>
        </div>
    </div>
    <script src="html5-qrcode.min.js"></script>
    <script src="script.js"></script>
</body>
</html>
