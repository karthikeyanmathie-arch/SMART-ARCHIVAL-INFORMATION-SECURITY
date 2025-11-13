<?php
require_once 'includes/auth.php';

echo "Testing admin login via Auth->login()...\n";
try {
    $auth = new Auth();
    if ($auth->login('admin', 'password')) {
        echo "✅ Admin login successful\n";
        echo "Session: user_id=" . ($_SESSION['user_id'] ?? 'n/a') . ", username=" . ($_SESSION['username'] ?? 'n/a') . ", role=" . ($_SESSION['role'] ?? 'n/a') . "\n";
    } else {
        echo "❌ Admin login failed (invalid username/password)\n";
    }
} catch (Exception $e) {
    echo "❌ Exception during login: " . $e->getMessage() . "\n";
}
?>