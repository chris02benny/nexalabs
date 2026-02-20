<?php
/**
 * Authentication Helper
 * Check if admin is logged in
 */

if (!isset($_SESSION)) {
    session_start();
}

function isAdminLoggedIn() {
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}

function requireAdminLogin() {
    if (!isAdminLoggedIn()) {
        header('Location: login.php');
        exit;
    }
}

function getAdminId() {
    return $_SESSION['admin_id'] ?? null;
}

function getAdminUsername() {
    return $_SESSION['admin_username'] ?? null;
}
?>

