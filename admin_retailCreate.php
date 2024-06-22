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
    $locations = $_POST['locations'];
    $tandc = $_POST['tandc'];
    $points = $_POST['points'];
    $amount = $_POST['amount'];
    $images = $_POST['images'];

    // Get the highest existing offerId from the database
    $query = "SELECT MAX(offerId) AS maxOfferId FROM offers";
    $result = mysqli_query($link, $query);
    $row = mysqli_fetch_assoc($result);
    $maxOfferId = $row['maxOfferId'];

    // Increment the highest offerId by 1 to get the new offerId
    $newOfferId = $maxOfferId + 1;

    // Insert the new offer into the database
    $insertQuery = "INSERT INTO offers (offerId, title, dateTimeStart, dateTimeEnd, locations, tandc, points, amount, images) 
                    VALUES ('$newOfferId', '$title', '$dateTimeStart', '$dateTimeEnd', '$locations', '$tandc', '$points', '$amount', '$images')";
    if (mysqli_query($link, $insertQuery)) {
        $message = "Offer added successfully.";
    } else {
        $errorMessage = "Error adding offer: " . mysqli_error($link);
    }
}
?> -->
<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Add Offer</title>
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
<?php include "admin_retailNavbar.php"; ?>
<br></br>
<div class="container">
    <h2>Add Offer</h2>
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
            <input type="text" name="locations" required><br>
            <label>Terms & Conditions:</label><br>
            <input type="text" name="tandc" required><br>
            <label>Points:</label><br>
            <input type="number" name="points" min="0" required><br>
            <label>Amount:</label><br>
            <input type="number" name="amount" min="0" required><br>
            <label>Images:</label><br>
            <input type="file" name="images" accept="images/*" required><br><br>
            <input type="submit" value="Add Offer">
        </form>
    <?php endif; ?>
</div>
</body>

</html>
