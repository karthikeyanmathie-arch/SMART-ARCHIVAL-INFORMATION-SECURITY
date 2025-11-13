<!DOCTYPE html>
<html>
<head>
    <title>XAMPP MySQL Diagnostic Tool</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .success { color: green; background: #e8f5e8; padding: 10px; border: 1px solid green; margin: 10px 0; }
        .error { color: red; background: #ffe8e8; padding: 10px; border: 1px solid red; margin: 10px 0; }
        .warning { color: orange; background: #fff3e0; padding: 10px; border: 1px solid orange; margin: 10px 0; }
        .info { color: blue; background: #e8f4ff; padding: 10px; border: 1px solid blue; margin: 10px 0; }
        .step { margin: 15px 0; padding: 10px; border-left: 4px solid #ccc; }
        h2 { color: #333; }
        .button { display: inline-block; padding: 10px 15px; background: #007cba; color: white; text-decoration: none; border-radius: 5px; margin: 5px; }
    </style>
</head>
<body>
    <h1>🔧 XAMPP MySQL Diagnostic & Fix Tool</h1>

<?php
echo "<h2>Step 1: Checking PHP and Basic Setup</h2>";
echo "<div class='success'>✓ PHP is working (Version: " . phpversion() . ")</div>";

echo "<h2>Step 2: Testing MySQL Connection (Different Methods)</h2>";

// Test 1: Basic MySQL connection without password
echo "<h3>Test A: MySQL connection without password</h3>";
try {
    $pdo = new PDO('mysql:host=localhost', 'root', '');
    echo "<div class='success'>✓ MySQL connection successful (no password)</div>";
    $mysql_working = true;
} catch (PDOException $e) {
    echo "<div class='error'>✗ MySQL connection failed: " . $e->getMessage() . "</div>";
    $mysql_working = false;
}

// Test 2: MySQL connection with empty password explicitly
if (!$mysql_working) {
    echo "<h3>Test B: MySQL connection with empty password</h3>";
    try {
        $pdo = new PDO('mysql:host=localhost', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        echo "<div class='success'>✓ MySQL connection successful (empty password)</div>";
        $mysql_working = true;
    } catch (PDOException $e) {
        echo "<div class='error'>✗ MySQL connection failed: " . $e->getMessage() . "</div>";
    }
}

// Test 3: Try with common default passwords
if (!$mysql_working) {
    echo "<h3>Test C: Trying common default passwords</h3>";
    $passwords = ['', 'root', 'password', 'mysql'];
    foreach ($passwords as $pass) {
        try {
            $pdo = new PDO('mysql:host=localhost', 'root', $pass, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
            echo "<div class='success'>✓ MySQL connection successful with password: '" . ($pass ?: 'empty') . "'</div>";
            $mysql_working = true;
            $working_password = $pass;
            break;
        } catch (PDOException $e) {
            echo "<div class='warning'>- Password '" . ($pass ?: 'empty') . "' didn't work</div>";
        }
    }
}

if ($mysql_working) {
    echo "<h2>Step 3: MySQL is Working - Setting up Database</h2>";
    
    // Update database config if needed
    if (isset($working_password) && $working_password != '') {
        echo "<div class='info'>📝 Updating database configuration with working password...</div>";
        
        $config_file = __DIR__ . '/config/database.php';
        $config_content = file_get_contents($config_file);
        $new_config = str_replace("define('DB_PASS', '');", "define('DB_PASS', '$working_password');", $config_content);
        file_put_contents($config_file, $new_config);
        echo "<div class='success'>✓ Database configuration updated</div>";
    }
    
    // Create database
    try {
        $pdo->exec("CREATE DATABASE IF NOT EXISTS dept_file_management");
        echo "<div class='success'>✓ Database 'dept_file_management' created/verified</div>";
        
        // Connect to the specific database
        $db_password = isset($working_password) ? $working_password : '';
        $pdo = new PDO('mysql:host=localhost;dbname=dept_file_management', 'root', $db_password);
        
        // Import schema
        $schema_file = __DIR__ . '/database/schema.sql';
        if (file_exists($schema_file)) {
            $sql = file_get_contents($schema_file);
            $queries = explode(';', $sql);
            $executed = 0;
            
            foreach ($queries as $query) {
                $query = trim($query);
                if (!empty($query) && !preg_match('/^--/', $query) && !preg_match('/^\/\*/', $query)) {
                    try {
                        $pdo->exec($query);
                        $executed++;
                    } catch (PDOException $e) {
                        if (!strpos($e->getMessage(), 'already exists')) {
                            echo "<div class='warning'>Warning: " . $e->getMessage() . "</div>";
                        }
                    }
                }
            }
            echo "<div class='success'>✓ Schema imported ($executed queries executed)</div>";
            
            // Create admin user
            $stmt = $pdo->query("SELECT COUNT(*) as count FROM users WHERE username = 'admin'");
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($result['count'] == 0) {
                $hashedPassword = password_hash('admin123', PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("INSERT INTO users (username, password, email, role, department) VALUES (?, ?, ?, ?, ?)");
                $stmt->execute(['admin', $hashedPassword, 'admin@shrii.edu', 'admin', 'Administration']);
                echo "<div class='success'>✓ Admin user created (username: admin, password: admin123)</div>";
            } else {
                echo "<div class='info'>ℹ Admin user already exists</div>";
            }
            
            echo "<div class='success' style='font-size: 18px; text-align: center;'>";
            echo "<strong>🎉 SUCCESS! Your application is now ready!</strong><br><br>";
            echo "<a href='index.php' class='button'>🚀 Launch Your Application</a>";
            echo "</div>";
            
        } else {
            echo "<div class='error'>✗ Schema file not found at: $schema_file</div>";
        }
        
    } catch (PDOException $e) {
        echo "<div class='error'>Database setup error: " . $e->getMessage() . "</div>";
    }
    
} else {
    echo "<h2>🚨 MySQL Service Not Running</h2>";
    echo "<div class='error'>";
    echo "<strong>MySQL is not accessible. Follow these steps:</strong><br><br>";
    echo "<strong>1. Open XAMPP Control Panel</strong><br>";
    echo "   - Look for XAMPP icon in your system tray or desktop<br>";
    echo "   - If not found, search for 'XAMPP' in Start menu<br><br>";
    
    echo "<strong>2. Start MySQL Service</strong><br>";
    echo "   - In XAMPP Control Panel, find the 'MySQL' row<br>";
    echo "   - Click the 'Start' button next to MySQL<br>";
    echo "   - Wait for it to show 'Running' status<br><br>";
    
    echo "<strong>3. Check for Port Conflicts</strong><br>";
    echo "   - If MySQL won't start, click 'Config' next to MySQL<br>";
    echo "   - Change port from 3306 to 3307 if needed<br>";
    echo "   - Click 'Config' → 'my.ini' and change port=3306 to port=3307<br><br>";
    
    echo "<strong>4. Refresh this page</strong><br>";
    echo "   - Once MySQL is running, reload this page<br>";
    echo "   - The setup should complete automatically<br>";
    echo "</div>";
    
    echo "<div class='info'>";
    echo "<strong>Alternative: Using MySQL Command Line</strong><br>";
    echo "If XAMPP won't start MySQL, try:<br>";
    echo "1. Open Command Prompt as Administrator<br>";
    echo "2. Navigate to: C:\\xampp\\mysql\\bin\\<br>";
    echo "3. Run: mysql -u root -p<br>";
    echo "4. Press Enter when prompted for password<br>";
    echo "</div>";
}
?>

<div class="info">
    <h3>📋 Quick Action Buttons:</h3>
    <a href="<?php echo $_SERVER['PHP_SELF']; ?>" class="button">🔄 Refresh Diagnostic</a>
    <a href="test_connection.php" class="button">🔍 Simple Connection Test</a>
    <a href="index.php" class="button">🏠 Go to Main App</a>
</div>

</body>
</html>