<?php
include "dbFunctions.php";
include "ft.php"; 
session_start();

$query = "SELECT * FROM stores";
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
    <title>All Stores</title>
    <link rel="icon" type="image/x-icon" href="images/logo.jpg">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css">
    <style>
        /* Navbar styling */
        nav {
            position: fixed; 
            top: 0;
            width: 100%;
            z-index: 1000; 
        }

        /* Homepage */
        .home {
            margin-top: 100px;
        }

        .home p, h3 {
            margin-right: 800px;
            text-align: left;
        }

        .home h1 {
            margin-right: 800px;
            text-align: left;
            text-shadow: 0 .1rem .1rem #333;
        }

        .stores-card-container {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 20px;
        }

        .stores-card {
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

        .stores-card img {
            width: 100%;
            height: 165px;
        }

        .stores-card-content {
            padding: 15px;
        }

        .stores-card-content h2 {
            font-size: 28px;
            margin-bottom: 10px;
            margin-top: 10px;
        }

        .stores-card-content p {
            color: #333333;
            font-size: 15px;
            line-height: 1.3;
            margin-bottom: 10px;
        }

        .stores-card-content .del-btn {
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

        .stores-card-content .edit-btn {
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

        .more-btn {
            display: inline-block;
            padding: 8px 16px;
            background-color: #BFB7B7;
            text-decoration: none;
            border-radius: 30px;
            color: #FFF5F5;
            font-weight: bold;
            margin-top: 20px;
        }

        .more-btn-container {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .header {
            display: flex;
            align-items: center;
        }

        .greeting {
            flex-grow: 1; 
        }

        .points-container {
            display: flex;
            align-items: center;
            justify-content: left;
            font-size: 14px;
            color: #333;
            background-color: #ECECE7;
            border-radius: .6rem;
            box-shadow: 0 .2rem .5rem #333;
            letter-spacing: .2rem;
            font-weight: 800;
            padding: 10px;
        }

        .points-container i {
            margin-right: 5px;
        }

        .points-container .vomo-points {
            display: flex;
            align-items: center;
        }

        .points-container .vomo-points span:first-child {
            margin-right: 100px;
        }
    </style>
</head>
<body>
<?php include "navbar.php"; ?>
    <section class="home" id="home">
        <div class="header">
            <div class="greeting">
                <h1>Stores</h1>
                <br>
                <h3>Store Vouchers</h3>
            </div>
            <div class="points-container">
                <i class='bx bx-gift'></i>
                <div class="vomo-points">
                    <span>VOMOPoints</span>
                    <span>0</span>
                </div>
            </div>
        </div>
    </section>

    <div class="stores-card-container">
        <?php
        foreach ($arrContent as $storeData) {
            $storeId = $storeData['storeId'];
            $title = $storeData['title'];
            $quantity = $storeData['quantity'];
            $picture = $storeData['image'];

            // If no picture is available, use a default image
            if ($picture == "none") {
                $picture = "none.png";
            } else {
                $picture = 'data:image/jpeg;base64,' . base64_encode($picture);
            }
        ?>
            <div class="stores-card">
                <a href="all_vouchers.php?storeId=<?php echo $storeId; ?>" style="text-decoration: none; color: inherit;">
                    <img src="<?php echo $picture; ?>" alt="<?php echo $title; ?>" class="card-img-top">
                    <div class="stores-card-content">
                        <input type="hidden" name="offerId" value="<?php echo $storeId; ?>">
                        <p class="card-text"><b>Quantity:</b> <?php echo $quantity; ?></p>
                    </div>
                </a>
                <div class="stores-card-content">
                    <a href="all_vouchers.php?storeId=<?php echo $storeId; ?>" class="more-btn">More</a>
                </div>
            </div>
        <?php } ?>
    </div>

    <?php include "footer.php"; ?>
    <script src="script.js"></script>
</body>
</html>
