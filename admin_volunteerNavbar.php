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
.navbar-admin {
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

.navbar-admin ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
    display: flex;
}

.navbar-admin ul li {
    margin: 0;
}

.navbar-admin ul li a {
    display: block;
    padding: 14px 20px;
    text-decoration: none;
    color: #333; 
    text-align: center;
}

.navbar-admin ul li a:hover {
    background-color: #FFC107; 
    color: #555;
}

.content {
    margin-top: 50px;
    padding: 20px;
}

@media (max-width: 768px) {
    .navbar-admin {
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
    <nav class="navbar-admin">
        <div class="logo">
            <img src="images/admin_logo.jpg" alt="Logo" style="width: 100px;">
        </div>
        <ul>
            <li><a href="admin_volunteerHome.php">HOME</a></li>
            <li><a href="admin_gigOverview.php">MANAGE</a></li>
            <li><a href="admin_gigMilestone.php">MILESTONES</a></li>
            <li><a href="admin_volunteerProfile.php">PROFILE</a></li>
            <li><a href=""><i class='bx bx-user' id="profile"></i></a></li>
        </ul>
    </nav>
    <script src="script.js"></script>
</body>
</html>
