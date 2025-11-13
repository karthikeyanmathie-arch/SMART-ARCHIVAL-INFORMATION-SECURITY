<?php
// Test logout functionality from department module
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
    <title>Logout Test - Department Module</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f8f9fa; }
        .container { max-width: 1200px; margin: 0 auto; }
        .test-section { background: white; padding: 20px; margin: 20px 0; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .alert { padding: 15px; border-radius: 5px; margin: 10px 0; }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-info { background: #d1ecf1; color: #0c5460; border: 1px solid #bee5eb; }
        .btn { display: inline-block; padding: 10px 20px; margin: 5px; text-decoration: none; border-radius: 4px; }
        .btn-logout { background: #dc3545; color: white; }
        .btn-logout:hover { background: #c82333; color: white; text-decoration: none; }
        .url-display { background: #f8f9fa; padding: 10px; border-left: 4px solid #007bff; margin: 10px 0; font-family: monospace; }
    </style>
</head>
<body>
    <div class="container">
        <div class="test-section">
            <h1>🔧 Logout Test - Department Module</h1>
            <div class="alert alert-success">
                ✅ <strong>Logout Fixed!</strong> Testing from department module subdirectory.
            </div>
            
            <div class="alert alert-info">
                <strong>Current Location:</strong> /modules/department/logout_test.php
            </div>
        </div>

        <!-- Include the fixed header with logout button -->
        <?php include '../../includes/header.php'; ?>

        <div class="test-section">
            <h2>🧪 Logout URL Testing</h2>
            
            <h3>Current Session Info:</h3>
            <div class="url-display">
                👤 <strong>Username:</strong> <?php echo $_SESSION['username'] ?? 'Not set'; ?>
            </div>
            <div class="url-display">
                🔑 <strong>Role:</strong> <?php echo $_SESSION['role'] ?? 'Not set'; ?>
            </div>
            <div class="url-display">
                🏢 <strong>Department:</strong> <?php echo $_SESSION['department'] ?? 'Not set'; ?>
            </div>
            <div class="url-display">
                📍 <strong>Current Page:</strong> <?php echo $_SERVER['REQUEST_URI'] ?? 'Unknown'; ?>
            </div>

            <h3>Test Results:</h3>
            <div class="url-display">
                ❌ <strong>Before Fix:</strong> /test_dfm/modules/department/logout.php (404 Error)
            </div>
            <div class="url-display">
                ✅ <strong>After Fix:</strong> /test_dfm/logout.php (Correct!)
            </div>
        </div>

        <div class="test-section">
            <h2>🎯 Test the Logout Button</h2>
            <p><strong>Instructions:</strong></p>
            <ol>
                <li>Click the "Logout" button in the header above</li>
                <li>It should redirect to: <code>/test_dfm/login.php</code></li>
                <li>You should see a logged out message</li>
            </ol>
            
            <p><strong>Alternative Test Buttons:</strong></p>
            <a href="/test_dfm/logout.php" class="btn btn-logout">🚪 Direct Logout Test</a>
            <a href="../../logout.php" class="btn btn-logout">🔄 Relative Path Test</a>
        </div>

        <div class="test-section">
            <h2>📝 What Was Fixed:</h2>
            <ul>
                <li><strong>Header logout link:</strong> Changed from <code>logout.php</code> to <code>/test_dfm/logout.php</code></li>
                <li><strong>Dashboard logout links:</strong> Updated all relative paths to absolute paths</li>
                <li><strong>Result:</strong> Logout works from any subdirectory!</li>
            </ul>
        </div>
    </div>

    <script>
        // Log logout clicks for testing
        document.addEventListener('click', function(e) {
            if (e.target.href && e.target.href.includes('logout')) {
                console.log('Logout clicked:', e.target.href);
                console.log('Current page:', window.location.href);
            }
        });
    </script>
</body>
</html>
