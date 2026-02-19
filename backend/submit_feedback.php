<?php
session_start();
require_once '../includes/db_connection.php';

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../feedback.php');
    exit;
}

$pdo = isset($GLOBALS['pdo']) ? $GLOBALS['pdo'] : require_once '../includes/db_connection.php';

// Sanitize and validate input
$studentName = htmlspecialchars(trim($_POST['studentName'] ?? ''));
$studentEmail = filter_var(trim($_POST['studentEmail'] ?? ''), FILTER_SANITIZE_EMAIL);
$programId = isset($_POST['program_id']) ? intval($_POST['program_id']) : 0;
$rating = filter_var($_POST['rating'] ?? '', FILTER_VALIDATE_INT);
$feedback = htmlspecialchars(trim($_POST['feedback'] ?? ''));
$suggestions = htmlspecialchars(trim($_POST['suggestions'] ?? ''));

// Validate required fields
if (empty($studentName) || empty($studentEmail) || $programId <= 0 || !$rating || empty($feedback)) {
    $_SESSION['error'] = 'Please fill in all required fields.';
    $redirectUrl = $programId > 0 ? '../feedback.php?id=' . $programId : '../feedback.php';
    header('Location: ' . $redirectUrl);
    exit;
}

// Validate email format
if (!filter_var($studentEmail, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error'] = 'Please enter a valid email address.';
    $redirectUrl = $programId > 0 ? '../feedback.php?id=' . $programId : '../feedback.php';
    header('Location: ' . $redirectUrl);
    exit;
}

// Get program name
try {
    $progStmt = $pdo->prepare("SELECT program_name FROM programs WHERE id = ? LIMIT 1");
    $progStmt->execute([$programId]);
    $program = $progStmt->fetch();
    
    if (!$program) {
        $_SESSION['error'] = 'Invalid program selected.';
        header('Location: ../feedback.php');
        exit;
    }
    
    $programName = $program['program_name'];
} catch (PDOException $e) {
    error_log("Submit Feedback Error: " . $e->getMessage());
    $_SESSION['error'] = 'An error occurred. Please try again.';
    $redirectUrl = $programId > 0 ? '../feedback.php?id=' . $programId : '../feedback.php';
    header('Location: ' . $redirectUrl);
    exit;
}

// Validate rating range
if ($rating < 1 || $rating > 5) {
    $_SESSION['error'] = 'Please select a valid rating.';
    header('Location: ../feedback.php');
    exit;
}

// Sanitize feedback and suggestions separately
$feedbackText = trim($feedback);
$suggestionsText = trim($suggestions);

// Check if feedback already exists for this email and program
try {
    $checkStmt = $pdo->prepare("SELECT id FROM feedback WHERE email = ? AND program_id = ? LIMIT 1");
    $checkStmt->execute([$studentEmail, $programId]);
    if ($checkStmt->fetch()) {
        $_SESSION['error'] = 'You have already submitted feedback for this program.';
        header('Location: ../feedback.php?id=' . $programId);
        exit;
    }
} catch (PDOException $e) {
    error_log("Check Feedback Error: " . $e->getMessage());
}

// Insert into database table (feedback table)
// Insert feedback and suggestions as separate fields
try {
    $insertStmt = $pdo->prepare("INSERT INTO feedback (student_name, email, program, program_id, rating, comments, suggestions, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");
    $insertStmt->execute([$studentName, $studentEmail, $programName, $programId, $rating, $feedbackText, $suggestionsText]);
    
    // Set success message
    $_SESSION['feedback_success'] = true;
    
    // Redirect back to feedback page with program ID
    header('Location: ../feedback.php?id=' . $programId);
    exit;
} catch (PDOException $e) {
    error_log("Insert Feedback Error: " . $e->getMessage());
    $_SESSION['error'] = 'An error occurred while submitting feedback. Please try again.';
    header('Location: ../feedback.php?id=' . $programId);
    exit;
}
?>
