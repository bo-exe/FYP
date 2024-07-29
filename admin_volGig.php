<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($eventData['title']); ?></title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php include "admin_volunteerNavBar.php"; ?>
    <?php include "ft.php"; ?>

    <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
    <div class="container">
        <div class="card">
            <img src="<?php echo htmlspecialchars($imageSrc); ?>" alt="<?php echo htmlspecialchars($eventData['title']); ?>">
            <h2><?php echo htmlspecialchars($eventData['title']); ?></h2>
            <p><b>Start Date:</b> <?php echo htmlspecialchars($eventData['dateTimeStart']); ?></p>
            <p><b>End Date:</b> <?php echo htmlspecialchars($eventData['dateTimeEnd']); ?></p>
            <p><b>Locations:</b> <?php echo htmlspecialchars($eventData['locations']); ?></p>
            <p><b>Event Description:</b> <?php echo htmlspecialchars($eventData['descs']); ?></p>
            <p><b>Points:</b> <?php echo htmlspecialchars($eventData['points']); ?></p>
            <a href="admin_retailDelete.php?eventID=<?php echo htmlspecialchars($eventData['eventID']); ?>" class="del-btn">Delete</a>
            <a href="admin_retailEdit.php?eventID=<?php echo htmlspecialchars($eventData['eventID']); ?>" class="edit-btn">Edit</a>

            <!-- QR Code Generator Section -->
            <div class="wrapper">
                <header>
                    <h1>QR Code Generator</h1>
                    <p>Paste a URL or enter text to create a QR code</p>
                </header>
                <div class="form">
                    <input type="text" spellcheck="false" placeholder="Enter text or URL" id="qrInput">
                    <button onclick="generateQRCode()">Generate QR Code</button>
                </div>
                <div class="qr-code">
                    <img id="qrImage" src="" alt="QR Code">
                </div>
            </div>
        </div>
    </div>

    <?php include "admin_footer.php"; ?>
    <script src="script.js"></script>
</body>

</html>
