<?php
session_start();
include "dbFunctions.php";

// Connect to the database
$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch VOMOPoints for the logged-in user
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
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Home Page</title>
        <link rel="icon" type="image/x-icon" href="images/logo.jpg">
        <link rel="stylesheet" href="style.css">
        <script src="script.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
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

            .home h1,
            p {
                text-align: left;
            }

            .container {
                padding: 2rem;
                margin-top: 20px;
            }

            .container h2 {
                text-align: left;
            }

            .slider-wrapper {
                position: relative;
                max-width: 48rem;
                margin: 0 auto;
            }

            .slider {
                display: flex;
                overflow: hidden;
                position: relative;
                z-index: 1;
            }

            .slider img {
                width: 100%; 
                height: 300px; 
                object-fit: cover; 
                flex: 0 0 100%;
                transition: transform 0.5s ease;
            }

            .slider-nav {
                display: flex;
                justify-content: center;
                position: absolute;
                bottom: 1.25rem;
                left: 50%;
                transform: translateX(-50%);
                z-index: 2;
            }

            .slider-nav .dot {
                height: 10px;
                width: 10px;
                background-color: #fff;
                opacity: 0.75;
                border: 2px solid #fff;
                border-radius: 50%;
                margin: 0 5px;
                cursor: pointer;
                transition: opacity 0.3s;
            }

            .slider-nav .dot.active {
                opacity: 1;
                background-color: #FFD036;
            }

            .slider::-webkit-scrollbar {
                display: none;
            }

            .slider {
                -ms-overflow-style: none;
                scrollbar-width: none;
            }

            .about-btn {
                display: inline-block;
                padding: 0.3rem 0.7rem;
                background: #FFD036;
                border-radius: 0.6rem;
                box-shadow: 0 0.1rem 0.25rem #333;
                font-size: 0.8rem;
                color: #333;
                letter-spacing: 0.1rem;
                font-weight: 600;
                border: 0.2rem solid transparent;
                transition: 0.5s ease;
                margin-top: 30px;
                margin-left: 480px;
                text-decoration: none;
            }

            .about-btn:hover {
                background: #deb530;
                color: #333;
                text-decoration: none;
            }

            .header {
                display: flex;
                align-items: center;
            }

            .home .greeting {
                margin-right: 650px;
            }

            .points-container {
                display: flex;
                align-items: center;
                justify-content: left;
                font-size: 14px;
                color: #333;
                background-color: #ECECE7;
                border-radius: 0.6rem;
                box-shadow: 0 0.2rem 0.5rem #333;
                letter-spacing: 0.2rem;
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

            .main-container {
                display: flex;
                justify-content: space-between;
            }

            .main-container section {
                flex: 1;
            }

            .fc-toolbar-chunk {
                display: flex !important;
            }

            /* Yellow Container */
            .yellow-container {
                background-color: #FFD036;
                color: #333;
                text-align: left;
                padding: 15px;
                box-sizing: border-box;
                margin-bottom: 20px;
                display: none; /* Initially hidden */
            }

            .yellow-container h1,
            .yellow-container h2,
            .yellow-container p {
                text-align: left;
                padding-left: 20px;
                margin: 0;
            }

            .yellow-container .points-container {
                display: flex;
                align-items: center;
                justify-content: left;
                font-size: 14px;
                color: #333;
                background-color: #ECECE7;
                border-radius: 0.6rem;
                box-shadow: 0 0.2rem 0.5rem #333;
                letter-spacing: 0.2rem;
                font-weight: 800;
                padding: 10px;
                margin-top: 10px;
                display: none; 
            }

            @media (max-width: 768px) {
                .home h1, p {
                    margin-right: 20px;
                }

                .container {
                    padding: 1rem;
                    padding-bottom: 115px;
                }

                .container h2 {
                    font-size: 1.25rem;
                }

                .slider img {
                    width: 100%;
                }

                .about-btn {
                    padding: 0.5rem 1rem;
                    margin-top: 10px;
                    display: inline-block;
                    padding: 0.3rem 0.7rem;
                    background: #FFD036;
                    border-radius: 0.6rem;
                    box-shadow: 0 0.1rem 0.25rem #333;
                    font-size: 0.8rem;
                    color: #333;
                    letter-spacing: 0.1rem;
                    font-weight: 600;
                    border: 0.2rem solid transparent;
                    transition: 0.5s ease;
                    margin-top: 30px;
                    margin-left: 450px;
                    text-decoration: none;
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
        
                .home {
                    display: none;
                }

                .points-container {
                    display: flex;
                    align-items: center;
                    justify-content: left;
                    font-size: 14px;
                    color: #333;
                    background-color: #ECECE7;
                    border-radius: 0.6rem;
                    box-shadow: 0 0.2rem 0.5rem #333;
                    letter-spacing: 0.1rem;
                    font-weight: 800;
                    padding: 10px;
                    max-width: 300px;
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
                    border-radius: 0.6rem;
                    box-shadow: 0 0.2rem 0.5rem #333;
                    letter-spacing: 0.2rem;
                    font-weight: 800;
                    padding: 10px;
                }
                .calendar {
                    display: none;
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

        <div class="yellow-container">
            <h1><b>Explore!</b></h1>
            <h2>Good Morning,</h2>
            <p>@<?php echo isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest'; ?></p>
            <div class="points-container">
                <i class='bx bx-gift'></i>
                <div class="vomo-points">
                    <span>VOMOPoints</span>
                    <span><?php echo $vomoPoints; ?></span>
                </div>
            </div>
        </div>

       <main class="main-container">
       <section class="left">
       <section class="container">
            <h2>Recommended Activities</h2>
            <div class="slider-wrapper">
                <div class="slider" id="activity-slider">
                    <img src="images/volunteer-booth.jpg" alt="activity">
                    <img src="images/work2.jpg" alt="activity">
                    <img src="images/clean.jpg" alt="activity">
                </div>
                <div class="slider-nav" id="activity-slider-nav">
                    <span class="dot" onclick="currentSlide(1, 'activity-slider')"></span>
                    <span class="dot" onclick="currentSlide(2, 'activity-slider')"></span>
                    <span class="dot" onclick="currentSlide(3, 'activity-slider')"></span>
                </div>
            </div>
            <a href="all_activities.php" class="about-btn">See More</a>
        </section>

        <section class="container">
            <h2>Recommended Stores</h2>
            <div class="slider-wrapper">
                <div class="slider" id="store-slider">
                    <img src="images/ikea.jpg" alt="store 1">
                    <img src="images/Giant.jpg" alt="store 2">
                    <img src="images/thebodyshop.jpg" alt="store 3">
                </div>
                <div class="slider-nav" id="store-slider-nav">
                    <span class="dot" onclick="currentSlide(1, 'store-slider')"></span>
                    <span class="dot" onclick="currentSlide(2, 'store-slider')"></span>
                    <span class="dot" onclick="currentSlide(3, 'store-slider')"></span>
                </div>
            </div>
            <a href="all_stores.php" class="about-btn">See More</a>
        </section>
       </section>

        <section class="right calendar">
            <?php

            include "vol_allYourActivities.php";

            ?>
            <a href="vol_allYourActivities.php" class="about-btn">See More</a>
        </section>
       </main>
        <?php include "vol_footer.php"; ?>

        <script>
            let slideIndex = 1;
showSlides(slideIndex, 'activity-slider');
showSlides(slideIndex, 'store-slider');

function currentSlide(n, sliderId) {
showSlides(slideIndex = n, sliderId);
}

function showSlides(n, sliderId) {
let i;
let slides = document.querySelectorAll(`#${sliderId} img`);
let dots = document.querySelectorAll(`#${sliderId}-nav .dot`);
if (n > slides.length) {
slideIndex = 1
}
if (n < 1) {
slideIndex = slides.length
}
for (i = 0; i < slides.length; i++) {
slides[i].style.display = "none";
}
for (i = 0; i < dots.length; i++) {
dots[i].className = dots[i].className.replace(" active", "");
}
slides[slideIndex - 1].style.display = "block";
dots[slideIndex - 1].className += " active";
}
        </script>
    </body>
</html>

