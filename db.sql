CREATE DATABASE IF NOT EXISTS library_system CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE library_system;

-- Users table
CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  role ENUM('librarian','member') NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Books table
CREATE TABLE IF NOT EXISTS books (
  id INT AUTO_INCREMENT PRIMARY KEY,
  librarian_id INT NOT NULL,
  title VARCHAR(200) NOT NULL,
  author VARCHAR(150) NOT NULL,
  category VARCHAR(100) NOT NULL,
  copies INT DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (librarian_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Borrowings table
CREATE TABLE IF NOT EXISTS borrowings (
  id INT AUTO_INCREMENT PRIMARY KEY,
  book_id INT NOT NULL,
  member_id INT NOT NULL,
  borrow_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  status ENUM('borrowed','returned') DEFAULT 'borrowed',
  FOREIGN KEY (book_id) REFERENCES books(id) ON DELETE CASCADE,
  FOREIGN KEY (member_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Gallery for book covers
CREATE TABLE IF NOT EXISTS gallery (
  id INT AUTO_INCREMENT PRIMARY KEY,
  book_id INT NOT NULL,
  filename VARCHAR(255) NOT NULL,
  uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (book_id) REFERENCES books(id) ON DELETE CASCADE
);
