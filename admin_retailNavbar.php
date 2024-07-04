<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css" rel="stylesheet">
    <style>
    /* Navbar styling */
    .navbar-admin {
        width: 100%;
        background-color: #FFD036;
        position: fixed;
        top: 0;
        left: 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0 20px;
        z-index: 1000; /* Ensure navbar stays on top */
    }

    .logo img {
        width: 100px; /* Adjust logo width as needed */
        height: auto; /* Maintain aspect ratio */
    }

    .search-bar {
        margin-right: 20px;
    }

    .navbar-admin ul {
        list-style-type: none;
        margin: 0;
        padding: 0;
        display: flex;
    }

    .navbar-admin ul li {
        margin: 0;
    }

    .navbar-admin ul li a {
        display: flex;
        align-items: center;
        padding: 14px 20px;
        text-decoration: none;
        color: #333;
        text-align: center;
    }

    .navbar-admin ul li a:hover {
        background-color: #FFC107;
        color: #555;
    }

    .navbar-admin ul li a .icon {
        display: none;
        margin-left: 8px; /* Space between text and icon */
    }

    .content {
        margin-top: 50px;
        padding: 20px;
    }

    @media (max-width: 768px) {
        .navbar-admin {
            top: auto;
            bottom: 0;
            flex-direction: column;
            align-items: flex-start;
            padding: 20px;
        }

        .logo,
        .search-bar,
        #profile {
            display: none;
        }

        .navbar-admin ul li a span {
            display: none;
        }

        .navbar-admin ul li a .icon {
            display: inline-block;
        }
    }
</style>

</head>
<body>
<nav class="navbar-admin">
    <div class="logo">
        <img src="images/admin_logo.jpg" alt="Logo">
    </div>
    <ul>
        <li><a href="admin_retailHome.php"><span>HOME</span> <i class='bx bx-home icon'></i></a></li>
        <li><a href="admin_retailManage.php"><span>MANAGE</span> <i class='bx bx-cog icon'></i></a></li>
        <li><a href="admin_retailScanQR.php"><span>SCANNER</span> <i class='bx bx-scan icon'></i></a></li>
        <li><a href="admin_retailDashboard.php"><span>DASHBOARD</span> <i class='bx bx-bar-chart-alt icon'></i></a></li>
        <li><a href="admin_retailProfile.php"><span>PROFILE</span> <i class='bx bx-user icon' id="profile"></i></a></li>
    </ul>
</nav>
<script src="script.js"></script>
</body>
</html>
