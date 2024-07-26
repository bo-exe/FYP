<?php
include "ft.php";
include "dbFunctions.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $enteredCode = $_POST['code'];

    // Retrieve the offer details using the entered code from the redeemed_vouchers table
    $query = "SELECT rv.offerId, rv.code, o.title FROM redeemed_vouchers rv JOIN offers o ON rv.offerId = o.offerId WHERE rv.code = ?";
    $stmt = mysqli_prepare($link, $query);
    mysqli_stmt_bind_param($stmt, "s", $enteredCode);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $offerId, $storedCode, $offerTitle);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    if ($storedCode === $enteredCode) {
        $message = "Voucher for \"$offerTitle\" has been redeemed.";
    } else {
        $message = "Invalid code. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verify Code</title>
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
            padding: 10px 20px;
            border-radius: 30px;
            font-weight: bold;
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
    <?php include "admin_retailNavbar.php"; ?>
    <div class="container">
        <div class="card">
            <h2>Verify Code</h2>
            <?php if (isset($message)) { echo "<p>$message</p>"; } ?>
            <form method="post" action="">
                <div class="form-group">
                    <label for="code">Code:</label>
                    <input type="text" name="code" id="code" required>
                </div>
                <div class="form-group">
                    <input type="submit" value="Verify">
                </div>
            </form>
        </div>
    </div>
    <?php include "admin_footer.php"; ?>
</body>
</html>
