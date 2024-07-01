<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
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
            display: block;
            padding: 14px 20px;
            text-decoration: none;
            color: #333;
            text-align: center;
        }

        .navbar-admin ul li a:hover {
            background-color: #FFC107;
            color: #555;
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
        }
    </style>
</head>
<body>
<nav class="navbar-admin">
    <div class="logo">
        <img src="images/admin_logo.jpg" alt="Logo">
    </div>
    <ul>
        <li><a href="admin_retailHome.php">HOME</a></li>
        <li><a href="admin_retailManage.php">MANAGE</a></li>
        <li><a href="admin_retailScanner.php">SCANNER</a></li>
        <li><a href="admin_retailDashboard.php">DASHBOARD</a></li>
        <li><a href="admin_retailProfile.php"><i class='bx bx-user' id="profile"></i></a></li>
    </ul>
</nav>
<script src="script.js"></script>
</body>
</html>
