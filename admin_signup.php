<?php
include "ft.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="style.css">
</head>
<style>
    body {
    background-color: #f7f7f7;
}

h2 {
    margin-bottom: 20px;
}

.form-group {
    margin-bottom: 15px;
}

.form-control {
    width: 100%;
    padding: 10px;
    margin: 5px 0 10px 0;
    display: inline-block;
    border: 1px solid #ccc;
    box-sizing: border-box;
}

.btn {
    background-color: #333;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    cursor: pointer;
    width: 100%;
}

.btn:hover {
    opacity: 0.8;
}

.login-container, .signup-container {
    width: 100%;
    max-width: 400px;
    margin: auto;
    padding: 20px;
    background-color: #FFD036;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    margin-top: 50px;
    text-align: center;
}

.form-check {
    text-align: left;
}

.form-text {
    color: #666;
}
</style>
<body>
    <br>
    <br>
    <div class="signup-container">
        <img src="images/admin_logo.jpg" alt="Description of the image" width="300" height="200">
        <form action="admin_doSignup.php" method="POST" enctype="multipart/form-data">
            <h2 class="text-center mb-4">Sign Up</h2>
            <div class="form-group">
                <label for="company">Company:</label>
                <input type="text" class="form-control" placeholder="Enter Company" id="company" name="company" required>
            </div>
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" class="form-control" placeholder="Enter Username" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" placeholder="Enter Password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" placeholder="Enter Name" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="number">Phone Number:</label>
                <input type="text" class="form-control" placeholder="Enter Phone Number" id="number" name="number" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" placeholder="Enter Email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="role">Role:</label>
                <select class="form-control" id="role" name="role" required>
                    <option value="retailAdmin">Retail Admin</option>
                    <option value="cashierAdmin">Cashier Admin</option>
                    <option value="volunteerAdmin">Volunteer Admin</option>
                    <option value="vomoAdmin">Vomo Admin</option>
                </select>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-dark btn-block">Sign Up</button>
            </div>
        </form>
    </div>
    <p class="form-text text-center mt-3">Already a member? <a href="admin_login.php">Login</a> now!</p>
    <br></br>
</body>
</html>
