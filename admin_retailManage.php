<?php
include "dbFunctions.php";
session_start();

if (!isset($_SESSION['username'])) {
    // Redirect to login page if not logged in
    header('Location: login.php');
    exit;
}

$username = $_SESSION['username'];
$adminID = $_SESSION['adminID']; // Assuming you store adminID in session

$query = "SELECT * FROM offers WHERE adminID = ?";
$stmt = $link->prepare($query);
$stmt->bind_param("i", $adminID);
$stmt->execute();
$result = $stmt->get_result();

$arrContent = array();
while ($row = $result->fetch_assoc()) {
    $arrContent[] = $row;
}

$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Offers</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="icon" type="image/x-icon" href="images/admin_logo.jpg">
    <style>
        .body{
            padding-top : 20px;
        }
        .offer-card-container {
            padding-top: 50px;
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 0px;
        }
        .offer-card {
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
        .offer-card img {
            width: 100%;
            height: 165px;
            object-fit: cover;
        }
        .offer-card-content {
            padding: 1px;
        }
        .offer-card-content h2 {
            font-size: 28px;
            margin-bottom: 10px;
            margin-top: 10px;
        }
        .offer-card-content p {
            color: #333333;
            font-size: 15px;
            line-height: 1.3;
            margin-left: 10px;
        }
        .offer-card-content .del-btn {
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
        .offer-card-content .edit-btn {
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
<?php include "ft.php"; ?>
<?php include "admin_retailNavBar.php"; ?>
<body>
    <h1>Welcome, <?php echo htmlspecialchars($username); ?>!</h1>
    <h1>Organisation Vouchers</h1>
    <div class="offer-card-container">
        <?php foreach ($arrContent as $offerData) : ?>
            <?php
            $offerId = $offerData['offerId'];
            $title = $offerData['title'];
            $dateTimeEnd = $offerData['dateTimeEnd'];
            $picture = $offerData['images'];

            // Convert BLOB data to base64 encoded image
            $imageSrc = 'data:image/jpeg;base64,' . base64_encode($picture);

            // If no picture is available, use a default image
            if (empty($picture)) {
                $imageSrc = 'images/none.png'; 
            }
            ?>
            <div class="offer-card">
                <a href="admin_retailVoucher.php?offerId=<?php echo $offerId; ?>" style="text-decoration: none; color: inherit;">
                    <img src="<?php echo $imageSrc; ?>" alt="<?php echo $title; ?>" class="card-img-top">
                    <div class="offer-card-content">
                        <h2 class="card-title"><?php echo $title; ?></h2>
                        <p class="card-text">Use By: <?php echo $dateTimeEnd; ?></p>
                    </div>
                </a>
                <div class="offer-card-content">
                    <a href="admin_retailDelete.php?offerId=<?php echo $offerId; ?>" class="del-btn">Delete</a>
                    <a href="admin_retailEdit.php?offerId=<?php echo $offerId; ?>" class="edit-btn">Edit</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="add-btn-container">
        <a href="admin_retailCreate.php" class="add-btn">Add More</a>
    </div>
    <br></br><br></br><br></br><br></br>
    <?php include "admin_footer.php"; ?>
</body>
</html>
