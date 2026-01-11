Arghya Library Management System
A sleek, Midnight Cyberpunk themed library management platform built with PHP and Tailwind CSS. This system provides distinct interfaces for librarians to manage inventory and members to browse and borrow books.

🚀 Features
Role-Based Access Control: Dedicated dashboards for Librarians and Members.

Inventory Management: Full CRUD (Create, Read, Update, Delete) operations for books.

Borrowing System: Real-time stock tracking and borrowing history.

Visual Gallery: Upload and view book cover assets.

Modern UI: High-contrast, glassmorphic design powered by Tailwind CSS.

🛠️ Tech Stack
Backend: PHP 8.x

Database: MySQL / MariaDB

Frontend: Tailwind CSS

Icons/Fonts: Changa One (Google Fonts)

📂 Project Structure
/partials: Contains reusable UI components like header.php and footer.php.

/uploads: Storage directory for book cover images.

config.php: Database connection settings.

helpers.php: Core security functions and session management.

🔧 Installation
Clone the repository to your local server (XAMPP/WAMP/MAMP).

Import the Database:

Open phpMyAdmin.

Create a database named library_system.

Import the db.sql file provided in the root directory.

Configure Database:

Open config.php and update your database credentials (DB_USER, DB_PASS).

Launch:

Navigate to http://localhost/your-project-folder/index.php.

🔒 Security Features
Password Hashing: All user passwords are encrypted using password_hash().

XSS Protection: Data output is escaped via a custom e() helper function.

Session Guard: Middleware functions ensure only authorized roles can access specific pages.

Created for Arghya Library