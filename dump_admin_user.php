<?php
require_once 'config/database.php';

echo "Dumping admin user row...\n";
try {
    $db = (new Database())->getConnection();
    $stmt = $db->prepare("SELECT id, username, password, email, role, department, created_at FROM users WHERE username = ?");
    $stmt->execute(['admin']);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user) {
        echo "Found admin:\n";
        foreach ($user as $k => $v) {
            echo "- $k: $v\n";
        }
    } else {
        echo "No admin user found\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>