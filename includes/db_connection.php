<?php
/**
 * Database Connection Configuration
 * MySQL Database Connection using PDO
 */

// Database configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'nexalabs_db');
define('DB_USER', 'root');
define('DB_PASS', 'admin');
define('DB_CHARSET', 'utf8mb4');

// Create DSN (Data Source Name)
$dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;

// PDO options
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    // Create PDO instance
    $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
} catch (PDOException $e) {
    // Log error and display user-friendly message
    error_log("Database Connection Error: " . $e->getMessage());
    die("Database connection failed. Please try again later.");
}

// Store in global variable for reuse
$GLOBALS['pdo'] = $pdo;

// Return the connection
return $pdo;
?>

