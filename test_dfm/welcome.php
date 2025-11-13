<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Archival & Information System</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .welcome-container {
            background: white;
            padding: 3rem;
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            text-align: center;
            max-width: 500px;
            margin: 20px;
        }
        .welcome-title {
            color: #333;
            margin-bottom: 1rem;
            font-size: 2rem;
        }
        .welcome-subtitle {
            color: #666;
            margin-bottom: 2rem;
            font-size: 1.1rem;
        }
        .btn {
            display: inline-block;
            padding: 12px 30px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 25px;
            margin: 10px;
            transition: transform 0.2s;
        }
        .btn:hover {
            transform: translateY(-2px);
        }
        .btn-secondary {
            background: #6c757d;
        }
        .credentials {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
            border-left: 4px solid #28a745;
        }
        .credentials h3 {
            margin-top: 0;
            color: #28a745;
        }
        .credentials p {
            margin: 5px 0;
            font-family: monospace;
            background: white;
            padding: 5px 10px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="welcome-container">
    <h1 class="welcome-title">📁 Smart Archival & Information System</h1>
        <p class="welcome-subtitle">Welcome to your document management portal</p>
        
        <div class="credentials">
            <h3>🔑 Default Login Credentials</h3>
            <p><strong>Username:</strong> admin</p>
            <p><strong>Password:</strong> password</p>
            <small style="color: #dc3545;">⚠️ Change password after first login!</small>
        </div>
        
        <div>
            <a href="login.php" class="btn">🚀 Login to System</a>
            <a href="setup/install.php" class="btn btn-secondary">⚙️ Setup Wizard</a>
        </div>
        
        <div style="margin-top: 2rem; font-size: 0.9rem; color: #666;">
            <p>System Status: <span style="color: #28a745;">✅ Ready</span></p>
            <p>Database: <span style="color: #28a745;">✅ Connected</span></p>
        </div>
    </div>
</body>
</html>
