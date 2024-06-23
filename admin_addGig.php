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
</head>

<body>
    <br>
    <?php include "admin_volunteerNavbar.php"; ?>
    <br><br>
    <div class="container">
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
            <input type="file" name="eventImage" accept="image/*">
            <br><br>
            <input type="submit" value="Add Gig">
        </form>
    </div>
</body>

</html>
