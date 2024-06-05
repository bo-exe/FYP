<?php
include "dbFunctions.php";
include "admin_retailNavbar.php";
include "ft.php";

if (isset($_GET['offerId'])) {
    $offerId = $_GET['offerId'];

    $msg = "";
    $query = "DELETE FROM offers WHERE offerId=?";
    $stmt = mysqli_prepare($link, $query);
    mysqli_stmt_bind_param($stmt, "i", $offerId);
    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        $msg = "Offer successfully deleted";
    } else {
        $msg = "Offer has not been deleted. Error: " . mysqli_error($link);
    }
} else {
    // Handle gracefully if offerId is not available
    $msg = "Offer ID not provided. Offer has not been deleted.";
}
?>

<html>
<head>
    <meta charset="UTF-8">
    <title>Delete Offer</title>
</head>

<body>
    <div style="text-align: center;">
        <?php echo $msg; ?>
        <p><a href="admin_retailManage.php">Back to Offers</a></p>
    </div>
</body>

</html>
