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
        $auth = new Auth();
        try {
            if ($auth->login($username, $password)) {
                header("Location: index.php");
                exit();
            } else {
                $error = 'Invalid username or password';
            }
        } catch (Exception $e) {
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
    <link rel="icon" type="image/jpeg" href="assets/images/college_logo.jpg">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Center the entire login container */
        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .login-card {
            background: white;
            padding: 2.5rem;
            border-radius: 15px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        /* College logo smaller and centered */
        .login-logo {
            margin-bottom: 1.5rem;
        }

        .college-logo {
            width: 100px;
            height: 100px;
            object-fit: contain;
            display: block;
            margin: 0 auto 15px auto;
            border-radius: 10px;
        }

        .college-name-login {
            font-size: 1.1rem;
            font-weight: 700;
            text-align: center;
            color: #2c3e50;
            margin-bottom: 10px;
            line-height: 1.4;
        }

        .login-title {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            color: #34495e;
        }

        .form-group {
            margin-bottom: 1.2rem;
            text-align: left;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #2c3e50;
            font-size: 0.95rem;
        }

        .form-input {
            width: 100% !important;
            padding: 12px 15px !important;
            border: 2px solid #e0e0e0 !important;
            border-radius: 8px !important;
            font-size: 1rem !important;
            background: white !important;
            color: #2c3e50 !important;
            transition: all 0.3s ease !important;
            outline: none !important;
            box-sizing: border-box !important;
            pointer-events: auto !important;
            -webkit-user-select: text !important;
            user-select: text !important;
        }

        .form-input:focus {
            border-color: #667eea !important;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1) !important;
            background: white !important;
        }

        .form-input:hover {
            border-color: #b0b0b0 !important;
        }

        .btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1.05rem;
            font-weight: 600;
            width: 100%;
            transition: all 0.3s ease;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
        }

        .btn:active {
            transform: translateY(0);
        }

        .alert-error {
            background: #ffe5e5;
            color: #d32f2f;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 1rem;
            border-left: 4px solid #d32f2f;
            text-align: left;
        }

        .default-info {
            margin-top: 1.5rem;
            text-align: center;
            font-size: 0.9rem;
            color: #7f8c8d;
        }

        .default-info b {
            color: #2c3e50;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-logo">
                <img src="assets/images/college_logo.jpg" alt="SSM College Logo" class="college-logo">
                <h3 class="college-name-login">SSM COLLEGE OF ARTS AND SCIENCE<br>Dindigul - 624002</h3>
            </div>

            <h2 class="login-title">Smart Archival & Information System</h2>
            
            <?php if ($error): ?>
                <div class="alert-error"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" id="username" name="username" class="form-input" required autocomplete="username">
                </div>
                
                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" id="password" name="password" class="form-input" required autocomplete="current-password">
                </div>
                
                <button type="submit" class="btn">Login</button>
            </form>
            
            <div class="default-info">
                Default Login: <b>admin</b> / <b>password</b>
            </div>
        </div>
    </div>
</body>
</html>
