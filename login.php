<?php
    require_once 'db_connect.php';

    // Get the username and password from the form
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = trim($_POST['username']);
        $password = $_POST['password'];

        // Query to fetch the user by username
        $user = getUserByUsername($username);

        // If the user is found
        if ($user) {
            // Verify the password
            if (password_verify($password, $user['passwordHash'])) {
                // Store user details
                $_SESSION['userID'] = $user['userID'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                
                // Redirect to home page
                header("Location: index.php");
                exit();
            } else {
                // Redirect to login page if password is incorrect
                header("Location: login.php?error=Invalid password");
                exit();
            }
        } else {
            // Redirect to login page if user is not found
            header("Location: login.php?error=user_not_found");
            exit();
        }
    }
?>
