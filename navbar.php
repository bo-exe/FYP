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
.navbar {
    width: 100%;
    background-color: #FFD036; /* Changed background color to #FFD036 */
    position: fixed;
    top: 0;
    left: 0;
    display: flex;
    justify-content: center;
}

/* List styling */
.navbar ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
    display: flex;
}

.navbar ul li {
    margin: 0;
}

/* Link styling */
.navbar ul li a {
    display: block;
    padding: 14px 20px;
    text-decoration: none;
    color: black; /* Adjusted text color for better contrast */
    text-align: center;
}

/* Hover effect */
.navbar ul li a:hover {
    background-color: #FFC107; /* Adjusted hover background color for a slight contrast */
    color: black; /* Adjusted hover text color for consistency */
}

/* Content styling */
.content {
    margin-top: 50px; /* Adjust margin to prevent content from being hidden behind the navbar */
    padding: 20px;
}

/* Media Query for mobile devices */
@media (max-width: 768px) {
    .navbar {
        top: auto;
        bottom: 0;
    }
    .content {
        margin-top: 0;
        margin-bottom: 50px; /* Adjust margin to prevent content from being hidden behind the navbar */
    }
}
</style>
<body>
    <nav class="navbar">
        <ul>
            <li><a href="#">HOME</a></li>
            <li><a href="#">MANAGE</a></li>
            <li><a href="#">SCANNER</a></li>
            <li><a href="#">MILESTONES</a></li>
            <li><a href="#">PROFILE</a></li>
        </ul>
    </nav>
    <script src="script.js"></script>
</body>
</html>
