<?php
// Get user credentials from database
try {
    $pdo = new PDO('mysql:host=localhost', 'root', '');
    $pdo->exec('USE dept_file_management');
    
    $stmt = $pdo->query('SELECT id, username, email, role, department FROM users');
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "🔐 LOGIN CREDENTIALS FOR YOUR SYSTEM\n";
    echo "=====================================\n\n";
    
    foreach ($users as $user) {
        echo "👤 User Account #" . $user['id'] . "\n";
        echo "   Username: " . $user['username'] . "\n";
        echo "   Email: " . $user['email'] . "\n";
        echo "   Role: " . strtoupper($user['role']) . "\n";
        echo "   Department: " . ($user['department'] ?? 'Not specified') . "\n";
        echo "   Password: password (for all users)\n";
        echo "\n";
    }
    
    echo "🌐 SYSTEM ACCESS URLs:\n";
    echo "=====================\n";
    echo "Main Login: http://localhost/test_dfm/login.php\n";
    echo "Dashboard: http://localhost/test_dfm/index.php\n";
    echo "Quick Login: http://localhost/test_dfm/quick_login.php\n\n";
    
    echo "💡 NOTES:\n";
    echo "========\n";
    echo "- All users currently use 'password' as their password\n";
    echo "- Admin user has full system access\n";
    echo "- Staff users have limited access based on role\n";
    echo "- You can change passwords through the user management system\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
?>