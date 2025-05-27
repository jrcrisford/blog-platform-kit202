<?php
    require_once 'db_connect.php';
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Check the user's role
    $role = $_SESSION['role'] ?? 'visitor';

    // Get the username and password from the form
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = trim($_POST['username']);
        $password = $_POST['password'];

        // Query to fetch the user by username
        $conn = connect();
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
        <title>Login Page</title>
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

        <!-- Page content -->
        <main class="container">
            <div class="form-container">
                <section class="page-header">
                    <h2>Login</h2>
                    <p>Enter your credentials</p>
                </section>
                
                <section>
                    <!-- Login Form -->
                    <form class="auth-form" id="loginForm" novalidate method="POST" action="login.php">

                        <label for="username">Username:</label>
                        <input type="text" id="username" name="username">
                        <span class="error-message" id="username-error"></span>

                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password">
                        <span class="error-message" id="password-error"></span>

                        <input type="submit" value="Login">

                        <div class="authorise-links">
                            <p>
                                Want to become a member? <a href="register.php">Register Now</a>
                            </p>
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