<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minimal Dashboard Test</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            margin: 20px; 
            background: #f5f5f5;
        }
        .card { 
            background: white; 
            border: 1px solid #ddd; 
            border-radius: 8px; 
            padding: 20px; 
            margin: 10px 0; 
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .btn { 
            display: inline-block; 
            padding: 12px 24px; 
            background: #007bff; 
            color: white; 
            text-decoration: none; 
            border-radius: 4px; 
            margin: 5px;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }
        .btn:hover { 
            background: #0056b3; 
            color: white;
            text-decoration: none;
        }
        .status { 
            padding: 10px; 
            border-radius: 4px; 
            margin: 10px 0;
        }
        .status.success { 
            background: #d4edda; 
            color: #155724; 
            border: 1px solid #c3e6cb;
        }
        .status.warning { 
            background: #fff3cd; 
            color: #856404; 
            border: 1px solid #ffeaa7;
        }
    </style>
</head>
<body>
    <h1>🧪 Minimal Dashboard Test</h1>
    
    <?php if (isset($_SESSION['user_id'])): ?>
        <div class="status success">
            ✅ <strong>Logged in as:</strong> <?php echo $_SESSION['username']; ?> (<?php echo $_SESSION['role']; ?>)
        </div>
    <?php else: ?>
        <div class="status warning">
            ⚠️ <strong>Not logged in</strong> - Some links may not work
        </div>
    <?php endif; ?>

    <div class="card">
        <h2>📊 Navigation Test</h2>
        <p>Try each of these links and see what happens:</p>
        
        <a href="index.php" class="btn">🏠 Main Dashboard</a>
        <a href="modules/department/index.php" class="btn">🏢 Department</a>
        <a href="modules/faculty/index.php" class="btn">👨‍🏫 Faculty</a>
        <a href="modules/student/index.php" class="btn">🎓 Student</a>
    </div>

    <div class="card">
        <h2>🔧 Direct Module Tests</h2>
        <p>These should work if you're logged in:</p>
        
        <a href="modules/department/academic_calendar.php" class="btn">📅 Academic Calendar</a>
        <a href="modules/faculty/syllabus.php" class="btn">📚 Syllabus</a>
        <a href="modules/student/alumni.php" class="btn">🎓 Alumni</a>
    </div>

    <div class="card">
        <h2>🔐 Authentication</h2>
        <a href="quick_login.php" class="btn">🔑 Quick Login</a>
        <a href="login.php" class="btn">📝 Manual Login</a>
        <a href="logout.php" class="btn">🚪 Logout</a>
    </div>

    <div class="card">
        <h2>📋 System Info</h2>
        <p><strong>Current URL:</strong> <?php echo $_SERVER['REQUEST_URI']; ?></p>
        <p><strong>Document Root:</strong> <?php echo $_SERVER['DOCUMENT_ROOT']; ?></p>
        <p><strong>Server Software:</strong> <?php echo $_SERVER['SERVER_SOFTWARE']; ?></p>
        <p><strong>PHP Version:</strong> <?php echo PHP_VERSION; ?></p>
        <p><strong>Session ID:</strong> <?php echo session_id(); ?></p>
    </div>

    <script>
        // Log all clicks for debugging
        document.addEventListener('click', function(e) {
            if (e.target.tagName === 'A') {
                console.log('Clicked link:', e.target.href);
                console.log('Target:', e.target);
                
                // Test if link is working
                const url = e.target.href;
                console.log('Attempting to navigate to:', url);
            }
        });

        // Check for any JavaScript errors
        window.addEventListener('error', function(e) {
            console.error('JavaScript Error:', e.message, 'at', e.filename, ':', e.lineno);
            alert('JavaScript Error: ' + e.message);
        });
    </script>
</body>
</html>
