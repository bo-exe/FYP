<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="icon" type="image/x-icon" href="images/logo.jpg">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <br>
    <div class="login-container">
    <img src="images/logo.jpg" alt="Description of the image" width="300" height="200">
        <form method="post" action="doLogin.php">
            <h2 class="text-center mb-4">Forgot Your Password?</h2>
            <br><br>
            <p class="form-text text-center mt-3">Not to worry! We will send a link to your email for you to change your password
            <br><br>    
            <div class="form-group">
                <label for="uname">Email</label>
                <input type="text" class="form-control" placeholder="Enter Email" name="email" required>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-dark btn-block">Get Link!</button>
            </div>
        </form>
    </div>
</body>
</html>
