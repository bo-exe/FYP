<?php include "navbar.php"; ?>
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
    </style>
</head>
<body>
    <div class="main-content">
        <h2 class="signup-heading">NTUC Charity Run 2024 Sign Up</h2>
        <div class="signup-section">
            <div class="signup-image-container">
                <img src="images/Atome.jpg" alt="Atome-image" class="signup-image">
            </div>
            <div class="signup-content">
                <form class="signup-form" action="submit_signup.php" method="POST">
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
                </form>
            </div>
        </div>
        <button class="signup-button" type="submit">Sign Up</button>
    </div>

    <?php include "footer.php"; ?>

    <script src="script.js"></script>
</body>
</html>
