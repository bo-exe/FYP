<?php
session_start();
include "ft.php";
include "dbFunctions.php";

$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

mysqli_autocommit($conn, TRUE);

// Initialize $msg variable
$msg = '';

if (isset($_SESSION['username']) && isset($_GET['offerId'])) {
    $username = $_SESSION['username'];
    $offerId = $_GET['offerId'];

    // Fetch the volunteer's ID
    $sql = "SELECT volunteerId FROM volunteers WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $volunteerId = $row['volunteerId'];

        // Delete the voucher from redeemed_vouchers table
        $deleteSql = "DELETE FROM redeemed_vouchers WHERE volunteerId = ? AND offerId = ?";
        $stmt = $conn->prepare($deleteSql);
        $stmt->bind_param("ii", $volunteerId, $offerId);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $msg = "<p>Voucher successfully used and removed from your account.</p>";
        } else {
            $msg = "<p>Failed to use the voucher or it might have already been used.</p>";
        }
    } else {
        $msg = "<p>Invalid user.</p>";
    }
} else {
    $msg = "<p>Missing information.</p>";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voucher Status</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            /* Add any global styles here */
        }
        .login-container {
            background-color: #FFD036;
            max-width: 400px;
            margin: 0 auto;
            padding: 40px; /* Increased padding for more space */
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .login-container img {
            display: block;
            margin: 0 auto;
            margin-bottom: 20px;
            border-radius: 8px;
        }
        .btn-custom {
            background-color: #343A40; /* Dark background color */
            border-color: #343A40;
            color: #FFFFFF; /* White text color */
            padding: 10px 20px; /* Adjust padding as needed */
            text-decoration: none; /* Remove underline from link */
            display: inline-block; /* Make it behave like a block-level element */
            transition: background-color 0.3s ease; /* Smooth transition */
        }
        .btn-custom:hover {
            background-color: #23272B; /* Darker shade for hover effect */
            border-color: #23272B;
            color: #FFFFFF; /* White text color */
        }
    </style>
</head>
<?php include "vol_navbar.php"?>
<body>
    <br>
    <div class="login-container">
        <img src="images/logo.jpg" alt="Description of the image" width="300" height="200">
        <div style="text-align: center;">
            <?php echo $msg; ?>
        </div>
    </div>
</body>
</html>
