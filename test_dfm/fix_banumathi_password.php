<?php
require_once 'config/database.php';

echo "Fixing Banumathi's password...\n";

$database = new Database();
$conn = $database->getConnection();

// Update Banumathi's password with proper hashing
$hashedPassword = password_hash('password', PASSWORD_DEFAULT);
$stmt = $conn->prepare('UPDATE users SET password = ? WHERE username = ?');
$result = $stmt->execute([$hashedPassword, 'Banumathi']);

if ($result) {
    echo "✅ Banumathi's password updated successfully\n";
    
    // Test the new password
    $testStmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
    $testStmt->execute(['Banumathi']);
    $user = $testStmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user && password_verify('password', $user['password'])) {
        echo "✅ Password verification now works\n";
    } else {
        echo "❌ Password verification still failed\n";
    }
} else {
    echo "❌ Failed to update password\n";
}
?>