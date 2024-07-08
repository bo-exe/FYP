<?php
session_start();
include "dbFunctions.php";

// Check if the user is logged in
if (!isset($_SESSION['volunteerId']) || empty($_SESSION['volunteerId'])) {
    echo "User not logged in.";
    exit();
}

// Check if the verification code is set in the session
if (!isset($_SESSION['verification_code'])) {
    echo "Session verification code is not set.";
    exit();
}

// Debug: Output the session verification code for debugging purposes
echo "Session verification code: " . $_SESSION['verification_code'] . "<br>";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Debug: Output the POST data for debugging purposes
    echo "POST data: ";
    print_r($_POST);

    // Retrieve the entered verification code
    $enteredCode = isset($_POST['verification_code']) ? $_POST['verification_code'] : '';

    // Validate the entered verification code
    if (empty($enteredCode) || !ctype_digit($enteredCode)) {
        echo "Invalid verification code format.";
        exit();
    }

    // Check if the entered code matches the one stored in the session
    if ($enteredCode == $_SESSION['verification_code']) {
        // Get the saved form data from the session
        if (isset($_SESSION['form_data'])) {
            $formData = $_SESSION['form_data'];
            $eventID = intval($formData['eventID']);
            $volunteerID = intval($_SESSION['volunteerId']); // Retrieve the volunteer ID from the session
            $registrationDate = date('Y-m-d H:i:s');

            // Insert the data into the event_volunteers table using prepared statements
            $query = "INSERT INTO event_volunteers (eventID, volunteerID, registration_date) VALUES (?, ?, ?)";
            $stmt = $link->prepare($query);
            $stmt->bind_param("iis", $eventID, $volunteerID, $registrationDate);

            if ($stmt->execute()) {
                // Clear the verification code and form data from the session
                unset($_SESSION['verification_code']);
                unset($_SESSION['form_data']);

                // Redirect to the confirmation page or display a success message
                header('Location: vol_confirmation.php');
                exit();
            } else {
                echo "Error: " . $stmt->error;
            }
        } else {
            echo "Session data not found. Please try again.";
        }
    } else {
        echo "Invalid verification code.";
    }
} else {
    echo "Invalid request method.";
}
