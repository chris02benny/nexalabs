<?php
session_start();

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../admin_register.php');
    exit;
}

$pdo = require_once '../includes/db_connection.php';

// Get form data
$username = trim($_POST['username'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';

// Validate input
if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
    $_SESSION['register_error'] = 'Please fill in all fields.';
    header('Location: ../admin_register.php');
    exit;
}

// Validate username format (alphanumeric and underscores only, 3-50 chars)
if (!preg_match('/^[a-zA-Z0-9_]{3,50}$/', $username)) {
    $_SESSION['register_error'] = 'Username must be 3-50 characters and contain only letters, numbers, and underscores.';
    header('Location: ../admin_register.php');
    exit;
}

// Validate email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['register_error'] = 'Please enter a valid email address.';
    header('Location: ../admin_register.php');
    exit;
}

// Validate password length
if (strlen($password) < 6) {
    $_SESSION['register_error'] = 'Password must be at least 6 characters long.';
    header('Location: ../admin_register.php');
    exit;
}

// Check if passwords match
if ($password !== $confirm_password) {
    $_SESSION['register_error'] = 'Passwords do not match.';
    header('Location: ../admin_register.php');
    exit;
}

try {
    // Check if username already exists
    $checkStmt = $pdo->prepare("SELECT id FROM admins WHERE username = ? LIMIT 1");
    $checkStmt->execute([$username]);
    if ($checkStmt->fetch()) {
        $_SESSION['register_error'] = 'Username already exists. Please choose a different username.';
        header('Location: ../admin_register.php');
        exit;
    }

    // Check if email already exists
    $checkEmailStmt = $pdo->prepare("SELECT id FROM admins WHERE email = ? LIMIT 1");
    $checkEmailStmt->execute([$email]);
    if ($checkEmailStmt->fetch()) {
        $_SESSION['register_error'] = 'Email already registered. Please use a different email.';
        header('Location: ../admin_register.php');
        exit;
    }

    // Hash password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert new admin
    $insertStmt = $pdo->prepare("INSERT INTO admins (username, password, email) VALUES (?, ?, ?)");
    $insertStmt->execute([$username, $hashedPassword, $email]);

    // Success
    $_SESSION['register_success'] = true;
    header('Location: ../admin_register.php');
    exit;

} catch (PDOException $e) {
    error_log("Admin Registration Error: " . $e->getMessage());
    
    // Check for duplicate entry error
    if ($e->getCode() == 23000) {
        $_SESSION['register_error'] = 'Username or email already exists.';
    } else {
        $_SESSION['register_error'] = 'An error occurred. Please try again later.';
    }
    
    header('Location: ../admin_register.php');
    exit;
}
?>

