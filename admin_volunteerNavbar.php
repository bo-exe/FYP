<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Navigation Bar</title>
    <link rel="stylesheet" type="text/css" href="volunteeradminstyle.css">
</head>
<body>
    <nav class="navbar-volunteeradmin">
        <div class="navbar-volunteeradmin-logo">
            <img src="images/admin_logo.jpg" alt="Logo" style="width: 100px;">
        </div>
        <ul>
            <li>
                <a href="admin_volunteerHome.php">
                    <img src="images/navhome.png" alt="Home Icon" class="volunteernav-icon">
                    HOME
                </a>
            </li>

            <li>
                <a href="admin_allGigs.php">
                    <img src="images/navmanage.png" alt="Manage Icon" class="volunteernav-icon">
                    MANAGE
                </a>
            </li>

            <li>
                <a href="admin_gigMilestone.php">
                    <img src="images/navmilestones.png" alt="Milestones Icon" class="volunteernav-icon">
                    DASHBOARD
                </a>
            </li>

            <li>
                <a href="admin_volunteerProfile.php">
                <img src="images/navprofile.png" alt="Profile Icon" class="volunteernav-icon">
                    PROFILE
                </a>
            </li>
        </ul>
    </nav>
    <script src="script.js"></script>
</body>
</html>
