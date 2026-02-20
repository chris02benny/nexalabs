<?php
require_once 'includes/db_connection.php';

header('Content-Type: application/json');

$programId = intval($_GET['id'] ?? 0);

if ($programId <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid program ID']);
    exit;
}

// Get PDO connection
$pdo = isset($GLOBALS['pdo']) ? $GLOBALS['pdo'] : require_once 'includes/db_connection.php';

try {
    $stmt = $pdo->prepare("SELECT * FROM programs WHERE id = ? AND isactive = 1 LIMIT 1");
    $stmt->execute([$programId]);
    $program = $stmt->fetch();
    
    if ($program) {
        // Format text fields
        $program['focus_areas_array'] = !empty($program['focus_areas']) ? explode("\n", trim($program['focus_areas'])) : [];
        $program['applications_array'] = !empty($program['applications']) ? explode("\n", trim($program['applications'])) : [];
        
        echo json_encode(['success' => true, 'program' => $program]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Program not found']);
    }
} catch (PDOException $e) {
    error_log("Get Program Details Error: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Database error']);
}
?>

