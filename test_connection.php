<?php
echo "<h2>Database Connection Test</h2>";

// Test basic MySQL connection
echo "<h3>Testing MySQL Connection...</h3>";
try {
    $pdo = new PDO('mysql:host=localhost', 'root', '');
    echo "✓ MySQL connection successful<br>";
    
    // Test if database exists
    echo "<h3>Checking if database exists...</h3>";
    $stmt = $pdo->query("SHOW DATABASES LIKE 'dept_file_management'");
    if ($stmt->rowCount() > 0) {
        echo "✓ Database 'dept_file_management' exists<br>";
        
        // Test connection to the specific database
        $pdo = new PDO('mysql:host=localhost;dbname=dept_file_management', 'root', '');
        echo "✓ Connection to dept_file_management successful<br>";
        
        // Test users table
        echo "<h3>Checking users table...</h3>";
        $stmt = $pdo->query("SHOW TABLES LIKE 'users'");
        if ($stmt->rowCount() > 0) {
            echo "✓ Users table exists<br>";
            $stmt = $pdo->query("SELECT COUNT(*) as count FROM users");
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            echo "✓ Users table has " . $result['count'] . " records<br>";
        } else {
            echo "✗ Users table does not exist<br>";
        }
    } else {
        echo "✗ Database 'dept_file_management' does not exist<br>";
    }
    
} catch (PDOException $e) {
    echo "✗ Database connection failed: " . $e->getMessage() . "<br>";
    echo "<p>Make sure XAMPP is running and MySQL service is started.</p>";
}

echo "<br><a href='index.php'>Back to Main Page</a>";
?>