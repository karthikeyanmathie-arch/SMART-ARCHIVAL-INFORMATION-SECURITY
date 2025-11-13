<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

echo "<h1>System Diagnostic</h1>";
echo "<h2>PHP Status</h2>";
echo "PHP Version: " . phpversion() . "<br>";
echo "Current Time: " . date('Y-m-d H:i:s') . "<br>";

echo "<h2>File System Check</h2>";
$files_to_check = [
    'index.php',
    'login.php', 
    'includes/auth.php',
    'config/database.php',
    'assets/css/style.css'
];

foreach($files_to_check as $file) {
    if(file_exists($file)) {
        echo "✅ $file exists<br>";
    } else {
        echo "❌ $file NOT found<br>";
    }
}

echo "<h2>Database Connection Test</h2>";
try {
    require_once 'config/database.php';
    $database = new Database();
    $conn = $database->getConnection();
    if($conn) {
        echo "✅ Database connection successful<br>";
        
        $stmt = $conn->query("SELECT COUNT(*) as user_count FROM users");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        echo "✅ Users in database: " . $result['user_count'] . "<br>";
    } else {
        echo "❌ Database connection failed<br>";
    }
} catch(Exception $e) {
    echo "❌ Database error: " . $e->getMessage() . "<br>";
}

echo "<h2>Session Test</h2>";
session_start();
echo "Session ID: " . session_id() . "<br>";
echo "Session started: ✅<br>";

?>
<style>
body { font-family: Arial, sans-serif; margin: 20px; }
h1, h2 { color: #333; }
</style>
