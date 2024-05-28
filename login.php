<?php include "navbar.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <br>
    <div class="login-container">
        <form method="post" action="doLogin.php">
            <h2 class="text-center mb-4">Login</h2>
            <div class="form-group">
                <label for="uname">Username</label>
                <input type="text" class="form-control" placeholder="Enter Username" name="username" required>
            </div>
            <div class="form-group">
                <label for="psw">Password</label>
                <input type="password" class="form-control" placeholder="Enter Password" name="password" required>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-dark btn-block">Login</button>
            </div>
            <div class="form-check mt-3">
                <input type="checkbox" class="form-check-input" id="remember" checked="checked" name="remember">
                <label class="form-check-label" for="remember">Remember me</label>
            </div>
        </form>
    </div>
    <p class="form-text text-center mt-3">Not a member yet? <a href="Register.php">Register</a> now!</p>
</body>
</html>