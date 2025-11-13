<?php
// Simplified dashboard test
ini_set('display_errors', 1);
error_reporting(E_ALL);

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
$isLoggedIn = isset($_SESSION['user_id']);

// Auto-login for testing if not logged in
if (!$isLoggedIn) {
    try {
        require_once 'config/database.php';
        $db = new Database();
        $pdo = $db->getConnection();
        
        $stmt = $pdo->prepare("SELECT id, username, password, role FROM users WHERE username = ?");
        $stmt->execute(['admin']);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            $isLoggedIn = true;
        }
    } catch (Exception $e) {
        echo "<div style='color: red;'>Database Error: " . $e->getMessage() . "</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Dashboard - FIXED</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            margin: 20px; 
            background: #f8f9fa; 
        }
        .container { 
            max-width: 1200px; 
            margin: 0 auto; 
        }
        .header { 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
            color: white; 
            padding: 20px; 
            border-radius: 8px; 
            margin-bottom: 20px;
        }
        .dashboard-grid { 
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); 
            gap: 20px; 
            margin: 20px 0;
        }
        .dashboard-card { 
            background: white; 
            border: 1px solid #dee2e6; 
            border-radius: 8px; 
            padding: 20px; 
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .btn { 
            display: inline-block; 
            padding: 12px 24px; 
            background: #007bff; 
            color: white; 
            text-decoration: none; 
            border-radius: 4px; 
            margin: 10px 0;
        }
        .btn:hover { 
            background: #0056b3; 
            color: white;
            text-decoration: none;
        }
        .status { 
            padding: 15px; 
            border-radius: 5px; 
            margin: 10px 0; 
        }
        .status-success { 
            background: #d4edda; 
            color: #155724; 
            border: 1px solid #c3e6cb; 
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📊 Smart Archival & Information System</h1>
            <div class="page-subtitle">SSM COLLEGE OF ARTS AND SCIENCE DINDIGUL-624002</div>
            <p>Simple Dashboard - Blank Page Issue Fixed!</p>
        </div>

        <?php if ($isLoggedIn): ?>
            <div class="status status-success">
                ✅ <strong>Welcome back, <?php echo $_SESSION['username']; ?>!</strong> 
                (Role: <?php echo $_SESSION['role']; ?>)
            </div>
        <?php else: ?>
            <div style="background: #fff3cd; color: #856404; padding: 15px; border-radius: 5px;">
                ⚠️ <strong>Not logged in</strong> - Please login to access modules
            </div>
        <?php endif; ?>

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

        <div class="dashboard-card">
            <h3>🔧 Quick Actions</h3>
            <a href="index.php" class="btn">Original Dashboard</a>
            <a href="quick_login.php" class="btn">Quick Login</a>
            <a href="blank_page_fix.php" class="btn">Diagnostic Page</a>
            <a href="logout.php" class="btn" style="background: #dc3545;">Logout</a>
        </div>
    </div>
</body>
</html>
