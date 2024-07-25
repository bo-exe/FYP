<?php
include "dbFunctions.php";
include "admin_teamNavbar.php";
include "ft.php";

$msg = "";

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
        $imageData = $row['images'];
    } else {
        $msg = "Gig not found.";
    }
} else {
    $msg = "Event ID not provided.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Gig</title>
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
            text-align: center;
        }
        .card img {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
            margin-bottom: 10px;
        }
        .form-group {
            margin-bottom: 15px;
            text-align: left;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 16px;
        }
        .form-group input[type="submit"] {
            background-color: #FFD036;
            border: none;
            color: #fff;
            cursor: pointer;
        }
        .form-group input[type="submit"]:hover {
            background-color: #E7BC32;
        }
        .del-btn, .edit-btn {
            display: inline-block;
            padding: 8px 16px;
            text-decoration: none;
            border-radius: 30px;
            margin-top: 16px;
            font-weight: bold;
        }
        .del-btn {
            background-color: #EF1E1E;
            color: #FFF5F5;
        }
        .del-btn:hover {
            background-color: #d81b1b;
        }
        .edit-btn {
            background-color: #FFD036;
            color: #FFF5F5;
            margin-left: 10px;
        }
        .edit-btn:hover {
            background-color: #E7BC32;
        }
    </style>
</head>
<body>
<div class="container">
    <?php if (!empty($eventID) && empty($msg)) { ?>
        <div class="card">
            <?php if (!empty($imageData)) { ?>
                <img src="data:image/<?php echo htmlspecialchars($imageType); ?>;base64,<?php echo base64_encode($imageData); ?>" alt="Gig Image">
            <?php } ?>
            <h2>Edit Gig</h2>
            <form action="admin_doeditgig.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="eventID" value="<?php echo htmlspecialchars($eventID); ?>" />
                <div class="form-group">
                    <label>Image:</label>
                    <input type="file" name="image" accept="image/*">
                </div>
                <div class="form-group">
                    <label>Name:</label>
                    <textarea name="title"><?php echo htmlspecialchars($title); ?></textarea>
                </div>
                <div class="form-group">
                    <label>Start Date:</label>
                    <input type="datetime-local" name="dateTimeStart" value="<?php echo date('Y-m-d\TH:i', strtotime($dateTimeStart)); ?>">
                </div>
                <div class="form-group">
                    <label>End Date:</label>
                    <input type="datetime-local" name="dateTimeEnd" value="<?php echo date('Y-m-d\TH:i', strtotime($dateTimeEnd)); ?>">
                </div>
                <div class="form-group">
                    <label>Event Description:</label>
                    <textarea name="descs"><?php echo htmlspecialchars($descs); ?></textarea>
                </div>
                <div class="form-group">
                    <label>Locations:</label>
                    <input type="text" name="locations" value="<?php echo htmlspecialchars($locations); ?>">
                </div>
                <div class="form-group">
                    <label>Points:</label>
                    <input type="number" name="points" min="0" value="<?php echo htmlspecialchars($points); ?>">
                </div>
                <div class="form-group">
                    <input type="submit" value="Save Changes">
                </div>
            </form>
        </div>
    <?php } else { ?>
        <div class="card">
            <p><?php echo htmlspecialchars($msg); ?></p>
            <a href="admin_allgigs.php" class="edit-btn">Back to Offers</a>
        </div>
    <?php } ?>
</div>
</body>
</html>
