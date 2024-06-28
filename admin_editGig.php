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
    <link rel="stylesheet" type="text/css" href="volunteeradminstyle.css">
</head>

<body>

    <?php if (!empty($eventID)) { ?>
        <br></br><br></br>
        <div class="editgig-container">
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