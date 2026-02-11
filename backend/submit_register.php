<?php
session_start();

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../register.php');
    exit;
}

// Sanitize and validate input
$studentName = htmlspecialchars(trim($_POST['studentName'] ?? ''));
$email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
$age = filter_var($_POST['age'] ?? '', FILTER_VALIDATE_INT);
$gender = htmlspecialchars(trim($_POST['gender'] ?? ''));
$educationLevel = htmlspecialchars(trim($_POST['educationLevel'] ?? ''));
$institution = htmlspecialchars(trim($_POST['institution'] ?? ''));
$program = htmlspecialchars(trim($_POST['program'] ?? ''));

// Validate required fields
if (empty($studentName) || empty($email) || !$age || empty($gender) || empty($educationLevel) || empty($institution) || empty($program)) {
    $_SESSION['error'] = 'Please fill in all required fields.';
    header('Location: ../register.php');
    exit;
}

// Validate email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error'] = 'Please enter a valid email address.';
    header('Location: ../register.php');
    exit;
}

// Validate age range
if ($age < 5 || $age > 25) {
    $_SESSION['error'] = 'Age must be between 5 and 25.';
    header('Location: ../register.php');
    exit;
}

// Prepare data
$registration = [
    'studentName' => $studentName,
    'email' => $email,
    'age' => $age,
    'gender' => $gender,
    'educationLevel' => $educationLevel,
    'institution' => $institution,
    'program' => $program,
    'timestamp' => date('Y-m-d H:i:s')
];

// Save to JSON file
$dataDir = '../data';
$dataFile = $dataDir . '/registrations.json';

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

// Add new registration
$existingData[] = $registration;

// Save to file
file_put_contents($dataFile, json_encode($existingData, JSON_PRETTY_PRINT));

// Set success message
$_SESSION['registration_success'] = true;

// Redirect back to registration page
header('Location: ../register.php');
exit;
?>
