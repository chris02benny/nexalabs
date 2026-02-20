<?php
session_start();

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../register.php');
    exit;
}

// Get database connection
require_once '../includes/db_connection.php';
$pdo = isset($GLOBALS['pdo']) ? $GLOBALS['pdo'] : require_once '../includes/db_connection.php';

// Sanitize and validate input
$studentName = htmlspecialchars(trim($_POST['studentName'] ?? ''));
$email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
$age = filter_var($_POST['age'] ?? '', FILTER_VALIDATE_INT);
$gender = htmlspecialchars(trim($_POST['gender'] ?? ''));
$phone = htmlspecialchars(trim($_POST['phone'] ?? ''));
$educationLevel = htmlspecialchars(trim($_POST['educationLevel'] ?? ''));
$institution = htmlspecialchars(trim($_POST['institution'] ?? ''));
$programId = isset($_POST['program_id']) ? intval($_POST['program_id']) : 0;
$program = htmlspecialchars(trim($_POST['program'] ?? '')); // Fallback for old form

// Validate required fields
if (empty($studentName) || empty($email) || !$age || empty($gender) || empty($educationLevel) || empty($institution)) {
    $_SESSION['error'] = 'Please fill in all required fields.';
    $redirectUrl = $programId > 0 ? '../register.php?id=' . $programId : '../register.php';
    header('Location: ' . $redirectUrl);
    exit;
}

// Validate program selection - program ID is now required
if ($programId <= 0) {
    $_SESSION['error'] = 'Invalid program. Please select a program from the programs page.';
    header('Location: ../programs.php');
    exit;
}

// Validate email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error'] = 'Please enter a valid email address.';
    $redirectUrl = $programId > 0 ? '../register.php?id=' . $programId : '../register.php';
    header('Location: ' . $redirectUrl);
    exit;
}

// Validate age range
if ($age < 5 || $age > 25) {
    $_SESSION['error'] = 'Age must be between 5 and 25.';
    $redirectUrl = $programId > 0 ? '../register.php?id=' . $programId : '../register.php';
    header('Location: ' . $redirectUrl);
    exit;
}

try {
    // Verify program exists (program ID is required)
    $checkProgramStmt = $pdo->prepare("SELECT id FROM programs WHERE id = ? AND isactive = 1 LIMIT 1");
    $checkProgramStmt->execute([$programId]);
    if (!$checkProgramStmt->fetch()) {
        $_SESSION['error'] = 'Invalid program selected.';
        header('Location: ../programs.php');
        exit;
    }
    
    // Insert program ID as string into program field
    $programValue = (string)$programId;
    
    // Check if already registered for this program with this email
    $checkDuplicateStmt = $pdo->prepare("SELECT id FROM registrations WHERE email = ? AND program = ? LIMIT 1");
    $checkDuplicateStmt->execute([$email, $programValue]);
    if ($checkDuplicateStmt->fetch()) {
        $_SESSION['error'] = 'This program is already registered with this email address.';
        $redirectUrl = '../register.php?id=' . $programId;
        header('Location: ' . $redirectUrl);
        exit;
    }
    
    // Check if already registered for this program with this phone (if phone is provided)
    if (!empty($phone)) {
        $checkPhoneDuplicateStmt = $pdo->prepare("SELECT id FROM registrations WHERE phone = ? AND program = ? LIMIT 1");
        $checkPhoneDuplicateStmt->execute([$phone, $programValue]);
        if ($checkPhoneDuplicateStmt->fetch()) {
            $_SESSION['error'] = 'This program is already registered with this phone number.';
            $redirectUrl = '../register.php?id=' . $programId;
            header('Location: ' . $redirectUrl);
            exit;
        }
    }
    
    // Insert into registrations table - program field stores the ID as string
    // Schema: id, student_name, email, phone, age, gender, education_level, institution, program, created_at
    $insertStmt = $pdo->prepare("INSERT INTO registrations (student_name, email, phone, age, gender, education_level, institution, program, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())");
    $insertStmt->execute([$studentName, $email, $phone, $age, $gender, $educationLevel, $institution, $programValue]);
    
    // Set success message
    $_SESSION['registration_success'] = true;
    
    // Redirect back to registration page
    $redirectUrl = $programId > 0 ? '../register.php?id=' . $programId : '../register.php';
    header('Location: ' . $redirectUrl);
    exit;
    
} catch (PDOException $e) {
    error_log("Registration Error: " . $e->getMessage());
    $_SESSION['error'] = 'An error occurred during registration. Please try again later.';
    $redirectUrl = $programId > 0 ? '../register.php?id=' . $programId : '../register.php';
    header('Location: ' . $redirectUrl);
    exit;
}
?>
