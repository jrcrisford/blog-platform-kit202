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
        <script src="javascript/validation.js" defer></script>
        <script src="javascript/ui_behaviour.js" defer></script>
        <title>Write Post Page</title>
    </head>
    <body>
        
        <!-- Navigation Bar -->
        <div class="navbar-container">
            <nav class="navbar">
                <div class="navbar-inner">

                    <!-- Logo -->
                    <div class="logo">
                        <a href="index.html">
                            <img src="logos/horizontal_logo_dark.png" id="site-logo" alt="Logo Horizonal Dark" class="site-logo">
                        </a>
                    </div>

                    <!-- Hamburger Menu (for mobile) -->
                    <button class="hamburger" id="hamburger" aria-label="Toggle navigation">
                        ☰
                    </button>

                    <!-- Navigation Links -->
                    <ul class="nav-links" id="navLinks">
                        <li><a href="index.html">Homepage</a></li>
                        <li><a href="older.html">Older Posts</a></li>
                        <li><a href="write.html" class="active">Write Post</a></li>
                        <li><a href="login.html">Login</a></li>
                        <li><a href="our_story.html">Our Story</a></li>
                        
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
        
        <!-- Page content start -->
        <main class="container">

           <div class="form-container">
            <section class="page-header">
                <h2>Write Post</h2>
                <p> Please fill in the form to create new post.</p>
            </section>

            <!-- Post Creation -->
             <section>
            <form id="writePostForm" novalidate>
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" maxlength="80">
                <span class="error-message" id="title-error"></span>

                <label for="tags">Tags/Keywords</label>
                <input type="text" id="tags" name="tags">
                <span class="error-message" id="tags-error"></span>

                <label for="content">Content:</label>
                <textarea id="content" name="content" rows="10"></textarea>
                <span class="error-message" id="content-error"></span>

                <button type="submit" class="publish-btn">Publish</button>
                <button type="reset">Clear</button>
            </form>
        </section>

        <footer>
            <p>KIT202 Assignment 1 | Everything Explained</p>
        </footer>

        <button id="scrollToTopBtn" title="Go to top">↑</button>
        
    </body>
</html>  