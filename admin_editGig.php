<?php
include "dbFunctions.php";
include "admin_volunteerNavbar.php";
include "ft.php";

if (isset($_GET['eventID'])) {
    $eventID = $_GET['eventID'];

    $query = "SELECT * FROM events WHERE eventID=?";
    $stmt = mysqli_prepare($link, $query);
    mysqli_stmt_bind_param($stmt, "i", $eventID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_array($result);

    if (!empty($row)) {
        $eventID = $row['eventID'];
        $title = $row['title'];
        $dateTimeStart = $row['dateTimeStart'];
        $dateTimeEnd = $row['dateTimeEnd'];
        $locations = $row['locations'];
        $descs = $row['descs'];
        $points = $row['points'];
        $image = $row['images'];
    }

} else {
    echo "Event ID not provided.";
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Edit Gig</title>
    <style>
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
            text-align: center;
        }

        h1 {
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        textarea,
        input[type="datetime-local"],
        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            /* Ensure padding and border are included in width */
            font-size: 16px;
        }

        textarea {
            height: 100px;
            resize: vertical;
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

    <?php if (!empty($eventID)) { ?>
        <br></br><br></br>
        <div class="container">
            <h1><b>Edit Gig</b></h1>
            <form action="admin_doeditGig.php" method="post">
                <input type="hidden" name="eventID" value="<?php echo $eventID; ?>" />
                <div class="form-group">
                    <label>Image:</label>
                    <input type="file" name="image" accept="image/*">
                </div>

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
                    <label>Event Description:</label>
                    <textarea name="descs"><?php echo $row['descs']; ?></textarea>
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
                    <input type="submit" value="Save Changes">
                </div>
            </form>
        </div>
    <?php } ?>
</body>

</html>