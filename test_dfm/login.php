<?php
session_start();
require_once 'includes/auth.php';

$error = '';

// If already logged in, redirect to dashboard
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if ($_POST) {
    // Basic input sanitization
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    if ($username === '' || $password === '') {
        $error = 'Please enter both username and password.';
    } else {
        // Use Auth class to centralize login logic
        $auth = new Auth();
        try {
            if ($auth->login($username, $password)) {
                header("Location: index.php");
                exit();
            } else {
                // Generic error message to avoid leaking which part failed
                $error = 'Invalid username or password';
            }
        } catch (Exception $e) {
            // If DB or other error occurs, show a helpful message
            $error = 'Login error: ' . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Smart Archival & Information System</title>
    <link rel="icon" type="image/png" href="/test_dfm/assets/images/ssm_logo.png">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <h2 class="login-title">Smart Archival & Information System</h2>
            
            <?php if ($error): ?>
                <div class="alert alert-error"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" id="username" name="username" class="form-input" required>
                </div>
                
                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" id="password" name="password" class="form-input" required>
                </div>
                
                <button type="submit" class="btn btn-primary" style="width: 100%;">Login</button>
            </form>
            
            <div style="margin-top: 1rem; text-align: center; font-size: 0.9rem; color: #666;">
                Default Login: admin / password
            </div>
        </div>
    </div>
</body>
</html>