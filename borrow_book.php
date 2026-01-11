<?php
require_once 'config.php';
require_once 'helpers.php';
require_member();
$user = $_SESSION['user'];

if(!isset($_GET['id'])) redirect('books.php');

$book_id = intval($_GET['id']);

// 1. Check if book exists and has copies
$stmt = $conn->prepare("SELECT copies FROM books WHERE id=?");
$stmt->bind_param("i", $book_id);
$stmt->execute();
$res = $stmt->get_result();
$book = $res->fetch_assoc();

if(!$book || $book['copies'] < 1) {
    redirect('books.php?error=not_available');
}

// 2. FIX: Check if member already has an active borrow for this book
$stmt_check = $conn->prepare("SELECT id FROM borrowings WHERE book_id=? AND member_id=? AND status='borrowed'");
$stmt_check->bind_param("ii", $book_id, $user['id']);
$stmt_check->execute();
if($stmt_check->get_result()->num_rows > 0) {
    redirect('books.php?error=already_borrowed');
}

// 3. Insert Borrowing record
$stmt2 = $conn->prepare("INSERT INTO borrowings (book_id, member_id) VALUES (?,?)");
$stmt2->bind_param("ii", $book_id, $user['id']);
$stmt2->execute();

// 4. Update Book copies
$stmt3 = $conn->prepare("UPDATE books SET copies=copies-1 WHERE id=?");
$stmt3->bind_param("i", $book_id);
$stmt3->execute();

// Redirect back to browse with success message
redirect('books.php?success=borrowed');