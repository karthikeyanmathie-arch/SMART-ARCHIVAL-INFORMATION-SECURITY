<?php
// Debugging index.php step by step
ini_set('display_errors', 1);
error_reporting(E_ALL);

echo "Step 1: PHP Started<br>";

// Test session
try {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    echo "Step 2: Session OK<br>";
} catch (Exception $e) {
    echo "Step 2 FAILED: Session error - " . $e->getMessage() . "<br>";
}

// Test database config
try {
    require_once 'config/database.php';
    echo "Step 3: Database config loaded<br>";
} catch (Exception $e) {
    echo "Step 3 FAILED: Database config error - " . $e->getMessage() . "<br>";
}

// Test database connection
try {
    $database = new Database();
    $db = $database->getConnection();
    echo "Step 4: Database connection OK<br>";
} catch (Exception $e) {
    echo "Step 4 FAILED: Database connection error - " . $e->getMessage() . "<br>";
}

// Test auth include
try {
    require_once 'includes/auth.php';
    echo "Step 5: Auth included<br>";
} catch (Exception $e) {
    echo "Step 5 FAILED: Auth include error - " . $e->getMessage() . "<br>";
}

// Test checkAuth function
try {
    $auth = checkAuth();
    echo "Step 6: Auth check complete<br>";
} catch (Exception $e) {
    echo "Step 6 FAILED: Auth check error - " . $e->getMessage() . "<br>";
}

echo "<hr>";
echo "<h2>Debug Complete</h2>";
echo "<p>If you see this message, the PHP processing is working.</p>";
echo "<p>Session status: " . session_status() . "</p>";
echo "<p>Session ID: " . session_id() . "</p>";

if (isset($_SESSION['user_id'])) {
    echo "<p>User logged in: " . $_SESSION['username'] . "</p>";
} else {
    echo "<p>User not logged in</p>";
}
?>
