<?php
// Database test script
try {
    $pdo = new PDO('mysql:host=localhost', 'root', '');
    echo "✅ Database connection: SUCCESS\n";
    
    $pdo->exec('USE dept_file_management');
    echo "✅ Database exists: SUCCESS\n";
    
    $stmt = $pdo->query('SHOW TABLES');
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    echo "✅ Tables found: " . count($tables) . "\n";
    
    foreach ($tables as $table) {
        echo "  - $table\n";
    }
    
    // Test users table specifically
    $stmt = $pdo->query('SELECT COUNT(*) as count FROM users');
    $result = $stmt->fetch();
    echo "✅ Users in database: " . $result['count'] . "\n";
    
} catch (Exception $e) {
    echo "❌ Database error: " . $e->getMessage() . "\n";
}
?>
