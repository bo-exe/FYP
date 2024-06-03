<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
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

        .home h1, p{
            margin-right: 800px;
            text-align: left;
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
            height: 100%;
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
            align-self: flex-end;
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
    <?php include "navbar.php"; ?>
    <?php include "ft.php"; ?>
    
    <section class="home" id="home">
        <div class="header">
            <div class="greeting">
                <h1>All Vouchers</h1>
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

    <div class="voucher-card-container">
        <div class="voucher-card">
            <img src="images/NTUCvoucher.jpg">
            <div class="card-content">
                <h3>NTUC</h3>
                <p>3 Vouchers</p>
                <a href="ntuc_vouchers.php" class="btn">More</a>
            </div>
        </div>

        <div class="voucher-card">
            <img src="images/ikea-voucher.jpg">
            <div class="card-content">
                <h3>IKEA</h3>
                <p>5 Vouchers</p>
                <a href="ikea_vouchers.php" class="btn">More</a>
            </div>
        </div>

        <div class="voucher-card">
            <img src="images/giant-voucher.jpg">
            <div class="card-content">
                <h3>Giant</h3>
                <p>5 Vouchers</p>
                <a href="giant_vouchers.php" class="btn">More</a>
            </div>
        </div>

        <div class="voucher-card">
            <img src="images/body-shop-voucher.jpg">
            <div class="card-content">
                <h3>The Body Shop</h3>
                <p>5 Vouchers</p>
                <a href="body_shop_vouchers.php" class="btn">More</a>
            </div>
        </div>
    </div>

    <?php include "footer.php"; ?>

    <script src="script.js"></script>
</body>
</html>
