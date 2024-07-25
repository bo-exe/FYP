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
        .main-content {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            max-width: 600px;
        }
    </style>
</head>
<body>
<?php include "vol_navbar.php"; ?>

<div class="main-content">
    <h2>Activity Confirmed!</h2>
    <img src="images/tick.jpg" alt="">
    <a href="vol_allYourActivities.php" class="btn btn-primary">Go to Calendar</a>
</div>

<?php include "vol_footer.php"; ?>
</body>
</html>
