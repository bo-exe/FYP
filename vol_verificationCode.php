<?php
session_start();
include "dbFunctions.php";

// Debug: Check if session is started and verification code is set
if (!isset($_SESSION['verification_code'])) {
    echo "Session verification code is not set.";
    exit();
} else {
    echo "Session verification code: " . $_SESSION['verification_code'] . "<br>";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Debug: Check POST data
    echo "POST data: ";
    print_r($_POST);

    $enteredCode = isset($_POST['verification_code']) ? $_POST['verification_code'] : '';

    // Validate the entered code
    if (empty($enteredCode) || !ctype_digit($enteredCode)) {
        echo "Invalid verification code format.";
        exit();
    }

    // Check if the entered code matches the one sent
    if ($enteredCode == $_SESSION['verification_code']) {
        // Get the saved form data from the session
        if (isset($_SESSION['form_data']) && isset($_SESSION['userId'])) {
            $formData = $_SESSION['form_data'];
            $eventID = intval($formData['eventID']);
            $volunteerID = intval($_SESSION['userId']); // Assuming the user is logged in and user ID is stored in session
            $registrationDate = date('Y-m-d H:i:s');

            // Insert data into event_volunteers table using prepared statements
            $query = "INSERT INTO event_volunteers (eventID, volunteerID, registration_date) VALUES (?, ?, ?)";
            $stmt = $link->prepare($query);
            $stmt->bind_param("iis", $eventID, $volunteerID, $registrationDate);

            if ($stmt->execute()) {
                // Clear the verification code and form data from the session
                unset($_SESSION['verification_code']);
                unset($_SESSION['form_data']);

                // Redirect to confirmation page or show success message
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
