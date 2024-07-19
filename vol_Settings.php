<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/x-icon" href="images/logo.jpg">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
    <style>
        .settings-container {
            background-color: #FFF;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);    
            max-width: 400px;
            margin: 0 auto;
            margin-bottom: 30px;
            margin-top: 80px;
        }

        .privacy-settings h2, .other-settings h2 {
            background-color: #FFD036;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            padding: 10px;
            margin-top: 0;
            text-align: center;
            color: #333;
        }

        .setting-item {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .setting-item i {
            font-size: 24px;
            margin-right: 10px;
            color: #333;
        }

        .setting-item label {
            font-weight: bold;
            margin-right: 10px;
            flex-basis: 200px;
            color: #333;
        }

        .setting-item span {
            color: #666;
        }

        .setting-item span a {
            color: #666;
            text-decoration: none;
        }

        .btn-container {
            text-align: center;
        }

        .btn-container .btn {
            padding: 0.3rem 0.7rem;
            background: #FFD036;
            border-radius: .6rem;
            box-shadow: 0 .2rem .5rem #333;
            font-size: 0.8rem;
            color: #333;
            letter-spacing: .1rem;
            font-weight: 600;
            border: .2rem solid transparent;
            margin-top: 16px;
            text-decoration: none;
            text-align: center;
        }

        .btn-container .btn:hover {
            padding: 0.3rem 0.7rem;
            background: #FFD036;
            border-radius: .6rem;
            box-shadow: 0 .2rem .5rem #333;
            font-size: 0.8rem;
            color: #333;
            letter-spacing: .1rem;
            font-weight: 600;
            border: .2rem solid transparent;
            margin-top: 16px;
            text-decoration: none;
            text-align: center;
        }

        .btn:active {
            background-color: #deb530;
        }

        input[type="text"]:focus,
        input[type="password"]:focus,
        button:focus {
            outline: none;
            box-shadow: 0 0 5px #FFD036;
        }

        .back-button {
            display: none;
            position: absolute;
            top: 10px;
            left: 10px;
            font-size: 1.5rem;
            background-color: #FFD036;
            padding: 5px 10px;
            border-radius: 5px;
            text-decoration: none;
            color: #333;
            margin-top: 80px;
        }

        .back-button:hover {
            background-color: #deb530;
        }

        @media screen and (max-width: 768px) {
            .settings-container {
                margin-bottom: 120px;
            }

            .back-button {
                display: inline;
                margin-top: 10px;
                position: fixed;
            }
        }
    </style>
</head>
<body>
    <?php include "ft.php"; ?>  
    <?php include "vol_Navbar.php"; ?>  

    <a href="vol_Profile.php" class="back-button">&lt;</a>

    <div class="settings-container">
        <img src="images/logo.jpg" alt="Description of the image" width="300" height="200">
        
        <section class="privacy-settings">
            <h2 class="text-center mb-4">Privacy</h2>
            <div class="setting-item">
                <i class="bx bx-map"></i>
                <label>Location Sharing:</label>
                <span>Enabled</span>
            </div>
            <div class="setting-item">
                <i class="bx bx-bell"></i>
                <label>Notification Preferences:</label>
                <span>Enabled</span>
            </div>
            <div class="setting-item">
                <i class="bx bx-shield"></i>
                <label>Account Security:</label>
                <span>Enabled</span>
            </div>
        </section>

        <section class="other-settings">
            <h2 class="text-center mb-4">Others</h2>
            <div class="setting-item">
                <i class="bx bx-globe"></i>
                <label>Language Preference:</label>
                <span>English</span>
            </div>
            <div class="setting-item">
                <i class="bx bx-check"></i>
                <label>Policies Accepted:</label>
                <span>Yes</span>
            </div>
            <div class="setting-item">
                <i class="bx bx-user-x"></i>
                <label>Request Account Termination:</label>
                <span><a href="#">Request Now</a></span>
            </div>
            <div class="setting-item">
                <i class="bx bx-like"></i>
                <label>Like our App? Rate Us:</label>
                <span><a href="vol_feedback.php">Rate Now</a></span>
            </div>
        </section>

        <div class="btn-container">
            <form action="vol_logout.php" method="post">
                <button type="submit" class="btn btn-danger">Logout</button>
            </form>
        </div>
    </div>
    <?php include "vol_footer.php"; ?>
</body>
</html>
