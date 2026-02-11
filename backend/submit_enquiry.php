<?php
session_start();

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../enquiry.php');
    exit;
}

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

// Prepare data
$enquiry = [
    'name' => $name,
    'email' => $email,
    'phone' => $phone,
    'message' => $message,
    'timestamp' => date('Y-m-d H:i:s')
];

// Save to JSON file
$dataDir = '../data';
$dataFile = $dataDir . '/enquiries.json';

// Create data directory if it doesn't exist
if (!file_exists($dataDir)) {
    mkdir($dataDir, 0755, true);
}

// Read existing data
$existingData = [];
if (file_exists($dataFile)) {
    $jsonContent = file_get_contents($dataFile);
    $existingData = json_decode($jsonContent, true) ?? [];
}

// Add new enquiry
$existingData[] = $enquiry;

// Save to file
file_put_contents($dataFile, json_encode($existingData, JSON_PRETTY_PRINT));

// Set success message
$_SESSION['enquiry_success'] = true;

// Redirect back to enquiry page
header('Location: ../enquiry.php');
exit;
?>
