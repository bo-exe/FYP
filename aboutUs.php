<?php include "navbar.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navigation Bar</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css">
    <style>
        /* <!-- About Section --> */
        .about-content h3 {
            font-size: 2rem;
            margin-bottom: 0.3rem;
            text-align: left;
        }

        .about-content p {
            font-size: 1.25rem;
            font-weight: 200;
            margin-bottom: 0.3rem;
            text-align: left;
            margin-left: 25px;
        }

        .about-content {
            max-width: 44rem;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .about-image-container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            margin-left: 20px;
        }

        .about-container2 {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 100px;
            margin-bottom: 100px;
        }

        .about-container2 .about-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .about-text {
            margin-bottom: 20px;
            font-size: 1.6rem;
        }

        .about-image {
            margin-left: 200px;
            justify-content: center;
        }

        .about-container-reverse {
            display: flex;
            flex-direction: row;
            padding: 100px;
            margin-bottom: 100px;
        }

        .about-container-reverse .about-content {
            text-align: left;
        }

    </style>
</head>
<body>
    <section class="about" id="about">
        <div class="about-container2">
            <div class="about-content">
                <div class="about-text">
                    <br><br>
                    <h3>Who Are We.</h3>
                    <br>
                    <p>Welcome to VOMO. We are a Technological Platform that links volunteers with community service and incentive 
                    opportunities. VOMO allows individuals to use our platforms to sign up and participate in volunteer work, which 
                    makes it more accessible, fulfilling and integrated into their daily lives. </p>
                </div>
            </div>
            <div class="about-image-container">
                <img src="images/logo.jpg" alt="about-logo" class="about-image" style="width: 400px;">
            </div>
        </div>
    </section>

    <section class="about" id="about">
        <div class="about-container-reverse">
            <div class="about-image-container">
                <img src="images/beach-clean.jpg" alt="about-logo" class="about-image" style="width: 400px;">
            </div>
            <div class="about-content">
                <div class="about-text">
                    <br><br>
                    <h3>Our Purpose.</h3>
                    <br>
                    <p>We facilitate and promote volunteer engagement in Singapore by providing a platform to connect with 
                    individuals through community services and incentives. By inspiring individuals to become active participants, 
                    we build stronger and more vibrant communities.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="about" id="about">
        <div class="about-container2">
            <div class="about-content">
                <div class="about-text">
                    <br><br>
                    <h3>Our Mission and Vision.</h3>
                    <br>
                    <p>By providing accessible and fulfillable volunteer opportunities, we empower and inspire volunteers 
                        to have a positive effect on their communities. We strongly believe every act of service, no matter how
                        big or small, is able to create meaningful changes in the society and to foster a culture to give back to the community. 
                        VOMO envisions people to get acknowledge and given incentives for their community work, and incorporate 
                        volunteering as part of their daily lives.</p>
                </div>
            </div>
            <div class="about-image-container">
                <img src="images/volunteer.jpg" alt="about-logo" class="about-image" style="width: 400px;">
            </div>
        </div>
    </section>

    <?php include "footer.php"; ?>

    <script src="script.js"></script>
</body>
</html>
