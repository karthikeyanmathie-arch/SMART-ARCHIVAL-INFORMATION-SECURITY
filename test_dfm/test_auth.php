<?php
// Authentication System Test
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

echo "🔐 Authentication System Test\n\n";

try {
    require_once 'config/database.php';
    $database = new Database();
    $db = $database->getConnection();
    echo "✅ Database connection established\n";
    
    // Test user existence
    $stmt = $db->query("SELECT id, username, email, role, department FROM users");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "✅ Found " . count($users) . " users:\n";
    
    foreach ($users as $user) {
        echo "  - ID: {$user['id']}, Username: {$user['username']}, Role: {$user['role']}, Dept: {$user['department']}\n";
    }
    
    // Test password verification (using 'password' as test password)
    $stmt = $db->prepare("SELECT password FROM users WHERE username = ?");
    $stmt->execute(['admin']);
    $admin = $stmt->fetch();
    
    if ($admin) {
        $test_passwords = ['password', 'admin', '123456', 'admin123'];
        echo "\n🔑 Testing password verification for admin user:\n";
        
        foreach ($test_passwords as $test_pass) {
            if (password_verify($test_pass, $admin['password'])) {
                echo "✅ Password '$test_pass' - VALID\n";
            } else {
                echo "❌ Password '$test_pass' - INVALID\n";
            }
        }
    }
    
    // Test session functionality
    echo "\n🔒 Session Test:\n";
    if (isset($_SESSION['user_id'])) {
        echo "✅ User logged in: {$_SESSION['username']} ({$_SESSION['role']})\n";
    } else {
        echo "ℹ️  No user currently logged in\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
?>