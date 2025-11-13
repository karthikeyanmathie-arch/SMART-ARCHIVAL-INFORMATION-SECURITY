<?php
/**
 * Installation Script for Smart Archival & Information System
 * This script helps set up the database and initial configuration
 */

// Check if already installed
if (file_exists('../config/installed.lock')) {
    die('System is already installed. Delete config/installed.lock to reinstall.');
}

$error = '';
$success = '';
$step = isset($_GET['step']) ? (int)$_GET['step'] : 1;

if ($_POST) {
    if ($step == 1) {
        // Database connection test
        try {
            $host = $_POST['db_host'];
            $user = $_POST['db_user'];
            $pass = $_POST['db_pass'];
            $name = $_POST['db_name'];
            
            $dsn = "mysql:host=$host";
            $pdo = new PDO($dsn, $user, $pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Create database if it doesn't exist
            $pdo->exec("CREATE DATABASE IF NOT EXISTS `$name`");
            $pdo->exec("USE `$name`");
            
            // Store database config
            $config = "<?php\n";
            $config .= "define('DB_HOST', '$host');\n";
            $config .= "define('DB_USER', '$user');\n";
            $config .= "define('DB_PASS', '$pass');\n";
            $config .= "define('DB_NAME', '$name');\n\n";
            $config .= file_get_contents('../config/database.php');
            $config = str_replace("<?php\n// Database configuration\ndefine('DB_HOST', 'localhost');\ndefine('DB_USER', 'root');\ndefine('DB_PASS', '');\ndefine('DB_NAME', 'dept_file_management');", '', $config);
            
            file_put_contents('../config/database.php', $config);
            
            $success = 'Database connection successful! Proceeding to next step...';
            header("refresh:2;url=install.php?step=2");
            
        } catch (Exception $e) {
            $error = 'Database connection failed: ' . $e->getMessage();
        }
    } elseif ($step == 2) {
        // Import database schema
        try {
            require_once '../config/database.php';
            $database = new Database();
            $db = $database->getConnection();
            
            $sql = file_get_contents('../database/schema.sql');
            $statements = explode(';', $sql);
            
            foreach ($statements as $statement) {
                $statement = trim($statement);
                if (!empty($statement)) {
                    $db->exec($statement);
                }
            }
            
            $success = 'Database tables created successfully! Proceeding to admin setup...';
            header("refresh:2;url=install.php?step=3");
            
        } catch (Exception $e) {
            $error = 'Database import failed: ' . $e->getMessage();
        }
    } elseif ($step == 3) {
        // Create admin user
        try {
            require_once '../config/database.php';
            $database = new Database();
            $db = $database->getConnection();
            
            $username = $_POST['admin_username'];
            $password = password_hash($_POST['admin_password'], PASSWORD_DEFAULT);
            $email = $_POST['admin_email'];
            
            // Delete default admin and create new one
            $db->exec("DELETE FROM users WHERE username = 'admin'");
            
            $query = "INSERT INTO users (username, password, email, role, department) VALUES (?, ?, ?, 'admin', 'Administration')";
            $stmt = $db->prepare($query);
            $stmt->execute([$username, $password, $email]);
            
            // Create installation lock file
            file_put_contents('../config/installed.lock', date('Y-m-d H:i:s'));
            
            $success = 'Installation completed successfully! You can now login to your system.';
            header("refresh:3;url=../login.php");
            
        } catch (Exception $e) {
            $error = 'Admin user creation failed: ' . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Install - Smart Archival & Information System</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="login-container">
        <div class="login-card" style="max-width: 600px;">
            <h2 class="login-title">System Installation</h2>
            <p style="text-align: center; margin-bottom: 2rem; color: #666;">
                Step <?php echo $step; ?> of 3
            </p>
            
            <?php if ($error): ?>
                <div class="alert alert-error"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>
            
            <?php if ($step == 1): ?>
                <h3>Database Configuration</h3>
                <form method="POST">
                    <div class="form-group">
                        <label for="db_host" class="form-label">Database Host</label>
                        <input type="text" id="db_host" name="db_host" class="form-input" value="localhost" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="db_user" class="form-label">Database Username</label>
                        <input type="text" id="db_user" name="db_user" class="form-input" value="root" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="db_pass" class="form-label">Database Password</label>
                        <input type="password" id="db_pass" name="db_pass" class="form-input">
                    </div>
                    
                    <div class="form-group">
                        <label for="db_name" class="form-label">Database Name</label>
                        <input type="text" id="db_name" name="db_name" class="form-input" value="dept_file_management" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary" style="width: 100%;">Test Connection & Continue</button>
                </form>
            
            <?php elseif ($step == 2): ?>
                <h3>Database Setup</h3>
                <p>Click the button below to create database tables and import initial data.</p>
                <form method="POST">
                    <button type="submit" class="btn btn-primary" style="width: 100%;">Create Database Tables</button>
                </form>
            
            <?php elseif ($step == 3): ?>
                <h3>Admin Account Setup</h3>
                <form method="POST">
                    <div class="form-group">
                        <label for="admin_username" class="form-label">Admin Username</label>
                        <input type="text" id="admin_username" name="admin_username" class="form-input" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="admin_password" class="form-label">Admin Password</label>
                        <input type="password" id="admin_password" name="admin_password" class="form-input" required minlength="6">
                    </div>
                    
                    <div class="form-group">
                        <label for="admin_email" class="form-label">Admin Email</label>
                        <input type="email" id="admin_email" name="admin_email" class="form-input" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary" style="width: 100%;">Complete Installation</button>
                </form>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>