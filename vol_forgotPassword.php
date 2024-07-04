<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
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
        <form method="post" action="doForgotPassword.php">
            <h2 class="text-center mb-4">Forgot Your Password?</h2>
            <br><br>
            <p class="form-text text-center mt-3">Not to worry! We will send a link to your email for you to change your password</p>
            <br><br>    
            <div class="form-group">
                <label for="uname">Email</label>
                <input type="text" class="form-control" placeholder="Enter Email" name="email" required>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-block">Get Link!</button>
            </div>
        </form>
    </div>
</body>
</html>

   