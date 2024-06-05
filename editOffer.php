<?php
include "dbFunctions.php";
include "retail_navbar.php";
include "ft.php";

if (isset($_GET['offerId'])) {
    $offerId = $_GET['offerId'];

    $query = "SELECT * FROM offers WHERE offerId=?";
    $stmt = mysqli_prepare($link, $query);
    mysqli_stmt_bind_param($stmt, "i", $offerId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_array($result);

    if (!empty($row)) {
        $offerId = $row['offerId'];
        $title = $row['title'];
        $dateTimeStart = $row['dateTimeStart'];
        $dateTimeEnd = $row['dateTimeEnd'];
        $locations = $row['locations'];
        $termsAndConditions = $row['tandc'];
        $points = $row['points'];
        $amount = $row['amount'];
        $image = $row['images'];
    }

} else {
    // Offer ID not provided
    echo "Offer ID not provided.";
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Edit Offer</title>
    <style>
        .container {
            max-width: 500px;
            margin: 0 auto;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            font-weight: bold;
        }
        textarea {
            width: 100%;
            height: 100px;
            resize: vertical;
        }
        input[type="number"], input[type="text"], input[type="datetime-local"] {
            width: 100%;
        }
        input[type="submit"] {
            background-color: #000000;
            color: #fff;
            border: none;
            padding: 8px 15px;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <?php include("retail_navbar.php"); ?>
    <?php if (!empty($offerId)) { ?>
    <div class="container">
        <h1><b>Edit Offer</b></h1>
        <form action="doEditOffer.php" method="post">
            <input type="hidden" name="offerId" value="<?php echo $offerId; ?>"/>
            <!-- <div class="form-group">
                <label>Image:</label>
                <input type="text" name="images" value="<?php echo $row['images']; ?>">
            </div> -->
            <div class="form-group">
                <label>Name:</label><br>
                <textarea name="title"><?php echo $row['title']; ?></textarea>
            </div>
            <div class="form-group">
                <label>Start Date:</label>
                <input type="datetime-local" name="dateTimeStart" value="<?php echo $row['dateTimeStart']; ?>">
            </div>
            <div class="form-group">
                <label>End Date:</label>
                <input type="datetime-local" name="dateTimeEnd" value="<?php echo $row['dateTimeEnd']; ?>">
            </div>
            <div class="form-group">
                <label>T&C:</label>
                <textarea name="tandc"><?php echo $row['tandc']; ?></textarea>
            </div>
            <div class="form-group">
                <label>Locations:</label>
                <input type="text" name="locations" value="<?php echo $row['locations']; ?>">
            </div>
            <div class="form-group">
                <label>Points:</label>
                <input type="number" name="points" min="0" value="<?php echo $row['points']; ?>">
            </div>
            <div class="form-group">
                <label>Amount:</label>
                <input type="number" name="amount" min="0" value="<?php echo $row['amount']; ?>">
            </div>
            <div class="form-group">
                <input type="submit" value="Save Changes">
            </div>
        </form>
    </div>
    <?php } ?>
</body>
</html>
