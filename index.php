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
    <link rel="icon" type="image/jpeg" href="/test_dfm/assets/images/college_logo.jpg">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <!-- Header -->
    <?php include 'includes/header.php'; ?>

    <!-- Navigation -->
    <?php include 'includes/navigation.php'; ?>

    <div class="main-container">
        <!-- Status -->
        <?php if ($isLoggedIn): ?>
            <div class="alert alert-success">
                ✅ <strong>Dashboard Active</strong> - Welcome back, <?php echo $_SESSION['username']; ?>!
            </div>
        <?php else: ?>
            <div class="alert alert-info">
                ⚠️ <strong>Not logged in</strong> - <a href="login.php">Please login</a> or <a href="quick_login.php">Quick Login</a>
            </div>
        <?php endif; ?>

        <h1 class="page-title">Dashboard</h1>
        <p class="page-subtitle">Manage your academic and administrative tasks efficiently</p>

        <div class="dashboard-grid">
            <!-- Department -->
            <div class="dashboard-card">
                <h3>🏢 Department</h3>
                <p>Manage academic calendar, timetables, admissions, and research publications</p>
                <a href="modules/department/index.php" class="btn btn-primary">Access Department</a>
            </div>

            <!-- Faculty -->
            <div class="dashboard-card">
                <h3>👨‍🏫 Faculty</h3>
                <p>Handle syllabus, results, assessments, and faculty appraisals</p>
                <a href="modules/faculty/index.php" class="btn btn-primary">Access Faculty</a>
            </div>

            <!-- Student -->
            <div class="dashboard-card">
                <h3>🎓 Student</h3>
                <p>Manage alumni, value-added courses, and student activities</p>
                <a href="modules/student/index.php" class="btn btn-primary">Access Student</a>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="content-card">
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
        <div class="content-card">
            <h3>🔧 Quick Actions</h3>
            <a href="login.php" class="btn btn-secondary">Login</a>
            <a href="quick_login.php" class="btn btn-secondary">Quick Login</a>
            <a href="/test_dfm/logout.php" class="btn btn-danger">Logout</a>
            <a href="debug_index.php" class="btn btn-secondary">Debug Page</a>
            <a href="/test_dfm/setup/import_schema.php" class="btn btn-success">Import Schema</a>
            <a href="/test_dfm/setup/diagnose.php" class="btn btn-secondary">Diagnostics</a>
        </div>
    </div>

    <!-- Load main script for theme toggle and other features -->
    <script src="assets/js/script.js"></script>
    <script>
        // Simple click feedback for buttons
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('btn')) {
                e.target.style.transform = 'scale(0.98)';
                setTimeout(() => {
                    e.target.style.transform = '';
                }, 150);
            }
        });
    </script>
</body>
</html>
