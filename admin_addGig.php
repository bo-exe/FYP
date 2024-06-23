<!-- <?php
include "dbFunctions.php";
session_start();
include "ft.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $title = $_POST['title'];
    $dateTimeStart = $_POST['dateTimeStart'];
    $dateTimeEnd = $_POST['dateTimeEnd'];
    $location = $_POST['location'];
    $desc = $_POST['desc'];
    $points = $_POST['points'];
    $images = $_POST['eventImage'];

    // Get the highest existing eventID from the database
    $query = "SELECT MAX(eventID) AS maxeventID FROM events";
    $result = mysqli_query($link, $query);
    $row = mysqli_fetch_assoc($result);
    $maxeventID = $row['maxeventID'];

    // Increment the highest eventID by 1 to get the new eventID
    $neweventID = $maxeventID + 1;

    // Insert the new offer into the database
    $insertQuery = "INSERT INTO events (eventID, title, dateTimeStart, dateTimeEnd, location, desc, points, images) 
                    VALUES ('$neweventID', '$title', '$dateTimeStart', '$dateTimeEnd', '$location', '$points', '$desc', '$images')";
    if (mysqli_query($link, $insertQuery)) {
        $message = "Gig added successfully.";
    } else {
        $errorMessage = "Error adding Gig: " . mysqli_error($link);
    }
}
?> -->
<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Add Gigs</title>
</head>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
    }

    .container {
        max-width: 500px;
        margin: 20px auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    h2 {
        text-align: center;
        color: #333;
    }

    form {
        margin-top: 20px;
    }

    label {
        display: block;
        margin-bottom: 5px;
        color: #333;
    }

    input[type="text"],
    input[type="datetime-local"],
    input[type="number"],
    input[type="file"] {
        width: 100%;
        padding: 10px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-sizing: border-box;
    }

    input[type="submit"] {
        background-color: #FFD036;
        color: #fff;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    input[type="submit"]:hover {
        background-color: #E7BC32;
    }
</style>
<br>
<?php include "admin_volunteerNavbar.php"; ?>
<br></br>
<div class="container">
    <h2>Add Gigs</h2>
    <?php if (isset($errorMessage)): ?>
        <p>Error: <?php echo $errorMessage; ?></p>
    <?php endif; ?>
    <?php if (isset($message)): ?>
        <p><?php echo $message; ?></p>
    <?php else: ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
            <label>Title:</label><br>
            <input type="text" name="title" required><br>
            <label>Date Time Start:</label><br>
            <input type="datetime-local" name="dateTimeStart" required><br>
            <label>Date Time End:</label><br>
            <input type="datetime-local" name="dateTimeEnd" required><br>
            <label>Locations:</label><br>
            <input type="text" name="location" required><br>
            <label>Event Description:</label><br>
            <input type="text" name="desc" required><br>
            <label>Points:</label><br>
            <input type="number" name="points" min="0" required><br>
            <label>Event Image:</label><br>
            <input type="file" name="eventImage" accept="images/" required><br><br>
            <input type="submit" value="Add Gig">
        </form>
    <?php endif; ?>
</div>
</body>

</html>
