<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Navigation Bar</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
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

        /* Dropdown styling */
        .navbar-main ul li ul {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            background-color: #FFD036;
            padding: 0;
            margin: 0;
            width: 200px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            z-index: 1000;
        }

        .navbar-main ul li:hover>ul {
            display: block;
        }

        .navbar-main ul li ul li {
            margin: 0;
        }

        .navbar-main ul li ul li a {
            padding: 10px;
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

            .logo {
                display: none;
                /* Hide logo on mobile */
            }

            .navbar-main ul {
                flex-direction: row;
                flex-wrap: wrap;
                justify-content: center;
                width: 100%;
                padding: 0;
            }

            .navbar-main ul li {
                display: flex;
                justify-content: center;
                align-items: center;
            }

            .navbar-main ul li .nav-text {
                display: none;
            }

            .navbar-main ul li .nav-icon {
                display: inline;
                font-size: 24px;
            }

            .navbar-main ul li ul {
                position: static;
                display: none;
                width: 100%;
            }

            .navbar-main ul li.active>ul {
                display: block;
            }

            .navbar-main ul li ul li a {
                padding: 10px;
            }

            .nav-stores {
                display: none;
            }

            .nav-scanner {
                display: inline;
            }
        }

        .bi.bi-ticket-perforated {
            font-size: 24px;
        }

        .bi.bi-calendar {
            font-size: 24px;
        }
    </style>
</head>

<body>
    <nav class="navbar-main">
        <div class="logo">
            <img src="images/admin_logo.jpg" alt="Logo" style="width: 100px;">
        </div>
        <ul>
            <li><a href="admin_teamHome.php"><span class="nav-text">HOME</span><i class="bi bi-house nav-icon"></i></a>
            </li>
            <li>
                <a href="#"><span class="nav-text">MANAGE</span><i class="bi bi-gear nav-icon"></i></a>
                <ul>
                    <li><a href="admin_teamManageOffers.php"><span class="nav-text">MANAGE CURRENT OFFERS</span><i
                                class="bi bi-ticket-perforated nav-icon"></i></a></li>
                    <li><a href="admin_teamManageGigs.php"><span class="nav-text">MANAGE CURRENT GIGS</span><i
                                class="bi bi-calendar nav-icon"></i></a></li>
                </ul>
            </li>
            <li>
                <a href="#"><span class="nav-text">SIGN UPS</span><i class="bi bi-person-check nav-icon"></i></a>
                <ul>
                    <li><a href="admin_teamManageGigs.php"><span class="nav-text">VOLUNTEER SIGNUPS</span><i
                                class="bi bi-bicycle nav-icon"></i></a></li>
                    <li><a href="admin_RetailReq.php"><span class="nav-text">RETAIL ORG SIGNUPS</span><i
                                class="bi bi-shop-window nav-icon"></i></a></li>
                </ul>
            </li>
            <li><a href="admin_teamProfile.php"><span class="nav-text">PROFILE</span><i
                        class="bi bi-person nav-icon"></i></a></li>
        </ul>
    </nav>
    <script src="script.js"></script>
</body>

</html>