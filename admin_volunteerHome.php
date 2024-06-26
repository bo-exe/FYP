<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Volunteer Admin Home</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<br>
<?php include "admin_volunteerNavbar.php"; ?>
<?php include "ft.php"; ?>
<br></br>

    <?php
    session_start();
    if (isset($_SESSION['username'])) 
        {
        $username = $_SESSION['username'];
        echo "@" . htmlspecialchars($username); 
        }
    ?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-6">
            <div class="volunteeradmin-card">
                <a href="admin_allGigs.php">
                    <div class="volunteeradmin-cardbody">
                        <img src="images/exercise.png" alt="Icon 1">
                    </div>
                    <div class="volunteeradmin-cardfooter">
                        Manage <br>
                        Current Gigs
                    </div>
                </a>
            </div>
        </div>

        <div class="col-md-6">
            <div class="volunteeradmin-card">
                <a href="admin_addGig.php">
                    <div class="volunteeradmin-cardbody">
                        <img src="images/wand.jpg" alt="Icon 2">
                    </div>
                    <div class="volunteeradmin-cardfooter">
                        Create <br>
                        New Gigs
                    </div>
                </a>
            </div>
        </div>

        <div class="col-md-12">
            <div class="volunteeradmin-card">
                <a href="admin_gigMilestone.php">
                    <div class="volunteeradmin-cardbody">
                        <img src="images/milestones.jpg" alt="Icon 3">
                    </div>
                    <div class="volunteeradmin-cardfooter">
                        Milestones Reached
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

<?php include "admin_footer.php"; ?>
<script src="script.js"></script>
</body>

</html>