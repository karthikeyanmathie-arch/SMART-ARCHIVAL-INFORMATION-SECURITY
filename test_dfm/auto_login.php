<?php
session_start();
require_once 'config/database.php';

// Auto-login with default credentials for testing
$username = 'admin';
$password = 'password';

$database = new Database();
$db = $database->getConnection();

$query = "SELECT id, username, password, email, role, department FROM users WHERE username = :username";
$stmt = $db->prepare($query);
$stmt->bindParam(':username', $username);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if (password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['department'] = $user['department'];
        
        echo "✅ Auto-login successful! Redirecting to dashboard...";
        header("refresh:2;url=index.php");
        exit();
    }
}

echo "❌ Auto-login failed! Please use the regular login page.";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auto Login - Smart Archival & Information System</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <h2>🚀 Quick Login</h2>
            <p>Logging you in automatically...</p>
            <p><a href="login.php">Manual Login</a> | <a href="welcome.php">Welcome Page</a></p>
        </div>
    </div>
</body>
</html>
