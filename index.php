<?php
session_start();
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

        .home h1, p {
            margin-right: 800px;
            text-align: left;
        }

        .container {
            padding: 2rem;
            margin-top: 20px; 
            margin-right: 800px;
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
            border-radius: .6rem;
            box-shadow: 0 .1rem .25rem #333;
            font-size: 0.8rem;
            color: #333 ;
            letter-spacing: .1rem;
            font-weight: 600;
            border: .2rem solid transparent;
            transition: .5s ease;
            margin-top: 30px;
            margin-left: 300px;
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

        * {
            box-sizing: border-box;
        }

        .mySlides {
            display:none
        }
        .w3-left, .w3-right, .w3-badge {
            cursor:pointer
        }
        .w3-badge {
            height:13px;width:13px;padding:0
        }

        /* Responsive styling */
        @media (max-width: 1200px) {
            .home h1, p {
                margin-right: 20px; /* Adjust margin for smaller screens */
            }
            .container {
                margin-right: 20px; /* Adjust margin for smaller screens */
            }
            .about-btn {
                margin-left: 20px; /* Adjust margin for smaller screens */
            }
        }

        @media (max-width: 768px) {
            .home h1 {
                font-size: 1.5rem; /* Decrease font size for smaller screens */
            }
            .home p {
                font-size: 0.875rem; /* Decrease font size for smaller screens */
            }
            .container {
                padding: 1rem; /* Decrease padding for smaller screens */
            }
            .container h2 {
                font-size: 1.25rem; /* Decrease font size for smaller screens */
            }
            .slider img {
                width: 100%; /* Ensure images take full width on smaller screens */
            }
            .about-btn {
                padding: 0.5rem 1rem; /* Increase padding for smaller screens */
                margin-top: 10px; /* Adjust margin for smaller screens */
            }
            .points-container {
                font-size: 0.875rem; /* Decrease font size for smaller screens */
                padding: 8px; /* Decrease padding for smaller screens */
            }
            .points-container .vomo-points span:first-child {
                margin-right: 10px; /* Adjust margin for smaller screens */
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
                <h1>Good Morning,</h1>
            </div>
            <div class="points-container">
                <i class='bx bx-gift'></i>
                <div class="vomo-points">
                    <span>VOMOPoints</span>
                    <span>0</span>
                </div>
            </div>
        </div>
        <p>@<?php echo isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest'; ?></p>
    </section>
        
    <section class="container">
    <h2>Recommended Activities</h2>
    <div class="slider-wrapper">
        <div class="slider" id="activity-slider">
            <img src="images/volunteer-booth.jpg" alt="activity 1">
            <img src="images/education.jpg" alt="activity 2">
            <img src="images/clean.jpg" alt="activity 3">
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

    <?php include "footer.php"; ?>

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
            if (n > slides.length) {slideIndex = 1}
            if (n < 1) {slideIndex = slides.length}
            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";  
            }
            for (i = 0; i < dots.length; i++) {
                dots[i].className = dots[i].className.replace(" active", "");
            }
            slides[slideIndex-1].style.display = "block";  
            dots[slideIndex-1].className += " active";
        }
    </script>
</body>
</html>
