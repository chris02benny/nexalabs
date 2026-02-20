<?php
/**
 * Programs Helper Functions
 * Functions to fetch and categorize programs from database
 */

function getActivePrograms($pdo) {
    try {
        $stmt = $pdo->query("SELECT * FROM programs WHERE isactive = 1 ORDER BY created_at DESC");
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        error_log("Get Programs Error: " . $e->getMessage());
        return [];
    }
}

function categorizePrograms($programs) {
    $today = date('Y-m-d');
    $categorized = [
        'upcoming' => [], // Registration hasn't started yet
        'registration_open' => [], // Registration is currently open
        'ongoing' => [], // Program is currently running
        'upcoming_program' => [] // Registration closed but program hasn't started
    ];
    
    foreach ($programs as $program) {
        $regStart = $program['reg_start_date'] ?? null;
        $regEnd = $program['reg_end_date'] ?? null;
        $progStart = $program['program_start_date'] ?? null;
        $progEnd = $program['program_end_date'] ?? null;
        
        // If no dates set, show in upcoming
        if (!$regStart && !$regEnd && !$progStart && !$progEnd) {
            $categorized['upcoming'][] = $program;
            continue;
        }
        
        // Registration hasn't started yet
        if ($regStart && $today < $regStart) {
            $categorized['upcoming'][] = $program;
        }
        // Registration is currently open
        elseif ($regStart && $regEnd && $today >= $regStart && $today <= $regEnd) {
            $categorized['registration_open'][] = $program;
        }
        // Program is currently running
        elseif ($progStart && $progEnd && $today >= $progStart && $today <= $progEnd) {
            $categorized['ongoing'][] = $program;
        }
        // Registration closed but program hasn't started
        elseif ($regEnd && $progStart && $today > $regEnd && $today < $progStart) {
            $categorized['upcoming_program'][] = $program;
        }
        // Default to upcoming if dates are set but don't match above
        else {
            $categorized['upcoming'][] = $program;
        }
    }
    
    return $categorized;
}

function formatProgramText($text) {
    if (empty($text)) return [];
    return explode("\n", trim($text));
}

function getProgramStatusBadge($program) {
    $today = date('Y-m-d');
    $regStart = $program['reg_start_date'] ?? null;
    $regEnd = $program['reg_end_date'] ?? null;
    $progStart = $program['program_start_date'] ?? null;
    $progEnd = $program['program_end_date'] ?? null;
    
    if ($regStart && $today < $regStart) {
        return '<span class="badge bg-info">Registration Starts: ' . date('M d, Y', strtotime($regStart)) . '</span>';
    } elseif ($regStart && $regEnd && $today >= $regStart && $today <= $regEnd) {
        return '<span class="badge bg-success">Registration Open - Ends: ' . date('M d, Y', strtotime($regEnd)) . '</span>';
    } elseif ($progStart && $progEnd && $today >= $progStart && $today <= $progEnd) {
        return '<span class="badge bg-primary">Ongoing - Ends: ' . date('M d, Y', strtotime($progEnd)) . '</span>';
    } elseif ($regEnd && $progStart && $today > $regEnd && $today < $progStart) {
        return '<span class="badge bg-warning">Program Starts: ' . date('M d, Y', strtotime($progStart)) . '</span>';
    }
    
    return '';
}

function calculateProgramDays($startDate, $endDate) {
    if (!$startDate || !$endDate) {
        return null;
    }
    
    $start = new DateTime($startDate);
    $end = new DateTime($endDate);
    $diff = $start->diff($end);
    
    // Add 1 to include both start and end dates
    return $diff->days + 1;
}
?>

