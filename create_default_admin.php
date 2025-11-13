<?php
require_once 'config/database.php';

try {
    $db = (new Database())->getConnection();
    $username = 'admin';
    $email = 'admin@college.edu';
    $password_plain = 'password';
    $role = 'admin';
    $department = 'Administration';

    // Check if admin exists
    $stmt = $db->prepare('SELECT id FROM users WHERE username = ?');
    $stmt->execute([$username]);
    if ($stmt->rowCount() > 0) {
        echo "Admin user already exists.\n";
        exit(0);
    }

    $hash = password_hash($password_plain, PASSWORD_DEFAULT);
    $insert = $db->prepare('INSERT INTO users (username, password, email, role, department) VALUES (?, ?, ?, ?, ?)');
    $insert->execute([$username, $hash, $email, $role, $department]);

    echo "Created admin user 'admin' with password 'password'. Please change it after login.\n";
} catch (Exception $e) {
    echo "Error creating admin: " . $e->getMessage() . "\n";
}
?>