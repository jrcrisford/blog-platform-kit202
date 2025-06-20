<?php
    include_once 'db_connect.php';
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Check the user's role
    $role = $_SESSION['role'] ?? 'visitor';
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
        <script src="javascript/content_toggle.js" defer></script>
        <script src="javascript/ui_behaviour.js" defer></script>
        <title>Our Story Page</title>
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
                        <li><a href="our_story.php" class="active">Our Story</a></li>

                        <!-- Login/Register/Logout Links -->
                        <?php if ($role === 'member' || $role === 'author'): ?>
                            <li>Logged in as <?php echo htmlspecialchars($_SESSION['username']); ?></li>
                            <li><a href="logout.php">Logout</a></li>
                        <?php else: ?>
                            <li><a href="login.php">Login</a></li>
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

        <!-- Page content start-->
         <main class="container">

            <!--Page Title-->
            <section class="page-header">
                <h2>Our Story</h2>
                <p>This page provides an overview of our team, the theme of our blog, how the project was developed, and the tools and techniques we used along the way.</p>
                <br>

                <div class="info">
                    <h3>Group Members</h3>
                        <table>
                            <tr>
                                <th>Name</th>
                                <th>Student ID</th>
                            </tr>
                            <tr>
                                <td>Joshua Crisford</td>
                                <td>574082</td>
                            </tr>
                            <tr>
                                <td>Anmol Daulyal</td>
                                <td>679160</td>
                            </tr>
                            <tr>
                                <td>Dipen Subedi</td>
                                <td>679194</td>
                            </tr>
                        </table>
                </div>
            </section>

            <br>

            <section class="page-header">
                <div class="text-left-section">

                    <h3>Site Theme</h3>
                    <p>
                        Our site theme is called <strong>"Everything Explained"</strong>.
                        It’s designed to be a flexible and user-friendly blog where users can post 
                        about any topic of interest—no matter how random or niche.
                        The design focuses on clarity, readability, and modern aesthetics using a 
                        glassmorphism style.
                        Features like dark mode, responsive navigation, and collapsible post sections 
                        enhance the usability and interactivity of the site across devices.
                    </p>

                    <br>

                    <h3>Use of generative AI</h3>
                    <p>
                        Generative AI tools, such as ChatGPT by OpenAI and Copilot, were used minimally throughout Assignment 1 and 2 to assist with:
                    </p>
                    <br>
                    <ul>
                        <li>Auto-completion of code</li>
                        <li>Grammar and spell checking of development log entries</li>
                        <li>Minor syntax error checking in JavaScript and HTML</li>
                        <li>Spell-checking and small wording improvements</li>
                        <li>Asking clarifying questions when stuck on technical or styling issues</li>
                        <li>Generating the README file</li>
                        <li>Generating sample blog post content for placeholder use</li>
                        <li>Generating the site logo png files</li>
                        <li>Debugging of chunks of code</li>
                        <li>All website posts were written by ChatGPT</li>
                    </ul>

                    <br>

                    <h3>HD Level Enhancements</h3>
                    <p>
                        The following high distinction-level features were implemented to enhance functionality, usability, and design consistency across the blog platform.
                        Features marked under Assignment 1 were implemented in the first phase of development, while features noted under Assignment 2 were added in the second phase.
                    </p>
                    <br>
                    <ul>
                        <li><strong>Dark Mode Toggle</strong> – <em>(AT1)</em> A fully functional dark mode switch that saves user preference using <code>localStorage</code> and updates both theme and logo accordingly.</li>
                        <li><strong>Responsive Navigation</strong> – <em>(AT1)</em> Includes a hamburger menu for mobile views and flexible layout using CSS media queries. Also supports full mobile use.</li>
                        <li><strong>Glassmorphism Design</strong> – <em>(AT1)</em> Modern visual style with layered backgrounds, blur effects, and soft shadows for a sleek, polished aesthetic.</li>
                        <li><strong>Reusable Form Validation Script</strong> – <em>(AT1)</em> A single <code>validation.js</code> file handles input validation across multiple pages with real-time feedback.</li>
                        <li><strong>Dynamic Logo Switching</strong> – <em>(AT1)</em> The header logo image dynamically updates to match the selected theme (dark/light).</li>
                        <li><strong>Post Rating System</strong> – <em>(AT2)</em> Logged-in users can rate posts from 1–5 stars, with each user restricted to one rating per post.</li>
                        <li><strong>Commenting System</strong> – <em>(AT2)</em> Logged-in users can submit comments on individual posts, with timestamps and display of commenter usernames.</li>
                        <li><strong>Search Functionality</strong> – <em>(AT2)</em> Posts on the "Older Posts" page can be filtered by keywords in their title or tags using a search bar.</li>
                    </ul>

                    <br>

                    <h3>Tools and Techniques Used</h3>
                    <p>
                        The project was developed using a combination of HTML, CSS, JavaScript, and PHP for the frontend and backend functionality.
                        The database was designed using MySQL, with phpMyAdmin used for management.
                        The site was styled using CSS with a focus on glassmorphism design principles.
                        JavaScript was used for client-side interactivity, including form validation and dynamic content toggling.
                        The project also utilised Git for version control and collaboration.
                    </p>

                </div>
            </section>

            <br>

            <section id="info-section">

                <div class="info">
                    <h3>Development Log</h3>
                    <table>
                        <tr>
                            <th>Date</th>
                            <th>Task</th>
                            <th>Author</th>
                        </tr>
                        <tr>
                            <td>2025-03-26</td>
                            <td>Inital Project Setup & Inital HTML</td>
                            <td>Joshua Crisford</td>
                        </tr>
                        <tr>
                            <td>2025-03-27</td>
                            <td>Older Posts Page and Toggle Function Setup</td>
                            <td>Joshua Crisford</td>
                        </tr>
                        <tr>
                            <td>2025-03-28</td>
                            <td>Write Page Validation and Visual Feedback Enhancements</td>
                            <td>Joshua Crisford</td>
                        </tr>
                        <tr>
                            <td>2025-04-08</td>
                            <td>Improved Write Form Validation with Simultaneous Error Feedback</td>
                            <td>Joshua Crisford</td>
                        </tr>
                        <tr>
                            <td>2025-04-09</td>
                            <td>Added user registration and login functionality</td>
                            <td>Dipen Subedi</td>
                        </tr>
                        <tr>
                            <td>2025-04-09</td>
                            <td>Initialised the styling using CSS</td>
                            <td>Dipen Subedi</td>
                        </tr>
                        <tr>
                            <td>2025-04-09</td>
                            <td>"Updated the CSS with improvements and ensured the corresponding HTML files were updated to reflect those changes</td>
                            <td>Dipen Subedi</td>
                        </tr>
                        <tr>
                            <td>2025-04-09</td>
                            <td>Refactored Form Validation into Reusable Site-Wide Script</td>
                            <td>Joshua Crisford</td>
                        </tr>
                        <tr>
                            <td>2025-04-10</td>
                            <td>Created JavaScript functionality for Dark theme, Menu responsiveness and hamburger toggle</td>
                            <td>Anmol Daulyal</td>
                        </tr>
                        <tr>
                            <td>2025-04-10</td>
                            <td>Implemenetion of created JS and CSS on the project</td>
                            <td>Anmol Daulyal</td>
                        </tr>
                        <tr>
                            <td>2025-04-10</td>
                            <td>UI Polish and Devlog Integration</td>
                            <td>Joshua Crisford</td>
                        </tr>
                        <tr>
                            <td>2025-04-11</td>
                            <td>Styling of the blog pages using CSS</td>
                            <td>Anmol Daulyal</td>
                        </tr>
                        <tr>
                            <td>2025-04-11</td>
                            <td>Giving the blog a proper theme and finishing touches </td>
                            <td>Anmol Daulyal</td>
                        </tr>
                        <tr>
                            <td>2025-04-11</td>
                            <td>Finalised the UI design</td>
                            <td>Dipen Subedi</td>
                        </tr>
                        <tr>
                            <td>2025-05-16</td>
                            <td>Frontend Polish Based on AT1 Feedback</td>
                            <td>Joshua Crisford</td>
                        </tr>
                        <tr>
                            <td>2025-05-17</td>
                            <td>Database Design and Implementation Complete</td>
                            <td>Joshua Crisford</td>
                        </tr>
                        <tr>
                            <td>2025-05-20</td>
                            <td>Login and Register Backend Integration</td>
                            <td>Joshua Crisford</td>
                        </tr>
                        <tr>
                            <td>2025-05-25</td>
                            <td>Updated the site to handle user insertion retrieve posts with tags and author</td>
                            <td>Dipen Subedi</td>
                        </tr>
                        <tr>
                            <td>2025-05-25</td>
                            <td>Modified the code writtehn by Josh with improved logic</td>
                            <td>Dipen Subedi</td>
                        </tr>
                        <tr>
                            <td>2025-05-25</td>
                            <td>Added password verification and session management to redirect users upon successful or failed login attempts.</td>
                            <td>Dipen Subedi</td>
                        </tr>
                        <tr>
                            <td>2025-05-25</td>
                            <td>Modified and added logic to display each post's author and tags by retrieving user and tag details dynamically for each post.</td>
                            <td>Dipen Subedi</td>
                        </tr>
                        <tr>
                            <td>2025-05-26</td>
                            <td>Session Handling and Dynamic Navigation</td>
                            <td>Joshua Crisford</td>
                        </tr>
                        <tr>
                            <td>2025-05-26</td>
                            <td>Added post creation functionality with automatic tag handling, including functions to create tags, associate them with posts, and extract dates from datetime values.</td>
                            <td>Dipen Subedi</td>
                        </tr>
                        <tr>
                            <td>2025-05-26</td>
                            <td>DB integration, restrucure and fetching homepage posts from database</td>
                            <td>Anmol Daulyal</td>
                        </tr>
                        <tr>
                            <td>2025-05-26</td>
                            <td>Retrieve older psts from the database</td>
                            <td>Anmol Daulyal</td>
                        </tr>
                        <tr>
                            <td>2025-05-27</td>
                            <td>Integrated role based navigation</td>
                            <td>Anmol Daulyal</td>
                        </tr>
                        <tr>
                            <td>2025-05-28</td>
                            <td>Updated and modified navigation role checks for better session validation</td>
                            <td>Dipen Subedi</td>
                        </tr>
                        <tr>
                            <td>2025-05-29</td>
                            <td>Success and error messages, comments and ratings functions added</td>
                            <td>Anmol Daulyal</td>
                        </tr>
                        <tr>
                            <td>2025-05-30</td>
                            <td>Added support for comment and rating submission with form handling, user session checks, dynamic comment display per post, and a collapsible comments section with input form for logged-in users.</td>
                            <td>Dipen Subedi</td>
                        </tr>
                        <tr>
                            <td>2025-05-30</td>
                            <td>Final Development Pass</td>
                            <td>Joshua Crisford</td>
                        </tr>
                    </table>
                </div>
            </section>

            <br>

            <section id="info-section">
                <h3>Development Log Details</h3>

                <article class="blog-post">
                    <h3>Inital Project Setup & Inital HTML</h3>
                    <p class="post-meta">Posted on 2025-03-26 by Joshua Crisford</p>
                    <button onclick="toggleContent(this)">Show Content</button>
                    <div class="post-content hidden">
                        <p>
                            Started by creating the initial project setup. This included creating the project folder structure 
                            (html, css, js) and added all the required HTML files with names relevant to the pages they related 
                            too and the basic HTML boilerplate. Created an empty shared stylesheet and linked JavaScript files 
                            for each page that sounded like it might require them.<br>
                            Built out index.html with a semantic structure that included a header which included navigation, 
                            however I'm unsure if this should be within the header or as a separate element, three complete 
                            placeholder blog posts, and a footer. Each of the posts contains a title, metadata (name, date), 
                            tags, and content of 150 words each.
                        </p>
                    </div>
                </article>

                <article class="blog-post">
                    <h3>Older Posts Page and Toggle Function Setup</h3>
                    <p class="post-meta">Posted on 2025-03-27 by Joshua Crisford</p>
                    <button onclick="toggleContent(this)">Show Content</button>
                    <div class="post-content hidden">
                        <p>
                            I began the <code>older.html</code> file. Initially one blog post was set up with the same layout as 
                            the ones in <code>index.html</code> but also included a toggle button to reveal or hide its content 
                            using the <code>older.js</code> script. The toggle worked by placing a &lt;button&gt; element above 
                            a hidden &lt;div&gt; containing the content and using JavaScript to detect the button click and switch 
                            the ‘hidden’ class on the next sibling element. Figuring out how to locate the element to toggle and 
                            assign it to a variable involved a bit of research — I found that the <code>.nextElementSibling</code> 
                            property was suitable.<br>
                            During testing, I couldn’t get the JavaScript to run. I later figured out that the script path was 
                            incorrect, and the CSS path also had typos. Because the JS file was stored in a folder outside the one 
                            with the HTML file, I needed to change the &lt;script&gt; tag to use a relative path 
                            (<code>../js/older.js</code> rather than <code>js/older.js</code>) — which, in retrospect, makes sense.
                        </p>
                    </div>
                </article>

                <article class="blog-post">
                    <h3>Write Page Validation and Visual Feedback Enhancements</h3>
                    <p class="post-meta">Posted on 2025-03-28 by Joshua Crisford</p>
                    <button onclick="toggleContent(this)">Show Content</button>
                    <div class="post-content hidden">
                        <p>
                            Completed the <code>write.html</code> page, included all required form fields (title, tags, content), 
                            plus the header, navigation, and footer. Added JavaScript validation rules in 
                            <code>write.js</code> to ensure no fields can be left empty and that the title doesn’t exceed 80 characters.
                            I also improved visual feedback by using <code>reportValidity()</code> to show browser error messages and 
                            added red borders around relevant fields. Initially, there were issues clearing the error styling on resubmission, 
                            but these were resolved by resetting the validation state within the event listener.
                            Console logs were added throughout for debugging — confirming script load, when validation begins, and why 
                            a submission fails. Logs were also added to the completed <code>older.js</code> for consistency.
                        </p>
                    </div>
                </article>

                <article class="blog-post">
                    <h3>Improved Write Form Validation with Simultaneous Error Feedback</h3>
                    <p class="post-meta">Posted on 2025-04-08 by Joshua Crisford</p>
                    <button onclick="toggleContent(this)">Show Content</button>
                    <div class="post-content hidden">
                        <p>
                            Made improvements to the write post form validation. Before, a single error would display at a time —
                            a limitation of using <code>reportValidity()</code>. This meant the validation was likely not to the
                            assignment spec, so the logic was changed to check all fields and show relevant error messages simultaneously.
                            <code>&lt;span&gt;</code> elements for each input were added to display these messages, and they were styled
                            using CSS to ensure visual feedback for the user.
                        </p>
                    </div>
                </article>

                <article class="blog-post">
                    <h3>Added user registration and login functionality also styled the site</h3>
                    <p class="post-meta">Posted on 2025-04-09 by Dipen Subedi</p>
                    <button onclick="toggleContent(this)">Show Content</button>
                    <div class="post-content hidden">
                        <p>
                            Today, I completed setting up the user registration and login functionality, allowing new users to join our blog.
                            The form is integrated with JavaScript for input validation. While testing, I noticed some classes and IDs were
                            incorrectly set up, which affected the styling and functionality. I'll fix these issues to ensure everything
                            works as expected.
                        </p>                        
                    </div>
                </article>

                <article class="blog-post">
                    <h3>Refactored Form Validation into Reusable Site-Wide Script</h3>
                    <p class="post-meta">Posted on 2025-04-09 by Joshua Crisford</p>
                    <button onclick="toggleContent(this)">Show Content</button>
                    <div class="post-content hidden">
                        <p>
                            Today I refactored <code>write.js</code> and renamed it to <code>validation.js</code> so it could act as a single
                            script handling form validation across multiple pages on the site. The logic was restructured into a reusable format
                            using arrays and loops, making it easier to validate different forms. I also completed the validation rules for both
                            the login and register pages, including password confirmation and email format checks. These changes improve input
                            consistency and reduce future maintenance.
                        </p>                        
                    </div>
                </article>

                <article class="blog-post">
                    <h3>Expanding the Project than its core</h3>
                    <p class="post-meta">Posted on 2025-04-09 by Anmol Daulyal</p>
                    <button onclick="toggleContent(this)">Show Content</button>
                    <div class="post-content hidden">
                        <p>
                            Joshua had built our base of the project and implemented most of the necessary requirements. 
                            We discussed on going for the HD where I polished our blogpage he had initiated and added features 
                            such as dark theme, hamburger toggle and scroll-to-up button. I couldnt complete the sticky navigation 
                            on the project. I had some trouble with the hamburger toggle but it turned out I was not using navLinks 
                            as the id for the ul which caused it to not be able to display navigation links to other pages
                        </p>
                    </div>
                </article>

                <article class="blog-post">
                    <h3>UI Polish and Devlog Integration</h3>
                    <p class="post-meta">Posted on 2025-04-10 by Joshua Crisford</p>
                    <button onclick="toggleContent(this)">Show Content</button>
                    <div class="post-content hidden">
                        <p>
                            Today I focused on improving a little of the visual presentation of the login and register forms. 
                            I added styling to match the rest of the site. Adjustments were made to the error messages to make 
                            them clearer and more consistent across pages. I then made sure that my devlog entries were added to 
                            the our story page and included the collapsible post format like the older posts page and I corrected 
                            some small issues in layout and formatting.
                        </p>                        
                    </div>
                </article>

                <article class="blog-post">
                    <h3>Initialised css</h3>
                    <p class="post-meta">Posted on 2025-04-10 by Dipen Subedi</p>
                    <button onclick="toggleContent(this)">Show Content</button>
                    <div class="post-content hidden">
                        <p>
                            The main goal was to enhance the layout using CSS to achieve the best possible look. The challenge, 
                            however, was deciding which style to go with. After watching numerous videos on both glassmorphism and 
                            neumorphism, I found myself particularly drawn to both styles. Ultimately, the decision was clear, and 
                            I decided to start with a glassmorphism-inspired design. As the project progressed, I continued to refine 
                            and build upon this aesthetic, ultimately completing the entire design using the same glassmorphism style.
                        </p>                        
                    </div>
                </article>

                <article class="blog-post">
                    <h3>Polishing the webpage and the UI</h3>
                    <p class="post-meta">Posted on 2025-04-10 by Anmol Daulyal</p>
                    <button onclick="toggleContent(this)">Show Content</button>
                    <div class="post-content hidden">
                        <p>
                            I also focused highly on the initial CSS of the UI features which I made sure ran smoothly. After that 
                            I focused on polishing the codes that I had written which were still a bit buggy and had some glitches 
                            in certain pages. After than I focused on the Theme of the blog page and made sure it was something 
                            interesting to actually build on future.
                        </p>                        
                    </div>
                </article>

                <article class="blog-post">
                    <h3>Finalised the UI design</h3>
                    <p class="post-meta">Posted on 2025-04-10 by Dipen Subedi</p>
                    <button onclick="toggleContent(this)">Show Content</button>
                    <div class="post-content hidden">
                        <p>
                            Today, I finished designing the website. While I initially started the design, my friend Anmol Daulyal 
                            added his own unique touch to the site. However, I felt there was still more that could be done, so I 
                            sought inspiration from various YouTube videos and websites. With these ideas in mind, I refined the 
                            design, incorporating gradients, smooth transitions, transformations, and other components to give the 
                            site a sleek and elegant look. The result is a website that feels both modern and polished.
                        </p>
                    </div>
                </article>

                <article class="blog-post">
                    <h3>Frontend Polish Based on AT1 Feedback</h3>
                    <p class="post-meta">Posted on 2025-05-16 by Joshua Crisford</p>
                    <button onclick="toggleContent(this)">Show Content</button>
                    <div class="post-content hidden">
                        <p>
                            Today I addressed the feedback given for Assignment 1 to improve the frontend before starting backend integration.
                            <ul>
                                <li>Locked the width of the textarea in the Write Post page to prevent resizing layout issues.</li>
                                <li>Added a reset handler to the validation JavaScript to clear validation error messages and input styling on form clear.</li>
                                <li>Enforced a username length constraint (3–20 characters) on the registration form.</li>
                                <li>Restyled the [Show Content] button on the Older Posts page to reduce the visual dominance on the button.</li>
                                <li>Removed the hover layout shift on blog post cards by eliminating the transform animation and fixing shadow transitions.</li>
                            </ul>
                            These changes improve the user experience, address the feedback from the AT1 marker, and set a solid foundation for the upcoming backend content.
                        </p>
                    </div>
                </article>

                <article class="blog-post">
                    <h3>Database Design and Implementation Complete</h3>
                    <p class="post-meta">Posted on 2025-05-17 by Joshua Crisford</p>
                    <button onclick="toggleContent(this)">Show Content</button>
                    <div class="post-content hidden">
                        <p>
                            Today I completed the full database design and implementation for the blog, laying the foundation for the backend functionality to follow.
                            This included designing the Entity Relationship Diagram (ERD) using Crow’s Foot notation with all the required entities, plus additional ones to support HD-level features: users, posts, tags, comments, and ratings.
                            I ensured all relationships and constraints were clearly defined where appropriate. An in-depth data dictionary was also created to outline the structure of each table, including rules and example data values.
                        </p>
                        <p>
                            With the design finalised, I implemented the schema in phpMyAdmin using SQL <code>CREATE TABLE</code> statements (I prefer writing raw SQL rather than using the GUI), and inserted test data across all tables to prepare for backend development.
                            This confirmed that the database worked as intended and according to the designed schema, and was ready to support dynamic content through PHP.
                        </p>
                    </div>
                </article>

                <article class="blog-post">
                    <h3>Login and Register Backend Integration</h3>
                    <p class="post-meta">Posted on 2025-05-20 by Joshua Crisford</p>
                    <button onclick="toggleContent(this)">Show Content</button>
                    <div class="post-content hidden">
                        <p>
                            Today I implemented the login and registration systems using PHP and connected them to the database.
                            The <code>register.php</code> script accepts input from the registration form, checks for issues like duplicate usernames or emails, hashes the password, and stores the new user in the database with the default role of “member”.
                            The <code>login.php</code> script retrieves the user by their username, verifies the password using <code>password_verify()</code>, stores the relevant user information in PHP session variables, and redirects to the (soon-to-be-built) PHP version of the homepage.
                        </p>
                        <p>
                            I encountered a major issue during development caused by the browser caching an older version of <code>validation.js</code>.
                            Despite updating the JavaScript file on the web server, the browser continued executing the outdated version, which redirected users to <code>index.html</code> and bypassed the backend PHP scripts entirely.
                            The issue was resolved by appending <code>?v=3</code> to the <code>&lt;script&gt;</code> tag in each HTML file using the validation script.
                            A very simple fix for a problem that took hours to track down!
                        </p>
                        <p>
                            To simplify future development, I also created a shared <code>db_connect.php</code> file that handles the database connection.
                            This file can now be included in any PHP script using <code>require_once</code>, removing the need to repeat connection logic in every file.
                        </p>
                    </div>
                </article>

                <article class="blog-post">
                    <h3>Implementation of User Authentication and Post Retrieval System</h3>
                    <p class="post-meta">Posted on 2025-05-25 by Dipen Subedi</p>
                    <button onclick="toggleContent(this)">Show Content</button>
                    <div class="post-content hidden">
                        <p>
                            In this development phase, I implemented essential backend functionalities for user registration, login, and post retrieval in the db_connect.php, register.php, and 
                            login.php files. I began by enabling session management and creating a reusable connect() function for MySQLi connections. I then added the insertUser() function to securely
                            store user data with hashed passwords and a default role of 'member'. To support data access, I developed helper functions like getUserByID(), getUserByUsername(), and getUserByEmail(), 
                            all using prepared statements for security. For post handling, I built the getPosts() function to fetch recent posts, enriched with author names and tags through supporting helper functions. 
                            I also added disconnect() to ensure clean database connection closures. In register.php, I modified Josh’s code to improve modularity and maintainability. I added checks for existing usernames 
                            and emails using the new helper functions and handled user feedback accordingly. On successful registration, users are redirected to the login page. Finally, I completed the login.php logic using password_verify() and set up session variables upon successful login, with clear error handling for failed attempts.
                        </p>
                    </div>
                </article>

                <article class="blog-post">
                    <h3>Session Handling and Dynamic Navigation</h3>
                    <p class="post-meta">Posted on 2025-05-26 by Joshua Crisford</p>
                    <button onclick="toggleContent(this)">Show Content</button>
                    <div class="post-content hidden">
                        <p>
                            Today I implemented proper session handling across all pages and updated the navigation bar to reflect the user's login state and role.
                            Users now only see pages they’re allowed to access based on whether they’re a visitor, member, or author.
                            I also addressed a few smaller issues, including fixing tag handling in the post creation form and clarifying how to enter multiple tags with a user hint.
                        </p>
                    </div>
                </article>

                 <article class="blog-post">
                    <h3>Loading older posts from database</h3>
                    <p class="post-meta">Posted on 2025-05-26 by Anmol Daulyal</p>
                    <button onclick="toggleContent(this)">Show Content</button>
                    <div class="post-content hidden">
                        <p>
                           Refactored the function for retrieving posts from DB to use JOIN queries to fetch the author and tags in a single query. This changes improved performance and reduced the number of queries needed to display posts.
                        </p>
                        <p>
                            The older posts page now dynamically loads psts from the DB making use of the function described above to fetch posts. Apart from that I faced problems while working on older.html file. I wamted to change it into a php but I was denied request so I committed it as an html and my partner Joshua fixed it next morning.
                        </p>

                    </div>
                </article>

                <article class="blog-post">
                    <h3>Implementation of Post Insertion and Tag Management System</h3>
                    <p class="post-meta">Posted on 2025-05-26 by Dipen Subedi</p>
                    <button onclick="toggleContent(this)">Show Content</button>
                    <div class="post-content hidden">
                        <p>
                        In this stage, I implemented post creation functionality with support for tagging. The insertPost() function was developed to allow logged-in users to add new posts, which are then linked to the database using prepared statements for security. Tags can be attached to each post—these are either fetched using getTagByName() or created using createTag() if they don’t exist. The createPostTag() function then associates each tag with the corresponding post. I also added a getDateFromDateTime() utility to extract date values cleanly from datetime entries. Additionally, I ensured proper session handling and fetched the three most recent posts on page load via getPosts() for display. This modular approach improves code maintainability and data integrity</p>
                    </div>
                </article>

                
                <article class="blog-post">
                    <h3>Session Handling and Dynamic Navigation</h3>
                    <p class="post-meta">Posted on 2025-05-27 by Anmol Daulyal</p>
                    <button onclick="toggleContent(this)">Show Content</button>
                    <div class="post-content hidden">
                        <p>
                           Focused on the navigation of the write post page to restrict authors. Also, merged multiple html files to create the php files to control the access of the write page in the navigation.
                           Fixed multiple files containing referencing issus.
                        </p>
                    </div>
                </article>

                <article class="blog-post">
                    <h3>Bug Fixes and Functional Testing</h3>
                    <p class="post-meta">Posted on 2025-05-28 by Dipen Subedi</p>
                    <button onclick="toggleContent(this)">Show Content</button>
                    <div class="post-content hidden">
                        <p>
                        During this stage, I fixed some bugs and performed testing by checking different sections of the site to ensure everything was functioning properly.
                    </p>
                    </div>
                </article>

                 <article class="blog-post">
                    <h3>Success and error messages handling, comment and rating functionality</h3>
                    <p class="post-meta">Posted on 2025-05-29 by Anmol Daulyal</p>
                    <button onclick="toggleContent(this)">Show Content</button>
                    <div class="post-content hidden">
                        <p>
                           I implemented success and error message handling across sites using PHp sessions. Created message.php to show messages accordingly to the users interaction with the webpage.
                        </p>
                        <p>
                            I also added rating and commenting functionality to the posts and leave comments which are stored in the DB and rating system is also added.
                    </div>
                </article>

                <article class="blog-post">
                    <h3>Commenting & Ratings Integration & Bug Troubleshooting</h3>
                    <p class="post-meta">Posted on 2025-05-30 by Dipen Subedi</p>
                    <button onclick="toggleContent(this)">Show Content</button>
                    <div class="post-content hidden">
                        <p>
                          This development cycle implemented comment and rating functionality across index.php
                          ,older.php, including session management, database operations, and JavaScript UI toggles.
                        The implementation worked perfectly in Microsoft Edge but encountered significant issues in Chrome, where form submissions behaved inconsistently and comments failed to post properly despite identical code execution. </p>
                        <p>
                        Key Changes:<br>
                        </p>
                        index.php - Added comment submission with POST handling, session validation, and database inserts. Fixed $_POST['post_id'] field mismatch causing Chrome issues. Implemented toggle-comments section with authentication restrictions.
                        older.php - Applied similar functionality plus search capabilities and pagination. Added user notifications and redirect logic to prevent resubmission.
                        write.php - Added session messaging for post creation feedback.
                        content_toggle.js - Created toggleComments(id) function for consistent cross-browser comment visibility control.
                        <p>
                        This development revealed notable cross-browser compatibility challenges in form handling and session management. While most functionality is stable, Chrome's inconsistent behavior requires further investigation.
                        </p>
                    </div>
                </article>

                <article class="blog-post">
                    <h3>Final Development Pass</h3>
                    <p class="post-meta">Posted on 2025-05-30 by Joshua Crisford</p>
                    <button onclick="toggleContent(this)">Show Content</button>
                    <div class="post-content hidden">
                        <p>
                            Getting toward the deadline for submission, today I focused on implementing the final piece of functionality, the search bar.
                            This allows users to filter posts by title or tag on the Older Post page.
                            This ended up requiring a lot of debugging, like constantly changing the SQL logic to make it actually work,
                            as well as fixing issues that caused searches to return no results.
                            I also worked on fixing the toggle comments button, which previously failed to consistently show or hide the comments section.
                            Another key bug fix was resolving why comments weren’t displaying, which was caused by problems in how user ratings and comments were being merged.
                        </p>
                        <p>
                            After the fixes, I did a full project pass to ensure we were meeting all assignment requirements.
                            I also updated the Our Story page to reflect the new information required in assignment 2.
                            Overall, the final polish ensured everything was working as intended and that the presentation was clean and consistent.
                        </p>
                    </div>
                </article>

            </section>

         </main>

         <footer>
            <p><p>KIT202 Assignment 1 | Everything Explained</p></p>

         </footer>
         <button id="scrollToTopBtn" title="Go to top">↑</button>
    </body>
</html>  