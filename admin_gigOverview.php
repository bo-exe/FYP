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
    <link rel="stylesheet" type="text/css" href="style.css">
    <style>
        .event-card-container {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 20px;
        }

        .event-card {
            width: 325px;
            background-color: #ECECE7;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.2);
            margin: 20px;
            height: 300px;
            text-decoration: none;
            color: inherit;
            position: relative;
        }

        .event-card img {
            width: 100%;
            height: 165px;
            object-fit: cover;
        }

        .event-card-content {
            padding: 1px;
        }

        .event-card-content h2 {
            font-size: 28px;
            margin-bottom: 10px;
            margin-top: 10px;
        }

        .event-card-content p {
            color: #333333;
            font-size: 15px;
            line-height: 1.3;
            margin-left: 10px;
        }

        .event-card-content .del-btn {
            display: inline-block;
            padding: 8px 16px;
            background-color: #EF1E1E;
            text-decoration: none;
            border-radius: 30px;
            margin-top: 16px;
            color: #FFF5F5;
            font-weight: bold;
            margin-left: 10px;
            margin-bottom: 10px;
        }

        .event-card-content .edit-btn {
            display: inline-block;
            padding: 8px 20px;
            background-color: #FFD036;
            text-decoration: none;
            border-radius: 30px;
            margin-top: 16px;
            margin-left: 160px;
            margin-bottom: 10px;
            color: #FFF5F5;
            font-weight: bold;
        }

        .add-btn {
            display: inline-block;
            padding: 8px 16px;
            background-color: #BFB7B7;
            text-decoration: none;
            border-radius: 30px;
            color: #FFF5F5;
            font-weight: bold;
            margin-top: 20px;
        }

        .add-btn-container {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <?php include "admin_volunteerNavbar.php"; ?>
    <?php include "ft.php"; ?>

    <br><br>
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
                <a href="admin_gigDetails.php?eventID=<?php echo $eventID; ?>" style="text-decoration: none; color: inherit;">
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

    <?php include "admin_footer.php"; ?>
</body>

</html>
