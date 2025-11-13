<?php
// Quick Auth Bypass for Testing Navigation
// This temporarily allows access to module pages without login

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// If no session exists, create a temporary one for testing
if (!isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = 999;
    $_SESSION['username'] = 'test_user';
    $_SESSION['role'] = 'admin';
    $_SESSION['department'] = 'Testing';
    
    echo "<div style='background: #fff3cd; color: #856404; padding: 10px; margin: 10px; border: 1px solid #ffeaa7; border-radius: 5px;'>";
    echo "<strong>⚠️ Testing Mode Active:</strong> Temporary session created for navigation testing. ";
    echo "<a href='/shrii/logout.php'>Logout</a> to return to normal mode.";
    echo "</div>";
}

// Include the original auth functionality
require_once __DIR__ . '/auth.php';
?>