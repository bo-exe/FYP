<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Navigation Bar</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        /* Navbar styling */
        .navbar-main {
            width: 100%;
            background-color: #FFD036;
            position: fixed;
            top: 0;
            left: 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
            z-index: 1000;
        }

        .logo {
            margin-right: auto;
        }

        .navbar-main ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            display: flex;
        }

        .navbar-main ul li {
            margin: 0;
            position: relative;
        }

        .navbar-main ul li a {
            display: block;
            padding: 14px 20px;
            text-decoration: none;
            color: #333;
            text-align: center;
        }

        .navbar-main ul li a:hover {
            background-color: #FFC107;
            color: #555;
        }

        .navbar-main ul li .nav-text {
            display: inline;
        }

        .navbar-main ul li .nav-icon {
            display: none;
        }

        .nav-scanner {
            display: none;
        }

        @media (max-width: 768px) {
            .navbar-main {
                top: auto;
                bottom: 0;
                flex-direction: column;
                align-items: flex-start;
                padding: 20px;
                display: block;
                width: 100%;
            }

            .logo,
            .search-bar,
            #profile {
                display: none;
            }

            .navbar-main ul {
                flex-direction: row;
                justify-content: space-around;
                width: 100%;
            }

            .navbar-main ul li .nav-text {
                display: none;
            }

            .navbar-main ul li .nav-icon {
                display: inline;
                font-size: 24px;
            }

            .navbar-main ul li a {
                padding: 10px;
            }

            .nav-stores {
                display: none;
            }

            .nav-scanner {
                display: inline;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar-main">
        <div class="logo">
            <img src="images/logo.jpg" alt="Logo" style="width: 100px;">
        </div>
        <ul>
            <li><a href="admin_volunteerHome.php"><span class="nav-text">HOME</span><i class="bi bi-house nav-icon"></i></a></li>
            <li class="nav-scanner"><a href="admin_allGigs.php"><span class="nav-text">MANAGE</span><i class="bi bi-person-lines-fill"></i></a></li>
            <li><a href="admin_volunteerProfile.php"><span class="nav-text">PROFILE</span><i class="bi bi-person nav-icon"></i></a></li>
        </ul>
    </nav>
    <script src="script.js"></script>
</body>
</html>
