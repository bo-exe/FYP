<?php
include "dbFunctions.php";
include "admin_retailNavbar.php";
include "ft.php";

$msg = "";

if (isset($_GET['offerId'])) {
    $offerId = $_GET['offerId'];

    $query = "SELECT * FROM offers WHERE offerId=?";
    $stmt = mysqli_prepare($link, $query);
    mysqli_stmt_bind_param($stmt, "i", $offerId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_array($result);

    if (!empty($row)) {
        // Extract data from database for pre-filling form
        $title = $row['title'];
        $dateTimeStart = $row['dateTimeStart'];
        $dateTimeEnd = $row['dateTimeEnd'];
        $locations = $row['locations'];
        $termsAndConditions = $row['tandc'];
        $instructions = $row['instructions'];
        $points = $row['points'];
        $amount = $row['amount'];
        $image = $row['images'];
    }

} else {
    // Offer ID not provided
    echo "Offer ID not provided.";
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Edit Offer</title>
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

        img {
            max-width: 100%;
            height: auto;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>

<?php if (!empty($offerId)) { ?>
        <br></br><br></br>
        <div class="container">
            <h1><b>Edit Offer</b></h1>
            <form action="admin_retailDoEdit.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="offerId" value="<?php echo $offerId; ?>" />
                <div class="form-group">
                    <label>Image:</label>
                    <input type="file" name="image" accept="image/*">
                    <?php if (!empty($image)) { ?>
                        <img src="data:image/jpeg;base64,<?php echo base64_encode($image); ?>" alt="Current Image">
                    <?php } ?>
                </div>

                <div class="form-group">
                    <label>Name:</label><br>
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
    <?php } ?>
</body>

</html>
