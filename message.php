<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if there is an error message in the session
if (isset($_SESSION['error_message'])) {
    $error_message = $_SESSION['error_messsage'];
    unset($_SESSION['error_message']); // Clear error message after displaying
} else {
    $error_message = null;
}


// Check if there is an success message in the session
if (isset($_SESSION['success_message'])) {
    $success_message = $_SESSION['success_messsage'];
    unset($_SESSION['success_message']); // Clear success message after displaying
} else {
    $success_message = null;
}

// Display the error message if it exists
if ($error_message) {
    echo "<div class='blog-post'><p class='error-message'>$error_message</p></div>";
}
// Display the success message if it exists
if ($success_message) {
    echo "<div class='blog-post'><p class='success-message'>$success_message</p></div>";
}

