<?php
    include_once 'db_connect.php';
    // Fetches most recent posts from the databse
    $posts = getPosts(3);
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
        <script src="javascript/ui_behaviour.js" defer></script>
        <title>Homepage</title>
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
                        <li><a href="index.php" class="active">Homepage</a></li>
                        <li><a href="older.html">Older Posts</a></li>
                        <li><a href="write.html">Write Post</a></li>
                        <?php if (isset($_SESSION['username'])): ?>
                            <li>Logged in as <?php echo htmlspecialchars($_SESSION['username']); ?></li>
                            <li><a href="logout.php">Logout</a></li>
                        <?php else: ?>
                            <li><a href="login.html">Login</a></li>
                            <li><a href="register.html">Register</a></li>
                        <?php endif; ?>
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

            <!-- Page Title -->
            <section class="page-header">
                <h2>Homepage</h2>
                <p>Welcome to our blog! Here you can find the latest posts and updates.</p>
            </section>

            <!-- Blog Post Section -->
            <section id="latest-posts">

                <?php
                // Display the most recent post
                if ($posts) {
                    foreach ($posts as $post) {
                        echo '<article class="blog-post"';
                        echo '<h3>' . htmlspecialchars($post)
                    }
                }

                <article class="blog-post">
                    <h3>Arsenal win Big against Real Madrid on Champions League Quarter Finals</h3>
                    <div class="post-content">
                        <p>Arsenal and Madrid, giants of their own leagues played a match last Wednesday on Emirates stadium. The home team bagged a victory against 
                            the Champions League royalty 15 times winning, Real Madrid. It was a 3-0 victory against the Spanish giants. The hero of the game was Declan
                            Rice netting two fabulous free kick goals all within ten minutes intervals by themselves. The game started with Arsenal being the underdogs 
                            between the two team but as the match progressed there was no doubt in anyone mind that Arsenal came to win that day and snagged a wonderful 
                            3 goal victory while keeping a clean sheet.<br/>
                            The win was praised by a lot of pundits who believed that the win was surely in name of Real Madrid. The game was a domination from London giants 
                            They face again soon a week later in Madrid home ground where they have had insane comeback of 4-3 against Manchester City back in 2023. Some fans still
                            believe Madrid have a chance but all that will be displayed on coming Wednesday, 5000 AEST.                     
                        </p>
                    </div>
                    <p>Posted on April 10, 2025 by Anmol Daulyal</p>
                    <p>
                        <span class="tags">Champions League</span>
                        <span class="tags">Football</span>
                        <span class="tags">UCL</span>
                    </p>
                </article>

                <article class="blog-post">
                    <h3>"Daredevil: The Blind Vigilante Who Sees Through the Darkness"</h3>
                    <div class="post-content">
                        <p>Daredevil, aka Matt Murdock, is one of Marvel’s most captivating heroes. Blinded by an accident as a child, Matt's remaining senses are heightened to superhuman levels, allowing him to "see" through sound and touch. By day, he's a lawyer in Hell's Kitchen, fighting for justice in the courtroom; by night, he’s the masked vigilante protecting the streets.

                            What sets Daredevil apart is his raw, gritty approach to crime-fighting—relying on his agility, senses, and martial arts skills instead of high-tech gadgets. His battles, both physical and moral, reflect his deep sense of duty to protect the vulnerable.
                            
                            Despite his blindness, Daredevil’s story is one of resilience and sacrifice. He shows us that true strength often comes from within, proving that even in the darkest places, there’s always room for hope.
                        </p>
                    </div>
                    <p>Posted on April 09, 2025 by Jane Doe</p>
                    <p>
                        <span class="tags">Matt</span>
                        <span class="tags">Daredevil</span>
                        <span class="tags">Marvel</span>
                    </p>
                </article>

                <article class="blog-post">
                    <h3>US and China Tariff-Off</h3>
                    <div class="post-content">
                        <p>President Trump has been on a different war lately. He has been playing Tariff-off with the chinese Prime Minister Xi-Jing Ping. 
                            The war started when president Trump threatened to increase Tariffs on goods all over. Trump had threatened with the Tariffs before he 
                            was elected as the President of The United States of America. When he rose to power he kept his promised and increased the promised Tariffs 
                            on the world. After he imposed on April 9th an announcement was made that he will suspend the Tariff due to positive response from the world leaders
                            but he increased the chinese tariffs to 125% which he stated as,"Disrespect from Beijing.<br/>
                            In Retaliation China also increased the Tariffs by 84% they have now been in this constant state of fight for two weeks now starting from 34% now has grown to 125%. 
                            And the worst part is it looks like a beginning of a very long war which will already affect the strained relationship further between the two big nations of the world.
        
                        </p>
                    </div>
                    <p>Posted on April 08th, 2025 by Dnmol Aulyal</p>
                    <p>
                        <span class="tags">Earum</span>
                        <span class="tags">Quam</span>
                        <span class="tags">Quidem</span>
                    </p>
                </article>

            </section>
        </main>

        <footer>
            <p>KIT202 Assignment 1 | Everything</p>
        </footer>

        <button id="scrollToTopBtn" title="Go to top">↑</button>


    </body>
</html>