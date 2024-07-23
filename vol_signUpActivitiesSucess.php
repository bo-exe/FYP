<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Success SignUp Activities</title>
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
            flex-wrap: wrap;
            flex-direction: column;
        }

        .signup-heading {
            text-align: center;
            width: 100%;
            margin-bottom: 20px;
        }

        .signup-section {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            flex-wrap: wrap;
        }

        .signup-image-container {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-right: 50px;
        }

        .signup-image {
            width: 870px;
            max-width: 100%;
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
            margin-bottom: 10px;
        }

        .signup-form input,
        .signup-form button {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            font-size: 1rem;
        }

        .name-fields input {
            width: 48%;
        }

        .signup-button {
            width: 50%;
            padding: 10px;
            margin: 10px 0;
            font-size: 1rem;
            background-color: #28a745; /* Green background color */
            color: white;
            border: none;
            cursor: pointer;
            text-align: center; /* Center the text */
            border-radius: 4px; /* Rounded corners */
            transition: background-color 0.3s ease;
        }

        .signup-button:hover {
            background-color: #218838; /* Darker green on hover */
        }

        .calendar-button {
    width: 50%;
    padding: 10px;
    margin: 10px 0;
    font-size: 1rem;
    background-color: #FFD036; /* Yellow background color */
    color: black;
    border: none;
    cursor: pointer;
    text-align: center; /* Center the text */
    border-radius: 4px; /* Rounded corners */
    transition: background-color 0.3s ease;
}

.calendar-button:hover {
    background-color: #f7c600; /* Darker yellow on hover */
}
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
            text-align: center;
            border-radius: 10px;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        .verification-code {
            display: flex;
            justify-content: space-between;
            margin: 20px 0;
        }

        .verification-code input {
            width: 15%;
            padding: 10px;
            font-size: 1rem;
            text-align: center;
        }

        .verify-button {
            width: 50%;
            padding: 10px;
            margin: 10px 0;
            font-size: 1rem;
            background-color: #28a745; /* Green background color */
            color: white;
            border: none;
            cursor: pointer;
            text-align: center; /* Center the text */
            border-radius: 4px; /* Rounded corners */
            transition: background-color 0.3s ease;
        }

        .verify-button:hover {
            background-color: #218838; /* Darker green on hover */
        }
    </style>
</head>
<body>
    <div class="main-content">
        <h2 class="signup-heading">ActiveSG Community Morning Sign Up</h2>
        <div class="signup-section">
            <div class="signup-image-container">
                <img src="images/ActiveSG.jpg" alt="Active-image" class="signup-image">
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
                    <button class="signup-button" type="submit">Sign Up</button>
                    <!-- Add a button to go to the calendar -->
                    <button class="calendar-button" type="button" onclick="window.location.href='calendar.html'">Go to Calendar</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Overlay -->
    <div id="verificationModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Application Successful</h2>
            <p>Please enter the 6-digit verification code sent to your email.</p>
            <div class="verification-code">
                <input type="text" maxlength="1">
                <input type="text" maxlength="1">
                <input type="text" maxlength="1">
                <input type="text" maxlength="1">
                <input type="text" maxlength="1">
                <input type="text" maxlength="1">
            </div>
            <button class="verify-button">Verify</button>
        </div>
    </div>

    <?php include "vol_footer.php"; ?>

    <script>
        // Function to open the modal
        function openModal() {
            document.getElementById('verificationModal').style.display = 'flex';
        }

        // Function to close the modal
        function closeModal() {
            document.getElementById('verificationModal').style.display = 'none';
        }

        // Show the modal after form submission
        document.querySelector('.signup-form').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent form from submitting
            openModal(); // Open the modal
        });
    </script>
</body>
</html>
