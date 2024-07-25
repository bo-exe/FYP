<?php
include "dbFunctions.php";
include "ft.php";
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

$username = $_SESSION['username'];
$adminID = $_SESSION['adminID'];

$query = "SELECT * FROM events WHERE adminID = ?";
$stmt = $link->prepare($query);
$stmt->bind_param("i", $adminID);
$stmt->execute();
$result = $stmt->get_result();

$arrContent = array();
while ($row = $result->fetch_assoc()) {
    $arrContent[] = $row;
}

$stmt->close();
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

        // Decode image data to base64 format
        $image = 'data:image/jpeg;base64,' . base64_encode($imageData);

        // Fetch QR code image using eventID
        $qrQuery = "SELECT qrImage FROM QR WHERE eventID = ? ORDER BY qrID DESC LIMIT 1";
        $stmt = $link->prepare($qrQuery);
        $stmt->bind_param("i", $eventID);
        $stmt->execute();
        $qrResult = $stmt->get_result();
        $qrRow = $qrResult->fetch_assoc();
        $qrImage = !empty($qrRow['qrImage']) ? 'data:image/png;base64,' . base64_encode($qrRow['qrImage']) : '';

        // Check if current date and time is after gig's end date
        $currentDateTime = date('Y-m-d H:i:s');
        $expired = ($currentDateTime > $dateTimeEnd);
    } else {
        echo "Gig with ID $eventID not found.";
    }

} else {
    echo "Gig ID not provided.";
}
?>

<html>

<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($title); ?></title>
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

        .expired {
            color: #EF1E1E;
            font-weight: bold;
            font-size: 18px;
        }

        .del-btn, .edit-btn {
            display: inline-block;
            margin: 5px;
            padding: 10px;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }

        .del-btn {
            background-color: #f44336;
        }

        .edit-btn {
            background-color: #4CAF50;
        }
    </style>
</head>
<?php include "admin_volunteerNavbar.php"; ?>
<body>
    <h1>Welcome, <?php echo htmlspecialchars($username); ?>!</h1>
    <div class="container">
        <?php if (!empty($eventID)) { ?>
            <div class="card">
                <img src="<?php echo $image; ?>" alt="Gig Image">
                <h2><?php echo htmlspecialchars($title); ?></h2>
                <p><b>Start Date:</b> <?php echo htmlspecialchars($dateTimeStart); ?></p>
                <p><b>End Date:</b> <?php echo htmlspecialchars($dateTimeEnd); ?></p>
                <p><b>Locations:</b> <?php echo htmlspecialchars($locations); ?></p>
                <p><b>Description:</b> <?php echo htmlspecialchars($descs); ?></p>
                <p><b>Points:</b> <?php echo htmlspecialchars($points); ?></p>
                <?php if ($qrImage) { ?>
                    <img src="<?php echo $qrImage; ?>" alt="QR Code">
                <?php } ?>
                <?php if ($expired) { ?>
                    <p class="expired">This gig has expired.</p>
                <?php } ?>
                <a href="admin_volDoDelete.php?eventID=<?php echo htmlspecialchars($eventID); ?>" class="del-btn">Delete</a>
                <a href="admin_volEdit.php?eventID=<?php echo htmlspecialchars($eventID); ?>" class="edit-btn">Edit</a>
            </div>
        <?php } else { ?>
            <div style="text-align: center;">
                <p>Invalid gig ID. Please try again.</p>
                <p><a href="admin_volmanage.php">Back to Gigs</a></p>
            </div>
        <?php } ?>
    </div>
</body>

</html>
