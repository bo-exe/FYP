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
<br lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Offers</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
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
        height: 300px;
    }

    .offer-card img {
        width: 100%;
        height: 165px;
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
        padding: 8px 16px;
        background-color: #FFD036;
        text-decoration: none;
        border-radius: 30px;
        margin-top: 16px;
        margin-left: 155px;
        margin-bottom: 10px;
        color: #FFF5F5;
        font-weight: bold;
    }
</style>

<body>
<?php include "admin_retailnavbar.php"; ?>
    <?php include "ft.php"; ?>
    <br>
    <h1>Organisation Vouchers</h1>
    <div class="offer-card-container">
    <?php
    foreach ($arrContent as $offerData) {
        $offerId = $offerData['offerId'];
        $title = $offerData['title'];
        $dateTimeEnd = $offerData['dateTimeEnd'];
        $picture = $offerData['images'];

        // If no picture is available, use a default image
        if ($picture == "none") {
            $picture = "none.png";
        }
    ?>
        <div class="offer-card">
            <img src="Images/<?php echo $picture; ?>" alt="<?php echo $title; ?>" class="card-img-top">
            <div class="offer-card-content">
            <input type="hidden" name="offerId" value="<?php echo $offerId; ?>">
                <h2 class="card-title"><?php echo $title; ?></h2>
                <p class="card-text">Use By: <?php echo $dateTimeEnd; ?></p>
                <a href="deleteOffer.php?offerId=<?php echo $offerId; ?>" class="del-btn">Delete</a>
                <a href="editOffer.php?offerId=<?php echo $offerId; ?>" class="edit-btn">Edit</a>
            </div>
        </div>
    <?php } ?>
    </div>

    <!-- Footer Section -->
    <footer class="footer">
        <div class="footer-content">
            <div class="logo-container">
                <img src="images/admin_logo.jpg" alt="logo" style="width:100px;">
            </div>
        </div>
        <div class="footer-content">
            <h4>ABOUT</h4>
            <ul>
                <li><a href="index.html#about">About VOMO</a></li>
            </ul>
        </div>
        <div class="footer-content">
            <h4>CONTACT US</h4>
            <ul>
                <li><a href="index.html#contact">Feedback</a></li>
                <li><a href="index.html#contact">Support Us</a></li>
            </ul>
        </div>
        <div class="footer-content">
            <div class="social-section">
                <h4 class="social-text">Socials:</h4>
                <div class="social-icons">
                    <a href="https://www.instagram.com/vomo/?hl=en"><i class='bx bxl-instagram'></i></a>
                    <a href="https://web.telegram.org/a/#vomo"><i class='bx bxl-telegram'></i></a>
                    <a href="https://api.whatsapp.com/send/?phone=%2B90716235&text&type=phone_number&app_absent=0"><i
                            class='bx bxl-whatsapp'></i></a>
                    <a href="https://mail.google.com/mail/u/0/?hl=en#inbox?compose=new"><i
                            class='bx bx-envelope'></i></a>
                </div>
            </div>
        </div>
        <div class="footer-iconTop">
            <a href="index.php"><i class='bx bx-up-arrow-alt'></i></a>
        </div>
        <div class="copyright">
            <p>Copyright © VOMO.</p>
        </div>
    </footer>
    <script src="script.js"></script>
</body>

</html>