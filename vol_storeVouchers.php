<?php
session_start();
include "dbFunctions.php"; 

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

if (isset($_GET['storeId'])) {
    $storeId = mysqli_real_escape_string($conn, $_GET['storeId']);
    $queryStore = "SELECT title FROM stores WHERE storeId = ?";
    $stmtStore = mysqli_prepare($conn, $queryStore);
    mysqli_stmt_bind_param($stmtStore, "i", $storeId);
    mysqli_stmt_execute($stmtStore);
    mysqli_stmt_bind_result($stmtStore, $storeTitle);
    mysqli_stmt_fetch($stmtStore);
    mysqli_stmt_close($stmtStore);
    $sql = "SELECT * FROM offers WHERE title LIKE ?";
    $likeParam = '%' . $storeTitle . '%';

    $stmt = mysqli_prepare($conn, $sql);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $likeParam);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($storeTitle); ?> Vouchers</title>
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

        .home p, h3{
            margin-right: 800px;
            text-align: left;
        }

        .home h1 {
            margin-right: 800px;
            text-align: left;
            text-shadow: 0 .1rem .1rem #333;
        }

        .voucher-card-container{
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 100px;
        }

        .voucher-card{
            width: 20%; 
            background-color: #ECECE7;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.2);
            margin: 20px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .voucher-card img {
            width: 100%;
            height: 165px;
        }

        .card-content {
            padding: 16px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .card-content h3 {
            font-size: 28px;
            margin-bottom: 8px;
        }

        .card-content p {
            color: #333;
            font-size: 15px;
            line-height: 1.3;
        }

        .card-content .btn {
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

        .card-content .btn:hover {
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

        @media (max-width: 1200px) {
            .voucher-card {
                width: 30%; 
            }
        }

        @media (max-width: 992px) {
            .voucher-card {
                width: 45%; 
            }
        }

        @media (max-width: 768px) {
            .voucher-card {
                width: 70%; 
            }
        }

        @media (max-width: 576px) {
            .voucher-card {
                width: 90%; 
                margin: 10px;
            }
        }
    </style>
</head>
<body>
<?php include "vol_navbar.php"; ?>
    <?php include "ft.php"; ?>
    
    <section class="home" id="home">
        <div class="header">
            <div class="greeting">
                <h1>Good Morning,</h1>
            </div>
            <div class="points-container">
                <i class='bx bx-gift'></i>
                <div class="vomo-points">
                    <span>VOMOPoints</span>
                    <span><?php echo $vomoPoints; ?></span>
                </div>
            </div>
        </div>
        <p>@<?php echo isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest'; ?></p>
    </section>

    <section class="store-vouchers" id="store-vouchers">
        <div class="voucher-card-container">
            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                <div class="voucher-card">
                    <div class="image-container">
                    <img src="data:image/jpeg;base64,<?php echo base64_encode($row['images']); ?>" alt="<?php echo htmlspecialchars($row['title']); ?>">
                    </div>
                    <div class="card-content">
                        <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                        <p>Points: <?php echo htmlspecialchars($row['points']); ?></p>
                        <a href="vol_voucherOverview.php?offerId=<?php echo $row['offerId']; ?>" class="btn">Redeem Now</a>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </section>

    <?php include "footer.php"; ?>

    <script src="script.js"></script>
</body>
</html>

<?php
        } else {
            echo "No vouchers found for " . htmlspecialchars($storeTitle) . "."; 
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing SQL statement: " . mysqli_error($conn);
    }

    mysqli_close($conn);

} else {
    echo "StoreId parameter is missing.";
}
?>
