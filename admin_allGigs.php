<?php
include "dbFunctions.php";
session_start();

$query = "SELECT * FROM events";
$result = mysqli_query($link, $query) or die(mysqli_error($link));

$arrContent = array();
while ($row = mysqli_fetch_array($result)) {
    $arrContent[] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Gigs</title>
    <link rel="stylesheet" type="text/css" href="volunteeradminstyle.css">
</head>
<br>
<?php include "admin_volunteerNavbar.php"; ?>
<?php include "ft.php"; ?>
<br></br>

<body>
    <h1>Gigs</h1>
    <div class="event-card-container">
        <?php foreach ($arrContent as $eventData) : ?>
            <?php
            $eventID = $eventData['eventID'];
            $title = $eventData['title'];
            $dateTimeEnd = $eventData['dateTimeEnd'];
            $picture = $eventData['images'];

            // Convert BLOB data to base64 encoded image
            $imageSrc = 'data:image/jpeg;base64,' . base64_encode($picture);

            // If no picture is available, use a default image
            if (empty($picture)) {
                $imageSrc = 'images/none.png'; // Provide path to your default image
            }
            ?>
            <div class="event-card">
                <a href="admin_gigOverview.php?eventID=<?php echo $eventID; ?>" style="text-decoration: none; color: inherit;">
                    <img src="<?php echo $imageSrc; ?>" alt="<?php echo $title; ?>" class="card-img-top">
                    <div class="event-card-content">
                        <h2 class="card-title"><?php echo $title; ?></h2>
                        <p class="card-text">Event Date: <?php echo $dateTimeEnd; ?></p>
                    </div>
                </a>
                <div class="event-card-content">
                    <a href="admin_deleteGig.php?eventID=<?php echo $eventID; ?>" class="del-btn">Delete</a>
                    <a href="admin_editGig.php?eventID=<?php echo $eventID; ?>" class="edit-btn">Edit</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="add-btn-container">
        <a href="admin_addGig.php" class="add-btn">Add More</a>
    </div>
</body>
</html>
