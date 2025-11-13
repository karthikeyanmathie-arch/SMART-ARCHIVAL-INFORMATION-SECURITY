<?php
require_once 'config/database.php';

$database = new Database();
$conn = $database->getConnection();

echo "Listing users and checking if the password 'password' verifies:\n\n";

try {
    $stmt = $conn->prepare('SELECT id, username, email, role, department, password, created_at FROM users ORDER BY id');
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!$users) {
        echo "No users found in the users table.\n";
        exit(0);
    }

    foreach ($users as $u) {
        $id = $u['id'];
        $username = $u['username'];
        $email = $u['email'];
        $role = $u['role'];
        $dept = $u['department'];
        $created = $u['created_at'];
        $hash = $u['password'];

        $password_check = password_verify('password', $hash) ? 'YES' : 'NO';

        echo "ID: $id\n";
        echo "Username: $username\n";
        echo "Email: $email\n";
        echo "Role: $role\n";
        echo "Department: " . ($dept ?: 'N/A') . "\n";
        echo "Created: $created\n";
        echo "'password' verifies: $password_check\n";
        echo str_repeat('-', 40) . "\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>