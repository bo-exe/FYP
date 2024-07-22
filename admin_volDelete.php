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
        // Fetch image blob data and convert to base64
        $imageData = $row['images'];
        $imageType = $row['imageType']; // Assuming you store image type in database

        $image = 'data:image/' . $imageType . ';base64,' . base64_encode($imageData);
    }

} else {
    // Gig ID not provided
    echo "Gig ID not provided.";
}
?>

<html>
<head>
    <meta charset="UTF-8">
    <title>Delete Gig</title>
    <style>
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .card {
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 400px;
        }

        .card img {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .del-btn {
            display: inline-block;
            padding: 8px 16px;
            background-color: #EF1E1E;
            text-decoration: none;
            border-radius: 30px;
            margin-top: 16px;
            color: #FFF5F5;
            font-weight: bold;
            text-align: center;
            margin-left: 130px;
        }

        .del-btn:hover {
            background-color: #d81b1b;
        }
    </style>
</head>

<body>
<div class="container">
    <?php if (!empty($eventID)) { ?>
        <div class="card">
            <img src="<?php echo $image; ?>" alt="Gig Image">
            <h2><?php echo $title; ?></h2>
            <p><b>Start Date:</b> <?php echo $dateTimeStart; ?></p>
            <p><b>End Date:</b> <?php echo $dateTimeEnd; ?></p>
            <p><b>Locations:</b> <?php echo $locations; ?></p>
            <p><b>Gig Description:</b> <?php echo $descs; ?></p>
            <p><b>Points:</b> <?php echo $points; ?></p>
            <a href="admin_volDoDelete.php?eventID=<?php echo $eventID; ?>" class="del-btn">Delete</a>
        </div>
    <?php } else { ?>
        <div style="text-align: center;">
            <p>Invalid gig ID. Please try again.</p>
            <p><a href="admin_volManage.php">Back to Gigs</a></p>
        </div>
    <?php } ?>
</div>
</body>

</html>
        