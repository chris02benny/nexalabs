<?php
session_start();
require_once '../includes/auth.php';
requireAdminLogin();

$pdo = require_once '../includes/db_connection.php';

// Handle search and filters (same as admin_registration.php)
$search = $_GET['search'] ?? '';
$filterGender = $_GET['filter_gender'] ?? '';
$filterEducation = $_GET['filter_education'] ?? '';
$filterProgram = $_GET['filter_program'] ?? '';

// Build query
$where = [];
$params = [];

$query = "SELECT r.*, p.program_name 
          FROM registrations r 
          LEFT JOIN programs p ON CAST(r.program AS UNSIGNED) = p.id";

if (!empty($search)) {
    $where[] = "(r.student_name LIKE ? OR r.email LIKE ? OR r.phone LIKE ? OR p.program_name LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
    $params[] = "%$search%";
    $params[] = "%$search%";
}

if (!empty($filterGender)) {
    $where[] = "r.gender = ?";
    $params[] = $filterGender;
}

if (!empty($filterEducation)) {
    $where[] = "r.education_level = ?";
    $params[] = $filterEducation;
}

if (!empty($filterProgram)) {
    $where[] = "r.program = ?";
    $params[] = $filterProgram;
}

$whereClause = !empty($where) ? "WHERE " . implode(" AND ", $where) : "";
$query .= " $whereClause ORDER BY r.created_at DESC";

try {
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    $registrations = $stmt->fetchAll();
} catch (PDOException $e) {
    error_log("Export Registrations Error: " . $e->getMessage());
    header('Location: ../admin_registration.php');
    exit;
}

// Set headers for Excel download
$filename = 'registrations_' . date('Y-m-d_His') . '.csv';
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
    'Phone',
    'Age',
    'Gender',
    'Education Level',
    'Institution',
    'Program',
    'Registered Date'
]);

// Add data rows
$slNo = 1;
foreach ($registrations as $registration) {
    fputcsv($output, [
        $slNo++,
        $registration['student_name'],
        $registration['email'],
        $registration['phone'] ?? 'N/A',
        $registration['age'] ?? 'N/A',
        ucfirst($registration['gender'] ?? 'N/A'),
        $registration['education_level'] ?? 'N/A',
        $registration['institution'] ?? 'N/A',
        $registration['program_name'] ?? ($registration['program'] ? 'Program ID: ' . $registration['program'] : 'N/A'),
        date('M d, Y h:i A', strtotime($registration['created_at']))
    ]);
}

fclose($output);
exit;
?>

