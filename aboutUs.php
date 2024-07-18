<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <link rel="icon" type="image/x-icon" href="images/logo.jpg">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css">
    <style>
       
        .about-text h3 {
            font-size: 2rem;
            margin-bottom: 0.3rem;
            text-align: left;
        }

        .about-text p {
            font-size: 1.25rem;
            font-weight: 200;
            margin-bottom: 1rem; 
            text-align: left;
        }

        .about-image-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-left: 10px;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 80px;
            margin-bottom: 35px;
        }

        .container .about-text {
            flex: 1; 
            padding-right: 20px; 
            margin-left: 20px; 
        }

        .container .about-text p {
            margin-left: 20px; 
        }

        .container .about-image-container {
            flex: 1; 
            text-align: center;
        }

        .about-image {
            max-width: 75%; 
        }

    </style>
</head>
<body>
    <?php include "navbar.php"; ?>
    <?php include "ft.php"; ?>
    <div class="container">
        <div class="about-text">
            <h3>Who Are We.</h3>
            <p>Welcome to VOMO. We are a Technological Platform that links volunteers with community service and incentive opportunities. VOMO allows individuals to use our platforms to sign up and participate in volunteer work, which makes it more accessible, fulfilling, and integrated into their daily lives.</p>
        </div>
        <div class="about-image-container">
            <img src="images/logo.jpg" alt="about-logo" class="about-image">
        </div>
    </div>

    <div class="container">
        <div class="about-image-container">
            <img src="images/beach-clean.jpg" alt="about-logo" class="about-image">
        </div>
        <div class="about-text">
            <h3>Our Purpose.</h3>
            <p>We facilitate and promote volunteer engagement in Singapore by providing a platform to connect with individuals through community services and incentives. By inspiring individuals to become active participants, we build stronger and more vibrant communities.</p>
        </div>
    </div>

    <div class="container">
        <div class="about-text">
            <h3>Our Mission and Vision.</h3>
            <p>By providing accessible and fulfilling volunteer opportunities, we empower and inspire volunteers to have a positive effect on their communities. We strongly believe every act of service, no matter how big or small, is able to create meaningful changes in society and foster a culture of giving back to the community. VOMO envisions people getting acknowledgment and incentives for their community work, and incorporating volunteering as part of their daily lives.</p>
        </div>
        <div class="about-image-container">
            <img src="images/volunteer.jpg" alt="about-logo" class="about-image">
        </div>
    </div>

    <?php include "footer.php"; ?>

    <script src="script.js"></script>
</body>
</html>
