<?php
session_start();
require_once '../includes/auth.php';
requireAdminLogin();

$pdo = require_once '../includes/db_connection.php';

// Handle search and filters (same as admin_feedback.php)
$search = $_GET['search'] ?? '';
$filterProgram = $_GET['filter_program'] ?? '';
$filterRating = $_GET['filter_rating'] ?? '';

// Build query
$where = [];
$params = [];

$query = "SELECT f.*, p.program_name 
          FROM feedback f 
          LEFT JOIN programs p ON f.program_id = p.id";

if (!empty($search)) {
    $where[] = "(f.student_name LIKE ? OR f.email LIKE ? OR f.comments LIKE ? OR p.program_name LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
    $params[] = "%$search%";
    $params[] = "%$search%";
}

if (!empty($filterProgram)) {
    $where[] = "f.program_id = ?";
    $params[] = $filterProgram;
}

if (!empty($filterRating)) {
    $where[] = "f.rating = ?";
    $params[] = $filterRating;
}

$whereClause = !empty($where) ? "WHERE " . implode(" AND ", $where) : "";
$query .= " $whereClause ORDER BY f.created_at DESC";

try {
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    $feedbacks = $stmt->fetchAll();
} catch (PDOException $e) {
    error_log("Export Feedback Error: " . $e->getMessage());
    header('Location: ../admin_feedback.php');
    exit;
}

// Set headers for Excel download
$filename = 'feedback_' . date('Y-m-d_His') . '.csv';
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Pragma: no-cache');
header('Expires: 0');

// Create output stream
$output = fopen('php://output', 'w');

// Add BOM for UTF-8 Excel compatibility
fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));

// Add headers
fputcsv($output, [
    'Sl No',
    'Student Name',
    'Email',
    'Program',
    'Rating',
    'Feedback',
    'Suggestions',
    'Submitted Date'
]);

// Add data rows
$slNo = 1;
foreach ($feedbacks as $feedback) {
    $programName = !empty($feedback['program_name']) ? $feedback['program_name'] : ($feedback['program'] ?? 'N/A');
    fputcsv($output, [
        $slNo++,
        $feedback['student_name'],
        $feedback['email'],
        $programName,
        $feedback['rating'] . ' Stars',
        $feedback['comments'] ?? 'No feedback',
        $feedback['suggestions'] ?? 'No suggestions',
        date('M d, Y h:i A', strtotime($feedback['created_at']))
    ]);
}

fclose($output);
exit;
?>

