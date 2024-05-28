<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navigation Bar</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include "navbar.php"; ?>

    <div id="home" style="padding:20px;">
        <h1>Home</h1>
        <p>Welcome to the home page!</p>
    </div>
    <div id="about" style="padding:20px;">
        <h1>About</h1>
        <p>Learn more about us here.</p>
    </div>
    <div id="services" style="padding:20px;">
        <h1>Services</h1>
        <p>These are the services we offer.</p>
    </div>
    <div id="contact" style="padding:20px;">
        <h1>Contact</h1>
        <p>Get in touch with us.</p>
    </div>

      <!-- Footer Section -->
      <footer class="footer">
        <div class="footer-content">
            <div class="logo-container">
                <img src="images/logo.png" alt="logo" style="width:100px;">
            </div>
        </div>
        <div class="footer-content">
            <h4>ABOUT</h4>
            <ul>
                <li><a href="index.html#about">About VOMO</a></li>
            </ul>
        </div>
        <div class="footer-content">
            <h4>CONTACT US</h4>
            <ul>
                <li><a href="index.html#contact">Feedback</a></li>
                <li><a href="index.html#contact">Support Us</a></li>
            </ul>
        </div>
        <div class="footer-content">
            <div class="social-section">
                <h4 class="social-text">Socials:</h4>
                <div class="social-icons">
                    <a href="https://www.instagram.com/vomo/?hl=en"><i class='bx bxl-instagram'></i></a>
                    <a href="https://web.telegram.org/a/#vomo"><i class='bx bxl-telegram'></i></a>
                    <a href="https://api.whatsapp.com/send/?phone=%2B90716235&text&type=phone_number&app_absent=0"><i
                            class='bx bxl-whatsapp'></i></a>
                    <a href="https://mail.google.com/mail/u/0/?hl=en#inbox?compose=new"><i
                            class='bx bx-envelope'></i></a>
                </div>
            </div>
        </div>
        <div class="footer-iconTop">
            <a href="index.php"><i class='bx bx-up-arrow-alt'></i></a>
        </div>
        <div class="copyright">
            <p>Copyright © VOMO.</p>
        </div>
    </footer>
    <script src="script.js"></script>
</body>
</html>