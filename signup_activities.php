<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NTUC Charity Run 2024 Sign Up</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .main-content {
            padding: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap; /* Ensures content wraps on smaller screens */
            flex-direction: column; /* Arrange content in column */
        }

        .signup-heading {
            text-align: center;
            width: 100%;
            margin-bottom: 20px; /* Spacing below the heading */
        }

        .signup-section {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            flex-wrap: wrap; /* Ensures content wraps on smaller screens */
        }

        .signup-image-container {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-right: 50px; /* Added margin for spacing */
        }

        .signup-image {
            width: 870px; /* Adjusted size for better fit */
            max-width: 100%; /* Ensures it doesn't overflow */
        }

        .signup-content {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            max-width: 400px;
            flex: 1;
        }

        .name-fields {
            display: flex;
            justify-content: space-between;
            width: 100%;
            margin-bottom: 10px; /* Small spacing between the name fields */
        }

        .signup-form input,
        .signup-form button {
            width: 100%;
            padding: 10px;
            margin: 5px 0; /* Small spacing between each input */
            font-size: 1rem;
        }

        .name-fields input {
            width: 48%; /* Make sure both input fields fit side by side */
        }

        .signup-button {
            width: 50%;
            padding: 8px;
            margin: 10px 0; /* Adjusted margin for better spacing */
            font-size: 1rem;
            background-color: #FFD036;
            color: black;
            border: none;
            cursor: pointer;
            
        }

        .signup-button:hover {
            background-color: #0056b3;
        }
          /* Add styles for the popup */
          .popup {
            display: none;
            position: fixed;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 20px;
            border: 2px solid #ccc;
            z-index: 1000;
        }
        .popup.active {
            display: block;
        }
        .popup-overlay {
            display: none;
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }
        .popup-overlay.active {
            display: block;
        }
    </style>
</head>
<body>
<?php // include "navbar.php"; ?>
<div class="main-content">
    <?php
    include "dbFunctions.php";

    // Get the eventID from the URL parameter
    $eventID = isset($_GET['eventID']) ? intval($_GET['eventID']) : 0;

    // Query to fetch event with the specified eventID
    $query = "SELECT * FROM events WHERE eventID = $eventID";
    $result = mysqli_query($link, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $event = mysqli_fetch_assoc($result);
        ?>
        <h2 class="signup-heading"><?php echo htmlspecialchars($event['title']); ?> Sign Up</h2>
        <div class="signup-section">
            <div class="signup-image-container">
                <img src="https://placehold.co/600" alt="<?php echo htmlspecialchars($event['title']); ?>" class="signup-image">
            </div>
            <div class="signup-content">
                <form class="signup-form" id="signup-form" action="send_verification_code.php" method="POST">
                    <input type="hidden" name="eventID" value="<?php echo $eventID; ?>">
                    <div class="name-fields">
                        <input type="text" name="first_name" placeholder="First Name" required>
                        <input type="text" name="last_name" placeholder="Last Name" required>
                    </div>
                    <input type="email" name="email" placeholder="Email Address" required>
                    <div style="display: flex; align-items: center;">
                        <select name="country_code" required>
                            <option value="+65">+65</option>
                            <option value="+1">+1</option>
                            <option value="+44">+44</option>
                            <option value="+91">+91</option>
                            <!-- Add more country codes as needed -->
                        </select>
                        <input type="tel" name="phone" placeholder="Phone Number" required style="flex-grow: 1;">
                    </div>
                    <button class="signup-button" type="button" onclick="showVerificationPopup()">Sign Up</button>
                </form>
            </div>
        </div>
        <?php
    } else {
        echo "<p>Event not found.</p>";
    }
    ?>
</div>

<div class="popup-overlay" id="popup-overlay"></div>
<div class="popup" id="verification-popup">
    <h3>Enter Verification Code</h3>
    <form id="verification-form" action="verify_code.php" method="POST">
        <input type="hidden" name="eventID" value="<?php echo $eventID; ?>">
        <input type="text" name="verification_code" placeholder="Verification Code" required>
        <button type="submit">Verify</button>
    </form>
</div>

<script>
function showVerificationPopup() {
    const form = document.getElementById('signup-form');
    const formData = new FormData(form);

    fetch('send_verification_code.php', {
        method: 'POST',
        body: formData
    }).then(response => response.json())
      .then(data => {
          if (data.success) {
              document.getElementById('popup-overlay').classList.add('active');
              document.getElementById('verification-popup').classList.add('active');
          } else {
              alert('Failed to send verification code. Please try again.');
          }
      });
}

document.getElementById('popup-overlay').addEventListener('click', function() {
    this.classList.remove('active');
    document.getElementById('verification-popup').classList.remove('active');
});
</script>

    <?php // include "footer.php"; ?>

 
</body>
</html>
