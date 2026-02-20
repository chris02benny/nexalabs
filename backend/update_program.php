<?php
session_start();

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../admin_programmes.php');
    exit;
}

require_once '../includes/auth.php';
requireAdminLogin();

$pdo = require_once '../includes/db_connection.php';

// Get form data
$program_id = intval($_POST['program_id'] ?? 0);
$program_name = trim($_POST['program_name'] ?? '');
$focus_areas = trim($_POST['focus_areas'] ?? '');
$applications = trim($_POST['applications'] ?? '');
$outcome = trim($_POST['outcome'] ?? '');
$isactive = isset($_POST['isactive']) ? 1 : 0;
$reg_start_date = !empty($_POST['reg_start_date']) ? $_POST['reg_start_date'] : null;
$reg_end_date = !empty($_POST['reg_end_date']) ? $_POST['reg_end_date'] : null;
$program_start_date = !empty($_POST['program_start_date']) ? $_POST['program_start_date'] : null;
$program_end_date = !empty($_POST['program_end_date']) ? $_POST['program_end_date'] : null;

// Validate required fields
if (empty($program_id) || empty($program_name)) {
    $_SESSION['program_error'] = 'Program ID and name are required.';
    header('Location: ../admin_programmes.php');
    exit;
}

// Validate date ranges
if ($reg_start_date && $reg_end_date && $reg_start_date > $reg_end_date) {
    $_SESSION['program_error'] = 'Registration start date must be before end date.';
    header('Location: ../admin_programmes.php');
    exit;
}

if ($program_start_date && $program_end_date && $program_start_date > $program_end_date) {
    $_SESSION['program_error'] = 'Program start date must be before end date.';
    header('Location: ../admin_programmes.php');
    exit;
}

try {
    // Check if program exists
    $checkStmt = $pdo->prepare("SELECT id FROM programs WHERE id = ? LIMIT 1");
    $checkStmt->execute([$program_id]);
    if (!$checkStmt->fetch()) {
        $_SESSION['program_error'] = 'Program not found.';
        header('Location: ../admin_programmes.php');
        exit;
    }

    // Check if program name already exists (excluding current program)
    $nameCheckStmt = $pdo->prepare("SELECT id FROM programs WHERE program_name = ? AND id != ? LIMIT 1");
    $nameCheckStmt->execute([$program_name, $program_id]);
    if ($nameCheckStmt->fetch()) {
        $_SESSION['program_error'] = 'Program name already exists. Please choose a different name.';
        header('Location: ../admin_programmes.php');
        exit;
    }

    // Update program
    $updateStmt = $pdo->prepare("
        UPDATE programs SET
            program_name = ?,
            focus_areas = ?,
            applications = ?,
            outcome = ?,
            isactive = ?,
            reg_start_date = ?,
            reg_end_date = ?,
            program_start_date = ?,
            program_end_date = ?
        WHERE id = ?
    ");
    
    $updateStmt->execute([
        $program_name,
        $focus_areas ?: null,
        $applications ?: null,
        $outcome ?: null,
        $isactive,
        $reg_start_date,
        $reg_end_date,
        $program_start_date,
        $program_end_date,
        $program_id
    ]);

    // Success
    $_SESSION['update_success'] = true;
    header('Location: ../admin_programmes.php');
    exit;

} catch (PDOException $e) {
    error_log("Update Program Error: " . $e->getMessage());
    $_SESSION['program_error'] = 'An error occurred while updating the program. Please try again.';
    header('Location: ../admin_programmes.php');
    exit;
}
?>

