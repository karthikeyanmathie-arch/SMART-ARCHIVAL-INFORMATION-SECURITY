<?php
session_start();
require_once 'config/database.php';

// Auto-login with admin account for testing
try {
    $db = new Database();
    $pdo = $db->getConnection();
    
    $stmt = $pdo->prepare("SELECT id, username, password, role FROM users WHERE username = ?");
    $stmt->execute(['admin']);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        
        echo "✅ Successfully logged in as: " . $user['username'] . " (" . $user['role'] . ")";
        echo "<br><br><a href='test_faculty_student.php'>Go to Test Page</a>";
        echo "<br><a href='index.php'>Go to Main Dashboard</a>";
    } else {
        echo "❌ Admin user not found in database";
    }
} catch (Exception $e) {
    echo "❌ Database error: " . $e->getMessage();
}
?>
