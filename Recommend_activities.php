<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="icon" type="image/x-icon" href="images/logo.jpg">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css">
    <style>
        /* Navbar styling */
nav {
    position: fixed; 
    top: 0;
    width: 100%;
    z-index: 1000; 
}

/* Homepage */
.home {
    margin-top: 100px;
}

.home h1, p {
    margin-right: 800px;
    text-align: left;
}

.container {
    padding: 2rem;
    margin-top: 20px; 
    margin-right: 800px;
}

.container h2 {
    text-align: left;
}

.slider-wrapper {
    position: relative;
    max-width: 48rem;
    margin: 0 auto;
}

.slider {
    display: flex;
    overflow: hidden;
    position: relative;
    z-index: 1; 
}

.slider img {
    width: 100%;
    flex: 0 0 100%; 
    transition: transform 0.5s ease;
}

.slider-nav {
    display: flex;
    justify-content: center;
    position: absolute;
    bottom: 1.25rem;
    left: 50%;
    transform: translateX(-50%);
    z-index: 2;
}

.slider-nav .dot {
    height: 10px;
    width: 10px;
    background-color: #fff;
    opacity: 0.75;
    border: 2px solid #fff;
    border-radius: 50%;
    margin: 0 5px;
    cursor: pointer;
    transition: opacity 0.3s;
}

.slider-nav .dot:hover {
    opacity: 1;
}

.slider::-webkit-scrollbar {
    display: none;
}

.slider {
    -ms-overflow-style: none;
    scrollbar-width: none;
}

.about-btn {
    display: inline-block;
    padding: 0.3rem 0.7rem;
    background: #FFD036;
    border-radius: .6rem;
    box-shadow: 0 .2rem .5rem #333;
    font-size: 0.8rem;
    color: #333 ;
    letter-spacing: .1rem;
    font-weight: 600;
    border: .2rem solid transparent;
    transition: .5s ease;
    margin-top: 30px;
    margin-left: 300px;
}

.about-btn:hover {
    background: #deb530;
    color: #333;
}

.header {
    display: flex;
    align-items: center;
}

.greeting {
    flex-grow: 1; 
}

.points-container {
    display: flex;
    align-items: center;
    justify-content: left;
    font-size: 14px;
    color: #333;
    background-color: #ECECE7;
    border-radius: .6rem;
    box-shadow: 0 .2rem .5rem #333;
    letter-spacing: .2rem;
    font-weight: 800;
    padding: 10px;
}

.points-container i {
    margin-right: 5px;
}

.points-container .vomo-points {
    display: flex;
    align-items: center;
}

.points-container .vomo-points span:first-child {
    margin-right: 100px;
}



.calendar-container {
    margin-top: 20px;
    padding: 20px;
    background-color: #ECECE7;
    border-radius: 10px;
    box-shadow: 0 .2rem .5rem #333;
}

.calendar-container h2 {
    text-align: left;
    margin-bottom: 10px;
}




</style>
</head>
<body>
    <?php include "navbar.php"; ?>

    <section class="home" id="home">
    <div class="header">
        
        <div class="points-container">
            <i class='bx bx-gift'></i>
            <div class="vomo-points">
                <span>VOMOPoints</span>
                <span>0</span>
            </div>
        </div>
    </div>
    
</section>

   
<section class="container">
        <h2>Recommended Activities</h2>
        <div class="card">
            <img src="images/NTUC Charity Run.jpg" alt="NTUC-image">
            <div class="card-content">
                <h1>NTUC Charity Run 2024</h1>
                <div class="vomo-points">
                    <span>Obtainable VOMO Points:</span>
                    <span>200</span>
                </div>
                <button>More</button>
            </div>
        </div>
    </section>


    <?php include "footer.php"; ?>

    <script src="script.js"></script>
</body>
</html>




