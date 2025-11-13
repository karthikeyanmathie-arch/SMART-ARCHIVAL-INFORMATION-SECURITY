<?php
require_once 'config/database.php';

echo "Checking Banumathi user profile...\n";

$database = new Database();
$conn = $database->getConnection();

// Get user details
$stmt = $conn->prepare('SELECT * FROM users WHERE username = ?');
$stmt->execute(['Banumathi']);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    echo "User found:\n";
    echo "ID: " . $user['id'] . "\n";
    echo "Username: " . $user['username'] . "\n";
    echo "Email: " . $user['email'] . "\n";
    echo "Role: " . $user['role'] . "\n";
    echo "Department: " . ($user['department'] ?? 'Not Set') . "\n";
    echo "Created: " . $user['created_at'] . "\n";
} else {
    echo "User 'Banumathi' not found\n";
}

// Test login for Banumathi
echo "\nTesting Banumathi login...\n";
require_once 'includes/auth.php';

$auth = new Auth();
if ($auth->login('Banumathi', 'password')) {
    echo "✅ Login successful\n";
    echo "Session data:\n";
    echo "- User ID: " . $_SESSION['user_id'] . "\n";
    echo "- Username: " . $_SESSION['username'] . "\n";
    echo "- Role: " . $_SESSION['role'] . "\n";
    echo "- Department: " . ($_SESSION['department'] ?? 'Not Set') . "\n";
} else {
    echo "❌ Login failed\n";
}
?>