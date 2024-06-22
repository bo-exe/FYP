<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Navigation Bar</title>
    <link rel="stylesheet" href="style.css">
</head>
<style>
/* Navbar styling */
.navbar-volunteeradmin {
    width: 100%;
    background-color: #FFD036; 
    position: fixed;
    top: 0;
    left: 0;
    display: flex;
    justify-content: space-between; 
    align-items: center;
    padding: 0 20px; 
}

.logo {
    margin-right: auto;
}

.search-bar {
    margin-right: 20px;
}

.navbar-volunteeradmin ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
    display: flex;
}

.navbar-volunteeradmin ul li {
    margin: 0;
}

.navbar-volunteeradmin ul li a {
    display: block;
    padding: 14px 20px;
    text-decoration: none;
    color: #333; 
    text-align: center;
}

.navbar-volunteeradmin ul li img {
    width: 15%;
}

.navbar-volunteeradmin ul li a:hover {
    background-color: #FFC107; 
    color: #555;
}

.content {
    margin-top: 50px;
    padding: 20px;
}

@media (max-width: 768px) {
    .navbar-volunteeradmin {
        top: auto;
        bottom: 0;
        flex-direction: column;
        align-items: flex-start; 
        padding: 20px; 
    }
    
    .logo,
    .search-bar,
    #profile {
        display: none;
    }
}
</style>
<body>
    <nav class="navbar-volunteeradmin">
        <div class="logo">
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
                <a href="admin_gigOverview.php">
                    <img src="images/navmanage.png" alt="Manage Icon" class="volunteernav-icon">
                    MANAGE
                </a>
            </li>

            <li>
                <a href="admin_gigMilestone.php">
                    <img src="images/navmilestones.png" alt="Milestones Icon" class="volunteernav-icon">
                    MILESTONES
                </a>
            </li>

            <li>
                <a href="admin_volunteerProfile.php">
                <img src="images/navprofile.png" alt="Profile Icon" class="volunteernav-icon">
                    PROFILE
                </a>
            </li>

            <li>
                <a href="admin_volunteerProfile.php"><i class='bx bx-user' id="profile"></i>
            </a>
            </li>
        </ul>
    </nav>
    <script src="script.js"></script>
</body>
</html>
