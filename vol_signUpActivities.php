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
        .popup-overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 1000;
    transition: all 0.3s ease;
}

.popup-overlay.active {
    display: block;
}

.popup {
    display: none;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: white;
    padding: 20px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    z-index: 1001;
    transition: all 0.3s ease;
}

.popup.active {
    display: block;
}

.popup h3 {
    margin-top: 0;
}

.popup p {
    margin-bottom: 20px;
}

.verification-code-inputs {
    display: flex;
    gap: 10px;
    margin-bottom: 10px;
    justify-content: center;
}

.verification-code-inputs input {
    width: 40px;
    height: 40px;
    font-size: 24px;
    text-align: center;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.popup button {
    padding: 10px 20px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    margin: 0 auto;
    display: block;
}

.popup button:hover {
    background-color: #0056b3;
}

    </style>
</head>
<body>
<?php include "vol_navbar.php"; ?>
<br>
<br>
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
                <?php
                if (!empty($event['images'])) {
                    echo '<img src="data:image/jpeg;base64,' . base64_encode($event['images']) . '" alt="' . htmlspecialchars($event['title']) . '" class="signup-image">';
                } else {
                    echo '<img src="https://placehold.co/600" alt="' . htmlspecialchars($event['title']) . '" class="signup-image">';
                }
                ?>
            </div>
            <div class="signup-content">
                <form class="signup-form" id="signup-form" action="vol_sendVerificationCode.php" method="POST">
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
    <h3>Application Successful!</h3>
    <p>
        A verification code has been sent to your email. Please check your inbox and enter the verification code below to verify your email address. The code will expire in 15 minutes.
    </p>
    <form id="verification-form" action="vol_verificationCode.php" method="POST">
    <input type="hidden" name="eventID" value="<?php echo $eventID; ?>">
    <div class="verification-code-inputs">
        <input type="text" name="verification_code[]" id="verification-digit-1" maxlength="1" required>
        <input type="text" name="verification_code[]" id="verification-digit-2" maxlength="1" required>
        <input type="text" name="verification_code[]" id="verification-digit-3" maxlength="1" required>
        <span><strong>&dash;</strong></span>
        <input type="text" name="verification_code[]" id="verification-digit-4" maxlength="1" required>
        <input type="text" name="verification_code[]" id="verification-digit-5" maxlength="1" required>
        <input type="text" name="verification_code[]" id="verification-digit-6" maxlength="1" required>
    </div>
    <button type="submit">Verify</button>
</form>

</div>


<script>
function showVerificationPopup() {
    const form = document.getElementById('signup-form');
    const formData = new FormData(form);

    fetch('vol_sendVerificationCode.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('popup-overlay').classList.add('active');
            document.getElementById('verification-popup').classList.add('active');
        } else {
            alert('Failed to send verification code. Please try again.');
        }
    })
    .catch(error => {
        console.error('There was a problem with the fetch operation:', error);
        alert('Failed to send verification code. Please try again.');
    });
}

document.getElementById('popup-overlay').addEventListener('click', function() {
    this.classList.remove('active');
    document.getElementById('verification-popup').classList.remove('active');
});

// const inputs = document.querySelectorAll('.verification-code-inputs input');
// inputs.forEach((input, index) => {
//     input.addEventListener('input', () => {
//         if (input.value.length === 1 && index < inputs.length - 1) {
//             inputs[index + 1].focus();
//         }
//     });
// });


document.getElementById('verification-form').addEventListener('submit', function(event) {
    event.preventDefault();

    const form = event.target;
    const formData = new FormData(form);
    const verificationCodeArray = formData.getAll('verification_code[]');
    const verificationCode = verificationCodeArray.join('');

    // Add the concatenated verification code to the form data
    formData.delete('verification_code[]');
    formData.append('verification_code', verificationCode);

    fetch('vol_verificationCode.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        console.log(data); // Debug: Output the response from the server
        if (data.includes("Session verification code")) {
            // Server-side success handling
            window.location.href = 'vol_confirmation.php';
        } else {
            alert(data); // Display the server response for debugging
        }
    })
    .catch(error => {
        console.error('There was a problem with the fetch operation:', error);
        alert('Failed to verify the code. Please try again.');
    });
});




</script>

<?php include "vol_footer.php"; ?>

 
</body>
</html>



