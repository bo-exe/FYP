<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup Confirmation</title>
    <link rel="stylesheet" href="style.css">
    <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet'>
    <link rel="icon" type="image/x-icon" href="images/logo.jpg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
        }
        .container {
            background: #FFFFFF;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px;
            flex: 1;
        }

        .btn {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            background-color: #FFD036;
            color: #fff;
            font-size: 16px;
            font-weight: bold;
            transition: background-color 0.3s;
            margin-top: 20px; /* Add margin to push the button down */
        }

        .btn:hover {
            background: #FFD036;
            color: #333; 
            border: .2rem solid transparent;
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
<?php include "vol_navbar.php"; ?>

<div class="container">
    <img src="images/logo.jpg" alt="Logo" width="300" height="200">
    <h2 class="text-center mb-4">Activity Confirmed!</h2>
    <img src="images/tick.jpg" alt="Tick" height="150" width="150">
    <div class="text-center">
        <a href="vol_allYourActivities.php" class="btn">Go to Calendar</a>
    </div>
</div>

<?php include "vol_footer.php"; ?>
</body>
</html>
