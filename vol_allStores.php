<?php
include "dbFunctions.php";
include "ft.php";
session_start();

$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $sql = "SELECT points FROM volunteers WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result) {
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $vomoPoints = $row['points'];
        } else {
            $vomoPoints = 0;
        }
    } else {
        $vomoPoints = 0;
    }
} else {
    $vomoPoints = 0;
}

$query = "SELECT * FROM stores";
$result = mysqli_query($conn, $query) or die(mysqli_error($conn));

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

        .home p,
        .home h3 {
            margin-right: 800px;
            text-align: left;
        }

        .home h1 {
            margin-right: 800px;
            text-align: left;
            text-shadow: 0 .1rem 0.05rem #333;
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

        .more-btn {
            padding: 0.3rem 0.7rem;
            background: #FFD036;
            border-radius: .6rem;
            box-shadow: 0 .2rem .5rem #333;
            font-size: 0.8rem;
            color: #333;
            letter-spacing: .1rem;
            font-weight: 600;
            border: .2rem solid transparent;
            margin-top: 16px;
            text-decoration: none;
            text-align: center;
        }

        .more-btn-container {
            display: flex;
            justify-content: center;
            margin-top: 20px;
            background: #FFD036;
            color: #333;
            border: .2rem solid transparent;
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

        /* Yellow Container */
        .yellow-container {
            background-color: #FFD036;
            color: #333;
            text-align: left;
            padding: 15px;
            box-sizing: border-box;
            margin-bottom: 20px;
            display: none;
        }

        .yellow-container h1 {
            margin: 0;
            padding: 0;
            font-size: 24px;
            font-weight: bold;
            padding-left: 20px;
        }

        .yellow-container .points-container {
            display: none;
        }

        @media screen and (max-width: 768px) {
            body {
                padding-bottom: 20px; 
                margin-top: 50px;
            }

            .stores-card-container {
                padding-top: -100px;
                padding-bottom: 90px;
            }

            .yellow-container {
                display: block;
                width: 100%;
                text-align: center;
                padding: 10px 0; 
            }

            .yellow-container h1, .yellow-container p {
                text-align: left;
                padding-left: 20px;
            }

            .home .points-container {
                display: none;
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
                letter-spacing: .1rem;
                font-weight: 800;
                padding: 10px;
                max-width: 250px; 
                white-space: nowrap; 
                overflow: hidden; 
                text-overflow: ellipsis; 
                margin-left: 20px;
            }

            .points-container i {
                margin-right: 5px;
            }

            .points-container .vomo-points {
                display: flex;
                align-items: center;
            }

            .points-container .vomo-points span:first-child {
                margin-right: 10px; 
            }

            .yellow-container .points-container {
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
        }
    </style>
</head>

<body>
    <?php include "vol_navbar.php"; ?>

    <div class="yellow-container">
        <h1>All Stores</h1>
        <p>Stores</p>
        <br>
        <div class="points-container">
            <i class='bx bx-gift'></i>
            <div class="vomo-points">
                <span>VOMOPoints</span>
                <span><?php echo $vomoPoints; ?></span>
            </div>
        </div>
    </div>

    <section class="home" id="home">
        <div class="header">
            <div class="greeting">
                <h1>All Stores</h1>
                <p>Stores</p>
            </div>
            <div class="points-container">
                <i class='bx bx-gift'></i>
                <div class="vomo-points">
                    <span>VOMOPoints</span>
                    <span><?php echo $vomoPoints; ?></span>
                </div>
            </div>
        </div>
    </section>

    <section class="stores">
        <div class="stores-card-container">
            <?php foreach ($arrContent as $storeData): ?>
                <div class="stores-card">
                    <a href="vol_storeVouchers.php?storeId=<?php echo $storeData['storeId']; ?>"
                        style="text-decoration: none; color: inherit;">
                        <img src="<?php echo ($storeData['image'] == 'none') ? 'images/default.jpg' : 'data:image/jpeg;base64,' . base64_encode($storeData['image']); ?>"
                            alt="<?php echo $storeData['title']; ?>" class="card-img-top">
                        <div class="stores-card-content">
                            <h2><?php echo $storeData['title']; ?></h2>
                            <p><b>Quantity:</b> <?php echo $storeData['quantity']; ?></p>
                        </div>
                    </a>
                    <div class="stores-card-content">
                        <a href="vol_storeVouchers.php?storeId=<?php echo $storeData['storeId']; ?>"
                            class="more-btn">More</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <?php include "footer.php"; ?>
    <script src="script.js"></script>
</body>
</html>
