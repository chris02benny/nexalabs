<?php
session_start();
require_once '../includes/db_connection.php';

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../enquiry.php');
    exit;
}

$pdo = isset($GLOBALS['pdo']) ? $GLOBALS['pdo'] : require_once '../includes/db_connection.php';

// Sanitize and validate input
$name = htmlspecialchars(trim($_POST['name'] ?? ''));
$email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
$phone = htmlspecialchars(trim($_POST['phone'] ?? ''));
$message = htmlspecialchars(trim($_POST['message'] ?? ''));

// Validate required fields
if (empty($name) || empty($email) || empty($message)) {
    $_SESSION['error'] = 'Please fill in all required fields.';
    header('Location: ../enquiry.php');
    exit;
}

// Validate email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error'] = 'Please enter a valid email address.';
    header('Location: ../enquiry.php');
    exit;
}

// Insert into database table (enquiries table)
// Schema: id, name, email, phone, message, created_at
try {
    $insertStmt = $pdo->prepare("INSERT INTO enquiries (name, email, phone, message, created_at) VALUES (?, ?, ?, ?, NOW())");
    $insertStmt->execute([$name, $email, $phone ?: null, $message]);
    
    // Set success message
    $_SESSION['enquiry_success'] = true;
    
    // Redirect back to enquiry page
    header('Location: ../enquiry.php');
    exit;
} catch (PDOException $e) {
    error_log("Insert Enquiry Error: " . $e->getMessage());
    $_SESSION['error'] = 'An error occurred while submitting your enquiry. Please try again.';
    header('Location: ../enquiry.php');
    exit;
}
?>
