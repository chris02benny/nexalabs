<?php
session_start();
require_once '../includes/auth.php';
requireAdminLogin();

$pdo = require_once '../includes/db_connection.php';

// Handle search (same as admin_enquiries.php)
$search = $_GET['search'] ?? '';

// Build query
$where = [];
$params = [];

$query = "SELECT * FROM enquiries";

if (!empty($search)) {
    $where[] = "(name LIKE ? OR email LIKE ? OR phone LIKE ? OR message LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
    $params[] = "%$search%";
    $params[] = "%$search%";
}

$whereClause = !empty($where) ? "WHERE " . implode(" AND ", $where) : "";
$query .= " $whereClause ORDER BY created_at DESC";

try {
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    $enquiries = $stmt->fetchAll();
} catch (PDOException $e) {
    error_log("Export Enquiries Error: " . $e->getMessage());
    header('Location: ../admin_enquiries.php');
    exit;
}

// Set headers for Excel download
$filename = 'enquiries_' . date('Y-m-d_His') . '.csv';
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
    'Name',
    'Email',
    'Phone',
    'Message',
    'Submitted Date'
]);

// Add data rows
$slNo = 1;
foreach ($enquiries as $enquiry) {
    fputcsv($output, [
        $slNo++,
        $enquiry['name'],
        $enquiry['email'],
        $enquiry['phone'] ?? 'N/A',
        $enquiry['message'],
        date('M d, Y h:i A', strtotime($enquiry['created_at']))
    ]);
}

fclose($output);
exit;
?>

