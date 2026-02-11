<?php
session_start();

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../feedback.php');
    exit;
}

// Sanitize and validate input
$studentName = htmlspecialchars(trim($_POST['studentName'] ?? ''));
$program = htmlspecialchars(trim($_POST['program'] ?? ''));
$rating = filter_var($_POST['rating'] ?? '', FILTER_VALIDATE_INT);
$feedback = htmlspecialchars(trim($_POST['feedback'] ?? ''));
$suggestions = htmlspecialchars(trim($_POST['suggestions'] ?? ''));

// Validate required fields
if (empty($studentName) || empty($program) || !$rating || empty($feedback)) {
    $_SESSION['error'] = 'Please fill in all required fields.';
    header('Location: ../feedback.php');
    exit;
}

// Validate rating range
if ($rating < 1 || $rating > 5) {
    $_SESSION['error'] = 'Please select a valid rating.';
    header('Location: ../feedback.php');
    exit;
}

// Prepare data
$feedbackData = [
    'studentName' => $studentName,
    'program' => $program,
    'rating' => $rating,
    'feedback' => $feedback,
    'suggestions' => $suggestions,
    'timestamp' => date('Y-m-d H:i:s')
];

// Save to JSON file
$dataDir = '../data';
$dataFile = $dataDir . '/feedback.json';

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

// Add new feedback
$existingData[] = $feedbackData;

// Save to file
file_put_contents($dataFile, json_encode($existingData, JSON_PRETTY_PRINT));

// Set success message
$_SESSION['feedback_success'] = true;

// Redirect back to feedback page
header('Location: ../feedback.php');
exit;
?>
