<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback</title>
    <link rel="icon" type="image/x-icon" href="images/logo.jpg">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <br>
    <div class="login-container">
    <img src="images/logo.jpg" alt="Description of the image" width="300" height="200">
        <form method="post" action="doLogin.php">
            <h2 class="text-center mb-4">Feeback Form</h2>
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
                <input type="text" class="form-control" placeholder="Give us your feedback.." name="description" required>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-dark btn-block">Submit form</button>
            </div>
        </form>
    </div>
</body>
</html>
