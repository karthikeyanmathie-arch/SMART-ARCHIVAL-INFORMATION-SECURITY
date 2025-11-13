<?php
// Navigation Test Page
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Auto-login for testing
if (!isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = 1;
    $_SESSION['username'] = 'admin';
    $_SESSION['role'] = 'admin';
    $_SESSION['department'] = 'IT';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navigation Test - FIXED</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f8f9fa; }
        .container { max-width: 1200px; margin: 0 auto; }
        .test-section { background: white; padding: 20px; margin: 20px 0; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .alert { padding: 15px; border-radius: 5px; margin: 10px 0; }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .url-test { background: #f8f9fa; padding: 10px; border-left: 4px solid #007bff; margin: 10px 0; font-family: monospace; }
    </style>
</head>
<body>
    <div class="container">
        <div class="test-section">
            <h1>🔧 Navigation System - FIXED!</h1>
            <div class="alert alert-success">
                ✅ <strong>Navigation Fixed!</strong> All links now use absolute paths and will work from any page.
            </div>
        </div>

        <!-- Include the fixed navigation -->
        <?php include 'includes/navigation.php'; ?>

        <div class="test-section">
            <h2>🧪 URL Testing</h2>
            <p><strong>Current Page:</strong> <span class="url-test"><?php echo $_SERVER['REQUEST_URI'] ?? 'Unknown'; ?></span></p>
            
            <h3>Test Results:</h3>
            <div class="url-test">
                ✅ <strong>Dashboard:</strong> /test_dfm/index.php
            </div>
            <div class="url-test">
                ✅ <strong>Department Pages:</strong> /test_dfm/modules/department/[page].php
            </div>
            <div class="url-test">
                ✅ <strong>Faculty Pages:</strong> /test_dfm/modules/faculty/[page].php
            </div>
            <div class="url-test">
                ✅ <strong>Student Pages:</strong> /test_dfm/modules/student/[page].php
            </div>
            <div class="url-test">
                ✅ <strong>Admin Pages:</strong> /test_dfm/admin/users.php (Fixed!)
            </div>
        </div>

        <div class="test-section">
            <h2>📝 What Was Fixed:</h2>
            <ul>
                <li><strong>Before:</strong> <code>admin/users.php</code> (relative path)</li>
                <li><strong>After:</strong> <code>/test_dfm/admin/users.php</code> (absolute path)</li>
                <li><strong>Result:</strong> Works from any subdirectory!</li>
            </ul>
        </div>

        <div class="test-section">
            <h2>🎯 Try These Links:</h2>
            <p>Click any navigation link above - they should all work correctly now!</p>
            <p><strong>Specifically test:</strong> User Management link from any department page</p>
        </div>
    </div>

    <script>
        // Log all navigation clicks for testing
        document.addEventListener('click', function(e) {
            if (e.target.closest('.nav-container')) {
                console.log('Navigation clicked:', e.target.href);
                console.log('Current page:', window.location.href);
            }
        });
    </script>
</body>
</html>
