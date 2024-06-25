<?php
session_start();
include "dbFunctions.php";

$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $sql = "SELECT points FROM volunteers WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result) {
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $vomoPoints = $row['points'];
        } else {
            $vomoPoints = 0;
        }
    } else {
        $vomoPoints = 0; 
    }
} else {
    $vomoPoints = 0;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recommended Activities</title>
    <link rel="icon" type="image/x-icon" href="images/logo.jpg">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
    .about-btn {
        display: inline-block;
        padding: 0.3rem 0.7rem;
        background: #FFD036;
        border-radius: .6rem;
        box-shadow: 0 .2rem .5rem #333;
        font-size: 0.8rem;
        color: #333;
        letter-spacing: .1rem;
        font-weight: 600;
        border: .2rem solid transparent;
        transition: .5s ease;
        margin-top: 30px;
    }

    .about-btn:hover {
        background: #deb530;
        color: #333;
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

    .card-content {
        padding: 20px;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }

    .card-content h1 {
        font-size: 1.5rem;
        margin-bottom: 10px;
        font-weight: bold; /* Make h1 bold */
    }

    .card-content .vomo-points {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }

    .card-content button {
        background: #FFD036;
        border: none;
        padding: 6px 50px; /* Adjusted padding for slightly larger size */
        cursor: pointer;
        transition: background 0.3s ease, box-shadow 0.3s ease;
        font-size: 0.7rem; /* Adjusted font size */
        margin-top: 8px; /* Added margin to separate button */
        color: #000; /* Set text color to black */
        box-shadow: 0 8px 10px rgba(0, 0, 0, 0.1); /* Added drop shadow */
        width: auto; /* Ensure button width is determined by its content */
        font-weight: bold; /* Make button text bold */
    }

    .card-content button:hover {
        background: #FFD036; /* Keep background color the same on hover */
        color: #000; /* Ensure text color stays black on hover */
        box-shadow: 0 6px 8px rgba(0, 0, 0, 0.2); /* Enhance shadow on hover */
    }

    .custom-container {
        max-width: 1400px; /* Increased the max-width */
        margin: 0 auto;
        padding: 40px; /* Increased padding */
        background-color: transparent; /* Changed background color to transparent */
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .header-section {
        margin-top: 20px;
        text-align: left; /* Align header text to the left */
    }

    .header {
            display: flex;
            align-items: center;
        }

        .row .greeting {
            flex-grow: 1; 
        }

    body {
        background-color: #f8f9fa;
    }

    /* Custom CSS for more spacing between cards */
    .mb-5 {
        margin-bottom: 60px !important; /* Adjust margin-bottom as needed */
    }

    @media (min-width: 1000px) {
        .mb-lg-5 {
            margin-bottom: 120px !important; /* Larger margin for larger screens */
        }
    }
</style>
</head>
<body>
    <?php include "navbar.php"; ?>

    <section class="header-section py-5">
        <div class="container">
            <div class="row">
            <div class="greeting">
                <h1>Recommend Activities</h1>
            </div>
            <div class="points-container">
                <i class='bx bx-gift'></i>
                <div class="vomo-points">
                    <span>VOMOPoints</span>
                    <span><?php echo $vomoPoints; ?></span>
                </div>
            </div>
                </div>
            </div>
        </div>
    </section>

    <!-- <section class="home" id="home">
        <div class="header">
            <div class="greeting">
                <h1>Recommend Activities</h1>
            </div>
            <div class="points-container">
                <i class='bx bx-gift'></i>
                <div class="vomo-points">
                    <span>VOMOPoints</span>
                    <span><?php echo $vomoPoints; ?></span>
                </div>
            </div>
        </div>
</section> -->

    <section class="custom-container py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12 col-lg-10 mb-5 mb-lg-5"> <!-- Increased margin-bottom for both md and lg screens -->
                    <div class="card">
                        <img src="images/NTUC Charity Run.jpg" class="card-img-top" alt="NTUC-image">
                        <div class="card-content">
                            <h1>NTUC Charity Run 2024</h1>
                            <div class="vomo-points">
                                <span>Obtainable VOMO Points:</span>
                                <span>200</span>
                            </div>
                            <button>More</button>
                        </div>
                    </div>
                </div>
                <!-- Repeat similar blocks for other activities -->
                <div class="col-md-12 col-lg-10 mb-5 mb-lg-5"> <!-- Increased margin-bottom for both md and lg screens -->
                    <div class="card">
                        <img src="images/ActiveSG.jpg" class="card-img-top" alt="NTUC-image">
                        <div class="card-content">
                            <h1>ActiveSG Community Morning</h1>
                            <div class="vomo-points">
                                <span>Obtainable VOMO Points:</span>
                                <span>100</span>
                            </div>
                            <button>More</button>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 col-lg-10 mb-5 mb-lg-5"> <!-- Increased margin-bottom for both md and lg screens -->
                    <div class="card">
                        <img src="images/Decat.jpg" class="card-img-top" alt="NTUC-image">
                        <div class="card-content">
                            <h1>Decathalon Beach Clean Up</h1>
                            <div class="vomo-points">
                                <span>Obtainable VOMO Points:</span>
                                <span>200</span>
                            </div>
                            <button>More</button>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 col-lg-10 mb-5 mb-lg-5"> <!-- Increased margin-bottom for both md and lg screens -->
                    <div class="card">
                        <img src="images/NTU.jpg" class="card-img-top" alt="NTUC-image">
                        <div class="card-content">
                            <h1>NTU Community Clean Up</h1>
                            <div class="vomo-points">
                                <span>Obtainable VOMO Points:</span>
                                <span>180</span>
                            </div>
                            <button>More</button>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 col-lg-10 mb-5 mb-lg-5"> <!-- Increased margin-bottom for both md and lg screens -->
                    <div class="card">
                        <img src="images/Atome.jpg" class="card-img-top" alt="NTUC-image">
                        <div class="card-content">
                            <h1>Atome Awareness Run</h1>
                            <div class="vomo-points">
                                <span>Obtainable VOMO Points:</span>
                                <span>350</span>
                            </div>
                            <button>More</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include "footer.php"; ?>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="script.js"></script>
</body>
</html>





