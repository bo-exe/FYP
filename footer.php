<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Footer</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Footer Section */
.footer {
    width: 100%;
    background-color: #ECECE7;
    padding: 20px 0;
    text-align: center;
    position: relative;
    bottom: 0;
}

.footer-content {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 20px;
}

.footer-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 80%;
    max-width: 1200px;
    margin: 0 auto;
}

.logo-container {
    display: flex;
    align-items: center;
}

.logo {
    width: 100px;
    margin-right: 10px;
}

.footer-columns {
    display: flex;
    justify-content: space-between;
    width: 100%;
}

.footer-column {
    margin-left: 20px;
}

.footer h4 {
    color: #333;
    margin: 0;
    font-size: 18px;
}

.social-section {
    margin-bottom: 20px;
}

.social-icons {
    display: flex;
    justify-content: center;
    gap: 15px;
}

.social-icons a {
    display: inline-flex;
    justify-content: center;
    align-items: center;
    width: 40px;
    height: 40px;
    border: 2px solid #333;
    border-radius: 50%;
    font-size: 20px;
    color: #333;
    transition: background-color 0.3s, color 0.3s;
}

.social-icons a:hover {
    background-color: #333;
    color: #fff;
}

.footer-content h4 {
    color: #333;
    margin-bottom: 10px;
}

.footer-content li {
    list-style: none;
    margin-bottom: 8px;
}

.footer-content li a {
    color: #333;
    text-decoration: none;
    transition: color 0.3s;
}

.footer-content li a:hover {
    color: #ff7f7f;
}

.footer-iconTop {
    margin-top: 20px;
}

.footer-iconTop a {
    display: inline-flex;
    justify-content: center;
    align-items: center;
    padding: .8rem;
    background: var(--white-color);
    border-radius: .8rem;
    border: .2rem solid #333;
    outline: .3rem solid transparent;
    transition: .5s ease;
}

.footer-iconTop a:hover {
    color: #fff;
}

.copyright {
    font-size: 14px;
    color: #333;
    margin-top: 20px;
}

@media (max-width: 768px) {
    .footer {
        display: none;
    }
}
</style>
</head>
<body>
    <!-- Footer Section -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-row">
            <a href="index.php">
                <div class="logo-container">
                    <img src="images/logo.jpg" alt="logo" class="logo">
                </div>
            </a>
                <div class="footer-columns">
                    <div class="footer-column">
                        <h4>ABOUT</h4>
                        <ul>
                            <li><a href="aboutUs.php#about">About VOMO</a></li>
                        </ul>
                    </div>
                    <div class="footer-column">
                        <h4>CONTACT US</h4>
                        <ul>
                            <li><a href="feedback.php">Feedback</a></li>
                            <li><a href="contactUs.php">Support Us</a></li>
                        </ul>
                    </div>
                    <div class="footer-column">
                        <h4 class="social-text">SOCIALS:</h4>
                        <div class="social-icons">
                            <a href="https://www.instagram.com/vomo/?hl=en"><i class='bx bxl-instagram'></i></a>
                            <a href="https://web.telegram.org/a/#vomo"><i class='bx bxl-telegram'></i></a>
                            <a href=""><i class='bx bxl-tiktok'></i></a>
                            <a href="https://mail.google.com/mail/u/0/?hl=en#inbox?compose=new"><i class='bx bx-envelope'></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-iconTop">
                <a href="index.php"><i class='bx bx-up-arrow-alt'></i></a>
            </div>
            <div class="copyright">
                <p>&copy; VOMO. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

    <script src="script.js"></script>
</body>
</html>
