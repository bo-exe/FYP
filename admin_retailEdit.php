<?php
include "dbFunctions.php";
include "ft.php";


$msg = "";

if (isset($_GET['offerId'])) {
    $offerId = $_GET['offerId'];

    $query = "SELECT *, amount - redeemed_vouchers AS amount_after_redemption FROM offers WHERE offerId=?";
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
        $instructions = $row['instructions'];
        $points = $row['points'];
        $amount = $row['amount'];
        $imageData = $row['images'];
        $imageType = $row['imageType'];
        $company = $row['company'];
        $qrCodeData = $row['QR']; // QR code BLOB data
    } else {
        $msg = "Offer not found.";
    }
} else {
    $msg = "Offer ID not provided.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Offer</title>
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
            padding: 60px;
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

        @media (max-width: 768px) {
            .body {
                padding-top: 60px; 
            }

            .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            padding-bottom:60px ;
        }

        }
    </style>
</head>
<body>
    <?php
    include "admin_retailNavbar.php"; 
    ?>
<div class="container">
    <?php if (!empty($offerId) && empty($msg)) { ?>
        < class="card">
            <?php if (!empty($imageData)) { ?>
                <img src="data:image/<?php echo htmlspecialchars($imageType); ?>;base64,<?php echo base64_encode($imageData); ?>" alt="Offer Image">
            <?php } ?>
            <h2>Edit Offer</h2>
            <form action="admin_retailDoEdit.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="offerId" value="<?php echo htmlspecialchars($offerId); ?>" />
                <div class="form-group">
                    <label>Image:</label>
                    <input type="file" name="image" accept="image/*">
                </div>
                <div class="form-group">
                    <label>Company:</label>
                    <input type="text" name="company" value="<?php echo htmlspecialchars($company); ?>">
                </div>
                <div class="form-group">
                    <label>QR Code:</label>
                    <?php if (!empty($qrCodeData)) { ?>
                        <img src="data:image/png;base64,<?php echo base64_encode($qrCodeData); ?>" alt="QR Code" style="max-width: 100%; height: auto;">
                    <?php } else { ?>
                        <p>No QR code available.</p>
                    <?php } ?>
                </div>
                <div class="form-group">
                    <label>Title:</label>
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
                    <label>T&C:</label>
                    <textarea name="tandc"><?php echo htmlspecialchars($termsAndConditions); ?></textarea>
                </div>
                <div class="form-group">
                    <label>Locations:</label>
                    <input type="text" name="locations" value="<?php echo htmlspecialchars($locations); ?>">
                </div>
                <div class="form-group">
                    <label>Instructions:</label>
                    <textarea name="instructions"><?php echo htmlspecialchars($instructions); ?></textarea>
                </div>
                <div class="form-group">
                    <label>Points:</label>
                    <input type="number" name="points" min="0" value="<?php echo htmlspecialchars($points); ?>">
                </div>
                <div class="form-group">
                    <label>Amount:</label>
                    <input type="number" name="amount" min="0" value="<?php echo htmlspecialchars($amount); ?>">
                </div>
                <div class="form-group">
                    <input type="submit" value="Save Changes">
                </div>
            </form>
        </div>
        <br></br><br></br><br></br>
    <?php } else { ?>
        <div class="card">
            <p><?php echo htmlspecialchars($msg); ?></p>
            <a href="admin_retailManage.php" class="edit-btn">Back to Offers</a>
        </div>
    <?php } ?>
</>
</body>
</html>