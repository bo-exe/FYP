<?php
// Include your database connection file
include 'dbFunctions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process password reset
    $token = $_POST['token'];
    $newPassword = $_POST['password'];
    $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

    // Validate token and expiration
    $query = "SELECT * FROM password_resets WHERE token = ? AND expires_at > NOW()";
    $stmt = $link->prepare($query);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();
    $resetRecord = $result->fetch_assoc();
    $stmt->close();

    if (!$resetRecord) {
        echo "Invalid or expired token.";
        exit();
    }

    // Update the user's password
    $volunteerID = $resetRecord['volunteerID'];
    $updateQuery = "UPDATE volunteers SET password = ? WHERE volunteerId = ?";
    $updateStmt = $link->prepare($updateQuery);
    $updateStmt->bind_param("si", $hashedPassword, $volunteerID);
    $updateStmt->execute();
    $updateStmt->close();

    // Delete the password reset record
    $deleteQuery = "DELETE FROM password_resets WHERE token = ?";
    $deleteStmt = $link->prepare($deleteQuery);
    $deleteStmt->bind_param("s", $token);
    $deleteStmt->execute();
    $deleteStmt->close();

    echo "Password has been reset successfully.";
    header("Location: vol_login.php");
    exit();
} else {
    // Display password reset form
    $token = $_GET['token'];
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Reset Password</title>
        <link rel="stylesheet" href="style.css">
        <style>
            .container {
                max-width: 500px;
                margin: auto;
            }
            .btn {
                display: inline-block;
    padding: 0.3rem 0.7rem;
    background: #FFD036 !important;
    border-radius: 0.6rem;
    box-shadow: 0 0.1rem 0.25rem #333;
    font-size: 0.8rem;
    color: #333 !important;
    letter-spacing: 0.1rem;
    font-weight: 600;
    border: 0.2rem solid transparent;
    transition: 0.5s ease;
    text-decoration: none;
            }
            .yellow-container{
                background-color: #FFD036;
                padding: 30px 10px;
                margin-bottom: 100px;
            }
            .yellow-container img {
                display: block;
                max-width: 300px;
                margin: auto;

            }
        </style>
    </head>
    <body>
    <?php include "vol_navbar.php"; ?>
     
        <div class="container">
            <form method="post">
                <h2 class="text-center mb-4" style="margin-top:40px"></h2>
                <div class="yellow-container" >
                    <img src="./images/logo.jpg" alt="">
                </div>
                <div class="form-group">
                    <label for="password">New Password</label>
                    <input type="password" class="form-control" placeholder="Enter New Password" name="password" required>
                </div>
                <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
                <div class="text-center">
                    <button type="submit" class="btn btn-block">Reset Password</button>
                </div>
            </form>
        </div>
        <?php include "vol_footer.php"; ?>
    </body>
    </html>
    <?php
}
?>
