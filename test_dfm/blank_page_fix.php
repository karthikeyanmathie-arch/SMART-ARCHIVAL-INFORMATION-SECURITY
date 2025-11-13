<?php
// Test page to diagnose blank page issue
ini_set('display_errors', 1);
error_reporting(E_ALL);

echo "<h1>🔧 Blank Page Diagnostic</h1>";
echo "<p>PHP is working: " . date('Y-m-d H:i:s') . "</p>";

// Test session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
    echo "<p>✅ Session started successfully</p>";
} else {
    echo "<p>✅ Session already active</p>";
}

// Test database connection
try {
    require_once 'config/database.php';
    echo "<p>✅ Database config loaded</p>";
    
    $database = new Database();
    $db = $database->getConnection();
    echo "<p>✅ Database connection successful</p>";
} catch (Exception $e) {
    echo "<p>❌ Database error: " . $e->getMessage() . "</p>";
}

// Test auth include
try {
    require_once 'includes/auth.php';
    echo "<p>✅ Auth system loaded</p>";
} catch (Exception $e) {
    echo "<p>❌ Auth error: " . $e->getMessage() . "</p>";
}

// Test if main index.php works
echo "<hr>";
echo "<h2>Index.php Test</h2>";
echo "<a href='index.php' style='background: #007bff; color: white; padding: 10px; text-decoration: none; border-radius: 4px;'>Test Main Dashboard</a>";
echo "<br><br>";
echo "<a href='quick_login.php' style='background: #28a745; color: white; padding: 10px; text-decoration: none; border-radius: 4px;'>Quick Login First</a>";
?>
