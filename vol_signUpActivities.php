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
            flex-direction: column;
            align-items: center;
            margin-top: 50px;
        }

        .signup-heading {
            text-align: center;
            width: 100%;
            margin-bottom: 20px;
        }

        .signup-section {
            display: flex;
            flex-direction: row;
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
            width: 100%;
            max-width: 870px;
            height: auto;
        }

        .signup-content {
            flex: 1;
            max-width: 400px;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .name-fields {
            display: flex;
            justify-content: space-between;
            width: 100%;
            margin-bottom: 10px;
        }

        .name-fields input {
            width: 48%;
        }

        .signup-form input,
        .signup-form button {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            font-size: 1rem;
        }

        .signup-button {
            background-color: #FFD036;
            color: black;
            border: none;
            cursor: pointer;
            border-radius: 12px;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }

        .signup-button:hover {
            background-color: #F7C600;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }

        .popup-overlay,
        .popup {
            position: fixed;
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .popup-overlay {
            display: none;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
        }

        .popup-overlay.active {
            display: block;
        }

        .popup {
            display: none;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            width: 90%;
            max-width: 400px;
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
            justify-content: center;
            margin-bottom: 10px;
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
            background-color: #FFD036;
            color: black;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            padding: 10px 20px;
            display: block;
            margin: 0 auto;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }

        .popup button:hover {
            background-color: #F7C600;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }

        .yellow-container {
            background-color: #FFD036;
            color: #333;
            text-align: left;
            padding: 15px;
            box-sizing: border-box;
            margin-bottom: 20px;
            display: none;
        }

        .yellow-container h1 {
            margin: 0;
            padding: 0;
            font-size: 24px;
            font-weight: bold;
            padding-left: 20px;
        }

        .yellow-container .points-container {
            display: none;
        }


        @media (max-width: 768px) {
            .signup-section {
                flex-direction: column;
                align-items: center;
                margin-top: 10px;
                padding-bottom: 80px;
            }

            .signup-image-container {
                margin-right: 0;
                margin-bottom: 20px;
            }

            .signup-image {
                width: 100%;
                max-width: 600px;
            }

            .signup-button {
                font-size: 0.9rem;
                padding: 8px;
            }

            .name-fields {
                flex-direction: column;
            }

            .name-fields input {
                width: 100%;
                margin-bottom: 10px;
            }

            .popup {
                bottom: 0;
                left: 50%;
                transform: translateX(-50%);
                width: 100%;
                max-width: 100%;
                border-radius: 0;
            }



            body {
                padding-bottom: 20px; 
            }

            .yellow-container {
                display: block;
                width: 100%;
                text-align: center;
                padding: 10px 0;
            }

            .yellow-container h1, .yellow-container p {
                text-align: left;
                padding-left: 20px;
            }

            .header-section {
                display: none;
            }
        
                .home {
                    display: none;
                }
        }

        @media (max-width: 480px) {
            .signup-button {
                font-size: 0.8rem;
                padding: 8px;
            }

            .verification-code-inputs input {
                width: 30px;
                height: 30px;
                font-size: 18px;
            }
        }
    </style>
</head>
<body>
<?php  include "vol_navbar.php"; ?>
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
           
        }
    })
    .catch(error => {
        console.error('There was a problem with the fetch operation:', error);
        alert('Failed to verify the code. Please try again.');
    });
});




</script>

    <?php  include "vol_footer.php"; ?>

 
</body>
</html>






