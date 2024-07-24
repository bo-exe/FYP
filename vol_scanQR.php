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
    </div>
    <script src="html5-qrcode.min.js"></script>
    <script src="script.js"></script>
</body>
</html>
