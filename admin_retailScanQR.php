<?php
session_start();
include "dbFunctions.php";
include "admin_retailNavbar.php";
include "ft.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Scanning Page</title>
    <link rel="stylesheet" href="style.css">
</head>
<style>
    * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Body styles */
body {
    background-color: #f0f0f0;
}

/* Container styles */
.qr-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 100vh;
    padding: 20px;
}

/* Heading styles */
.qr-container h1 {
    font-size: 2em;
    margin-bottom: 20px;
    color: #333;
}

/* QR section styles */
.qr-section {
    width: 300px;
    height: 300px;
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    display: flex;
    justify-content: center;
    align-items: center;
}

/* QR scanner element styles */
#qr-scanner {
    width: 100%;
    height: 100%;
}

.qr-container .btn {
    display: inline-block;
    padding: 10px 20px;
    background-color: #007bff;
    color: #fff;
    text-decoration: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.qr-container .btn:hover {
    background-color: #0056b3;
}

/* Responsive adjustments */
@media (max-width: 600px) {
    .qr-section {
        width: 80%;
        height: 80%;
    }
}
</style>
<body>
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