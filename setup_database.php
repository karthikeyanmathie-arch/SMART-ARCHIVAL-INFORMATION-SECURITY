<?php
// Database initialization script
ini_set('display_errors', 1);
error_reporting(E_ALL);

echo "<h2>Database Initialization</h2>";

try {
    // Connect to MySQL server
    $pdo = new PDO('mysql:host=localhost', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "✓ Connected to MySQL server<br>";
    
    // Create database if it doesn't exist
    $pdo->exec("CREATE DATABASE IF NOT EXISTS dept_file_management");
    echo "✓ Database 'dept_file_management' created/verified<br>";
    
    // Connect to the specific database
    $pdo = new PDO('mysql:host=localhost;dbname=dept_file_management', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "✓ Connected to dept_file_management database<br>";
    
    // Read and execute schema.sql
    $schemaFile = __DIR__ . '/database/schema.sql';
    if (file_exists($schemaFile)) {
        $sql = file_get_contents($schemaFile);
        
        // Split SQL file into individual queries (basic splitting)
        $queries = explode(';', $sql);
        $executed = 0;
        
        foreach ($queries as $query) {
            $query = trim($query);
            if (!empty($query) && !preg_match('/^--/', $query) && !preg_match('/^\/\*/', $query)) {
                try {
                    $pdo->exec($query);
                    $executed++;
                } catch (PDOException $e) {
                    // Skip errors for existing tables, etc.
                    if (!strpos($e->getMessage(), 'already exists')) {
                        echo "Warning: " . $e->getMessage() . "<br>";
                    }
                }
            }
        }
        echo "✓ Schema imported successfully ($executed queries executed)<br>";
        
        // Check if admin user exists, create if not
        $stmt = $pdo->query("SELECT COUNT(*) as count FROM users WHERE username = 'admin'");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($result['count'] == 0) {
            // Create default admin user
            $hashedPassword = password_hash('admin123', PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (username, password, email, role, department) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute(['admin', $hashedPassword, 'admin@shrii.edu', 'admin', 'Administration']);
            echo "✓ Default admin user created (username: admin, password: admin123)<br>";
        } else {
            echo "✓ Admin user already exists<br>";
        }
        
        echo "<br><div style='color: green; padding: 10px; border: 1px solid green;'>";
        echo "<strong>Database initialization completed successfully!</strong><br>";
        echo "You can now <a href='index.php'>access your application</a>";
        echo "</div>";
        
    } else {
        echo "✗ Schema file not found at: $schemaFile<br>";
    }
    
} catch (PDOException $e) {
    echo "<div style='color: red; padding: 10px; border: 1px solid red;'>";
    echo "<strong>Error:</strong> " . $e->getMessage() . "<br>";
    echo "Make sure XAMPP is running and MySQL service is started.";
    echo "</div>";
}
?>