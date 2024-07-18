<?php
include "dbFunctions.php";
session_start();
include "ft.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Add Gigs</title>
    <link rel="stylesheet" type="text/css" href="volunteeradminstyle.css">
</head>

<body>
    <br>
    <?php include "admin_volunteerNavbar.php"; ?>
    <br><br>
    <div class="addgig-container">
        <h2>Add Gigs</h2>
        <?php if (isset($_GET['error'])): ?>
            <p>Error: <?php echo htmlspecialchars($_GET['error']); ?></p>
        <?php endif; ?>
        <?php if (isset($_GET['message'])): ?>
            <p><?php echo htmlspecialchars($_GET['message']); ?></p>
        <?php endif; ?>
        <form method="post" action="admin_doAddGig.php" enctype="multipart/form-data">
            <label>Title:</label>
            <input type="text" name="title" required>
            <label>Date Time Start:</label>
            <input type="datetime-local" name="dateTimeStart" required>
            <label>Date Time End:</label>
            <input type="datetime-local" name="dateTimeEnd" required>
            <label>Locations:</label>
            <input type="text" name="locations" required>
            <label>Event Description:</label>
            <input type="text" name="descs" required>
            <label>Points:</label>
            <input type="number" name="points" min="0" required>
            <label>Event Image:</label>
            <input type="file" name="images" accept="image/*">
            <br><br>
            <input type="submit" value="Add Gig">
        </form>
    </div>
</body>

</html>
