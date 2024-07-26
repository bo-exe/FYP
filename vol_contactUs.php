<?php include "ft.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="icon" type="image/x-icon" href="images/logo.jpg">
    <link rel="stylesheet" href="style.css">
    <style>
        .container {
            background: #FFFFFF;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .btn {
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

        .btn:hover {
            background: #FFD036;
            color: #333; 
            border: .2rem solid transparent;
        }
        
        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
    <br>
    <div class="container">
    <img src="images/logo.jpg" alt="Description of the image" width="300" height="200">
        <form method="post" action="vol_doContactUs.php">
            <h2 class="text-center mb-4">Contact Us!</h2>
            <div class="form-group">
                <label for="date">Date of Issue</label>
                <input type="date" class="form-control" name="date" required>
            </div>
            <div class="form-group">
                <label for="uname">Username</label>
                <input type="text" class="form-control" placeholder="Enter Username" name="username" required>
            </div>
            <div class="form-group">
                <label for="description"></label>
                <input type="text" class="form-control" placeholder="Describe your problem.." name="description" required>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-dark btn-block">Submit form</button>
            </div>
        </form>
    </div>
    <p class="form-text text-center mt-3">Call for Support (8am to 8pm)!
        <br><br>
        +65 9999 9999 
        <br><br>
        Email for Support (8am to 8pm)!
        <br><br>
        vomosupport@gmail.com</p>
</body>
</html>
