<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up Page</title>
    <link rel="stylesheet" href="style.css">
    <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet'>
    <link rel="icon" type="image/x-icon" href="images/logo.jpg">
</head>
<body>
    <div class="signup-container">
        <form method="post" action="doSignup.php">
            <h2 class="text-center mb-4">Sign Up</h2>
            <div class="form-group">
                <label for="uname">Username</label>
                <input type="text" class="form-control" placeholder="Enter Username" name="username" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" placeholder="Enter Email" name="email" required>
            </div>

            <div class="form-group">
                <label for="psw">Password</label>
                <input type="password" class="form-control" placeholder="Enter Password" name="password" required>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-dark btn-block">Sign Up</button>
            </div>
            
            <p class="form-text text-center mt-3">Note: A link will be sent to your email for account verification purposes.</p>
        </form>
    </div>
</body>
</html>