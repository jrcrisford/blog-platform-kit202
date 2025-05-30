<?php
require_once 'db_connect.php';

// Check the user's role
$role = $_SESSION['role'] ?? 'visitor';

// Get post data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Check if duplicate username or email
    $conn = connect();
    $existingUser = getUserByUsername($conn, $username);
    if (!$existingUser) {
        $existingUser = getUserByEmail($conn, $email);
    }

    if ($existingUser) {

        if ($existingUser['username'] === $username) {
            $_SESSION['error_message'] = 'Username already taken';
            header("Location: register.php");
            exit();
        }

        if ($existingUser['email'] === $email) {
            $_SESSION['error_message'] = 'Email already taken';
            header("Location: register.php");
            exit();
        }
    }

    if (insertUser($conn, $username, $email, $password)) {
        // Registration successful
        $_SESSION['success_message'] = 'Registration successful. You can now log in.';
        header("Location: login.php");
    } else {
        // Registration failed
        $_SESSION['error_message'] = 'Registration failed. Please try again..';
        header("Location: register.php");
    }
    disconnect($conn);

}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="Joshua Crisford, Anmol Daulyal, Dipen Subedi">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script>// Apply dark mode before styles load to prevent flickering
            if (localStorage.getItem("theme") === "dark") {document.documentElement.classList.add("dark-mode");}
        </script> 
        <link rel="stylesheet" href="css/styles.css">
        <script src="javascript/validation.js?V=2" defer></script>
        <script src="javascript/ui_behaviour.js" defer></script>
        <title>Registration Page</title>
    </head>
    <body>

        <!-- Navigation Bar -->
        <div class="navbar-container">
            <nav class="navbar">
                <div class="navbar-inner">

                    <!-- Logo -->
                    <div class="logo">
                        <a href="index.php">
                            <img src="logos/horizontal_logo_dark.png" id="site-logo" alt="Logo Horizonal Dark" class="site-logo">
                        </a>
                    </div>

                    <!-- Hamburger Menu (for mobile) -->
                    <button class="hamburger" id="hamburger" aria-label="Toggle navigation">
                        ☰
                    </button>

                    <!-- Navigation Links -->
                    <ul class="nav-links" id="navLinks">

                        <!-- Home Page Link -->
                        <li><a href="index.php">Homepage</a></li>

                        <!-- Older Page Link -->
                        <?php if ($role === 'member' || $role === 'author'): ?>
                        <li><a href="older.php">Older Posts</a></li>
                        <?php endif; ?>

                        <!-- Write Post Link -->
                        <?php if ($role === 'author'): ?>
                        <li><a href="write.php">Write Post</a></li>
                        <?php endif; ?>

                        <!-- Our Story Page Link -->
                        <li><a href="our_story.php">Our Story</a></li>

                        <!-- Login/Register/Logout Links -->
                        <?php if ($role === 'member' || $role === 'author'): ?>
                            <li>Logged in as <?php echo htmlspecialchars($_SESSION['username']); ?></li>
                            <li><a href="logout.php">Logout</a></li>
                        <?php else: ?>
                            <li><a href="login.php" class="active">Login</a></li>
                             <li><a href="register.php">Register</a></li>
                        <?php endif; ?>

                        <!-- Theme Toggle Switch -->
                        <li class="theme-toggle-container">
                            <label class="theme-toggle">
                                <input type="checkbox" id="themeSwitch" />
                                <span class="slider"></span>
                            </label>
                            <span class="theme-toggle-label">Dark Mode</span>
                        </li>

                    </ul>
                </div>
            </nav>
        </div>
        
        <!--Page Content-->

        <main class="container">

        <!-- Display error or success messages -->
            <?php include_once 'message.php'; ?>
            
           <div class="form-container">
                <section class="page-header">
                    <h2>Registration</h2>
                    <p>Please fill in the form to create an account.</p>
                </section>

                <section>
                    <form id="registerForm" class="auth-form" novalidate method="POST" action="register.php">

                        <label for="register-username">Username:</label>
                        <input type="text" id="register-username" name="username">
                        <span class="error-message" id="register-username-error"></span>

                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email">
                        <span class="error-message" id="email-error"></span>

                        <label for="register-password">Password:</label>
                        <input type="password" id="register-password" name="password">
                        <span class="error-message" id="register-password-error"></span>

                        <div class="password-requirements">
                            <small>Password must include 8 characters including an uppercase, lowercase, number, and special character.</small>
                        </div>

                        <label for="confirm-password">Confirm Password:</label>
                        <input type="password" id="confirm-password" name="confirm-password">
                        <span class="error-message" id="confirm-password-error"></span>

                        <input type="submit" value="Register">
                        <input type="reset" value="Clear">

                        <div class="authorise-links">
                            <p>Already have an account? <a href="login.php">Click to Login</a></p>
                        </div>
                    </form>
                </section>

           </div>
        </main>

        <footer>
            <p>KIT202 Assignment 1 | Everything Explained</p>
        </footer>

        <button id="scrollToTopBtn" title="Go to top">↑</button>   

    </body>
</html>  
