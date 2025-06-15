# Blog Platform – KIT202 Assignment 2

This repository contains the source code for a blogging web application developed as part of Assignment 2 for **KIT202 Web Programming Fundamentals** at the University of Tasmania.

This assignment involved extending an earlier front-end prototype into a fully functional dynamic website by implementing server-side logic, user authentication, form validation, and persistent storage using PHP and MySQL.

---

## Features

- Secure user registration and login
- Write, view, and manage blog posts
- Session management using PHP
- Form validation using JavaScript
- Responsive layout and styling with custom CSS
- Modular code structure for scalability
- Integration of logo and brand elements

---

## Technologies Used

- HTML5, CSS3
- JavaScript (vanilla)
- PHP
- MySQL
- Git for version control

---

## Project Structure

```
.
├── db_connect.php
├── index.php
├── login.php
├── logout.php
├── message.php
├── older.php
├── our_story.php
├── README.md
├── register.php
├── structure.txt
├── write.php
├── css/
│   └── styles.css
├── database_design/
│   ├── Data Dictionary AT2.pdf
│   └── ERD KIT202 AT2.pdf
├── javascript/
│   ├── content_toggle.js
│   ├── ui_behaviour.js
│   └── validation.js
└── logos/
    ├── horizontal_logo_dark.png
    ├── horizontal_logo_light.png
    ├── vertical_logo_dark.png
    └── vertical_logo_light.png
```

---

## Setup Instructions

1. Clone the repository to your local machine:
   ```bash
   git clone https://github.com/jrcrisford/blog-platform-kit202.git
   ```

2. Import the MySQL database using the provided SQL script if applicable.

3. Place the project in your server root directory (e.g., `htdocs` for XAMPP).

4. Update `db_connect.php` with your own database credentials.

5. Launch the application by navigating to `http://localhost/index.php`.

---

## Author

**Joshua Crisford**  
Bachelor of ICT – Games & Creative Technologies & Cybersecurity  
University of Tasmania

---

## License

This project and its contents are the intellectual property of Joshua Crisford.  
**Not for commercial use. Redistribution without permission is prohibited.**
