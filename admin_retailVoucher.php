<?php
include "dbFunctions.php";
session_start();

$query = "SELECT * FROM offers";
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
    <title>Manage Offers</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <style>
        .offer-card-container {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 20px;
        }

        .offer-card {
            width: 325px;
            background-color: #ECECE7;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.2);
            margin: 20px;
            height: auto;
            text-decoration: none;
            color: inherit;
            position: relative;
        }

        .offer-card img {
            width: 100%;
            height: 165px;
        }

        .offer-card-content {
            padding: 15px;
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
            margin-bottom: 10px;
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
            margin-right: 10px;
            margin-bottom: 10px;
        }

        .offer-card-content .edit-btn {
            display: inline-block;
            padding: 8px 16px;
            background-color: #FFD036;
            text-decoration: none;
            border-radius: 30px;
            margin-top: 16px;
            color: #FFF5F5;
            font-weight: bold;
            margin-bottom: 10px;
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
    <?php include "admin_retailNavBar.php"; ?>
    <?php include "ft.php"; ?>

    <br></br><br></br>
    <h1>Organisation Vouchers</h1>
    <div class="offer-card-container">
        <?php
        foreach ($arrContent as $offerData) {
            $offerId = $offerData['offerId'];
            $title = $offerData['title'];
            $dateTimeStart = $offerData['dateTimeStart'];
            $dateTimeEnd = $offerData['dateTimeEnd'];
            $locations = $offerData['locations'];
            $termsAndConditions = $offerData['tandc'];
            $points = $offerData['points'];
            $amount = $offerData['amount'];
            $picture = $offerData['images'];

            // If no picture is available, use a default image
            if ($picture == "none") {
                $picture = "none.png";
            }
        ?>
            <div class="offer-card">
                <a href="admin_retailEdit.php?offerId=<?php echo $offerId; ?>" style="text-decoration: none; color: inherit;">
                    <img src="Images/<?php echo $picture; ?>" alt="<?php echo $title; ?>" class="card-img-top">
                    <div class="offer-card-content">
                        <input type="hidden" name="offerId" value="<?php echo $offerId; ?>">
                        <h2 class="card-title"><?php echo $title; ?></h2>
                        <p class="card-text"><b>Start Date:</b> <?php echo $dateTimeStart; ?></p>
                        <p class="card-text"><b>End Date:</b> <?php echo $dateTimeEnd; ?></p>
                        <p class="card-text"><b>Locations:</b> <?php echo $locations; ?></p>
                        <p class="card-text"><b>T&C:</b> <?php echo $termsAndConditions; ?></p>
                        <p class="card-text"><b>Points:</b> <?php echo $points; ?></p>
                        <p class="card-text"><b>Amount:</b> <?php echo $amount; ?></p>
                    </div>
                </a>
                <div class="offer-card-content">
                    <a href="admin_retailDelete.php?offerId=<?php echo $offerId; ?>" class="del-btn">Delete</a>
                    <a href="admin_retailEdit.php?offerId=<?php echo $offerId; ?>" class="edit-btn">Edit</a>
                </div>
            </div>
        <?php } ?>
    </div>

    <div class="add-btn-container">
        <a href="admin_retailCreate.php" class="add-btn">Add More</a>
    </div>

    <script src="script.js"></script>
    <br></br>
    <?php include "admin_footer.php"; ?>
</body>

</html>
