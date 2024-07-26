<!DOCTYPE html>
<html>
<link rel="icon" type="image/x-icon" href="images/admin_logo.jpg">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Add Offer</title>
    <style>
        body {
            background-color: #f4f4f4;
        }

        .container {
            margin-top: 50px;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 0 auto;
        }
        .message {
            margin-bottom: 20px;
            font-size: 18px;
        }
        .back-link {
            display: inline-block;
            padding: 10px 20px;
            background-color: #FFD036;
            margin-left: 15px;
            margin-top: 20px;
            text-decoration: none;
            color: #fff;
            border-radius: 30px;
            font-weight: bold;
        }
        .back-link:hover {
            background-color: #FFC300;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        form {
            margin-top: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }

        input[type="text"],
        input[type="datetime-local"],
        input[type="number"],
        input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
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

        .error {
            color: red;
        }
    </style>
</head>

<body>
    <?php include "admin_retailNavbar.php"; ?>
    <?php include "ft.php"; ?>
    <div class="container">
        <h2>Add Offer</h2>
        <?php if (isset($errorMessage)): ?>
            <p class="error">Error: <?php echo $errorMessage; ?></p>
        <?php endif; ?>
        <?php if (isset($message)): ?>
            <p><?php echo $message; ?></p>
            <p><a href="admin_retailManage.php" class="back-link">Back to Offers</a></p>
        <?php else: ?>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
                <label>Title:</label><br>
                <input type="text" name="title" required><br>
                <label>Date Time Start:</label><br>
                <input type="datetime-local" name="dateTimeStart" required><br>
                <label>Date Time End:</label><br>
                <input type="datetime-local" name="dateTimeEnd" required><br>
                <label>Locations:</label><br>
                <input type="text" name="locations" required><br>
                <label>Terms & Conditions:</label><br>
                <input type="text" name="tandc" required><br>
                <label>Instructions:</label><br>
                <input type="text" name="instructions" required><br>
                <label>Points:</label><br>
                <input type="number" name="points" min="0" required><br>
                <label>Amount:</label><br>
                <input type="number" name="amount" min="0" required><br>
                <label>Company:</label><br>
                <input type="text" name="company" required><br>
                <label>Images:</label><br>
                <input type="file" name="images" accept="image/jpeg, image/png, image/gif" required><br>
                <label>QR Code:</label><br>
                <input type="file" name="QR" accept="image/jpeg, image/png, image/gif" required><br><br>
                <input type="submit" value="Add Offer">
            </form>
        <?php endif; ?>
    </div>
</body>

</html>
