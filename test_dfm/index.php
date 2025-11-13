<?php
// Working Dashboard - Fixed Version
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Start session safely
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Auto-login for testing if not logged in
if (!isset($_SESSION['user_id'])) {
    try {
        require_once 'config/database.php';
        $db = new Database();
        $pdo = $db->getConnection();
        
        $stmt = $pdo->prepare("SELECT id, username, password, role, department FROM users WHERE username = ?");
        $stmt->execute(['admin']);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['department'] = $user['department'] ?? 'General';
        }
    } catch (Exception $e) {
        // Database connection failed, show error and setup link
        echo "<div style='color: red; margin: 20px; padding: 20px; border: 2px solid red; background: #ffe6e6;'>";
        echo "<h2>🚫 Application Setup Required</h2>";
        echo "<p><strong>Database connection failed:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
        echo "<p><strong>Quick fix:</strong></p>";
        echo "<ol>";
        echo "<li>Make sure XAMPP is running</li>";
        echo "<li>Start MySQL service in XAMPP Control Panel</li>";
        echo "<li><a href='setup_database.php' style='color: blue; font-weight: bold;'>Click here to setup the database</a></li>";
        echo "</ol>";
        echo "<p><a href='test_connection.php'>Test database connection</a></p>";
        echo "</div>";
        exit();
    }
}

$isLoggedIn = isset($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Archival & Information System</title>
    <link rel="icon" type="image/png" href="/test_dfm/assets/images/ssm_logo.png">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        /* Inline styles for immediate fix */
        body { font-family: Arial, sans-serif; margin: 0; background: #f5f5f5; }
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 20px; border-radius: 8px; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 1.8rem; }
        .user-info { float: right; margin-top: -30px; }
        .user-info a { color: white; text-decoration: none; background: rgba(255,255,255,0.2); padding: 5px 10px; border-radius: 4px; }
        .dashboard-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; margin: 20px 0; }
        .dashboard-card { background: white; border: 1px solid #ddd; border-radius: 8px; padding: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .btn { display: inline-block; padding: 12px 24px; background: #007bff; color: white; text-decoration: none; border-radius: 4px; margin: 10px 0; }
        .btn:hover { background: #0056b3; color: white; text-decoration: none; }
        .status { padding: 15px; border-radius: 5px; margin: 10px 0; }
        .status-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .status-warning { background: #fff3cd; color: #856404; border: 1px solid #ffeaa7; }
        .page-subtitle{ color:  white; text-align: left; font-family:Arial, sans-serif ;}
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>Smart Archival & Information System</h1>
            <div class="page-subtitle">SSM COLLEGE OF ARTS AND SCIENCE DINDIGUL-624002</div>
            <div class="user-info">
                <?php if ($isLoggedIn): ?>
                    Welcome, <?php echo $_SESSION['username']; ?> (<?php echo $_SESSION['role']; ?>) |
                    <a href="/test_dfm/logout.php">Logout</a>
                <?php else: ?>
                    <a href="login.php">Login</a>
                <?php endif; ?>
            </div>
            <div style="clear: both;"></div>
        </div>

        <!-- Status -->
        <?php if ($isLoggedIn): ?>
            <div class="status status-success">
                ✅ <strong>Dashboard Active</strong> - Welcome back, <?php echo $_SESSION['username']; ?>!
            </div>
        <?php else: ?>
            <div class="status status-warning">
                ⚠️ <strong>Not logged in</strong> - <a href="login.php">Please login</a> or <a href="quick_login.php">Quick Login</a>
            </div>
        <?php endif; ?>

        <h1 class="page-title">Dashboard</h1>
        
        <div class="dashboard-grid">
            <!-- Department -->
            <div class="dashboard-card">
                <h3>🏢 Department</h3>
                <p>Manage academic calendar, timetables, admissions, and research publications</p>
                <a href="modules/department/index.php" class="btn">Access Department</a>
            </div>

            <!-- Faculty -->
            <div class="dashboard-card">
                <h3>👨‍🏫 Faculty</h3>
                <p>Handle syllabus, results, assessments, and faculty appraisals</p>
                <a href="modules/faculty/index.php" class="btn">Access Faculty</a>
            </div>

            <!-- Student -->
            <div class="dashboard-card">
                <h3>🎓 Student</h3>
                <p>Manage alumni, value-added courses, and student activities</p>
                <a href="modules/student/index.php" class="btn">Access Student</a>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="dashboard-card">
            <h2>Quick Statistics</h2>
            <div class="dashboard-grid">
                <?php
                if ($isLoggedIn) {
                    try {
                        require_once 'config/database.php';
                        $database = new Database();
                        $db = $database->getConnection();

                        // Simplified stats - only show existing tables
                        $tables = ['users'];
                        foreach ($tables as $table) {
                            try {
                                $query = "SELECT COUNT(*) as count FROM $table";
                                $stmt = $db->prepare($query);
                                $stmt->execute();
                                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                                echo "<div class='dashboard-card'>";
                                echo "<h3>{$result['count']}</h3>";
                                echo "<p>" . ucfirst($table) . "</p>";
                                echo "</div>";
                            } catch (Exception $e) {
                                // Skip if table doesn't exist
                            }
                        }
                    } catch (Exception $e) {
                        echo "<p>Statistics unavailable</p>";
                    }
                } else {
                    echo "<p>Please login to view statistics</p>";
                }
                ?>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="dashboard-card">
            <h3>🔧 Quick Actions</h3>
            <a href="login.php" class="btn">Login</a>
            <a href="quick_login.php" class="btn">Quick Login</a>
            <a href="/test_dfm/logout.php" class="btn" style="background: #dc3545;">Logout</a>
               <a href="debug_index.php" class="btn">Debug Page</a>
               <a href="/test_dfm/setup/import_schema.php" class="btn" style="background:#28a745; color:white; margin-left:8px;">Import Schema</a>
               <a href="/test_dfm/setup/diagnose.php" class="btn" style="margin-left:8px;">Diagnostics</a>
        </div>
    </div>

    <script>
        // Simple click feedback
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('btn')) {
                e.target.style.opacity = '0.7';
                setTimeout(() => { e.target.style.opacity = '1'; }, 200);
            }
        });
    </script>
</body>
</html>
