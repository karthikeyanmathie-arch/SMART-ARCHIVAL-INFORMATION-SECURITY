<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Link Test</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .test-box { 
            border: 2px solid #007bff; 
            margin: 10px 0; 
            padding: 15px; 
            border-radius: 8px; 
        }
        .btn { 
            display: inline-block; 
            padding: 10px 20px; 
            background: #007bff; 
            color: white; 
            text-decoration: none; 
            border-radius: 4px; 
            margin: 5px;
        }
        .btn:hover { background: #0056b3; }
        .error { color: red; font-weight: bold; }
        .success { color: green; font-weight: bold; }
    </style>
</head>
<body>
    <h1>🔗 Dashboard Link Diagnostic Test</h1>
    
    <div class="test-box">
        <h2>Current Status</h2>
        <p><strong>Current URL:</strong> <span id="currentUrl"></span></p>
        <p><strong>Browser:</strong> <span id="userAgent"></span></p>
        <p><strong>Local Storage:</strong> <span id="localStorage"></span></p>
    </div>

    <div class="test-box">
        <h2>Direct Link Tests</h2>
        <p>Click these links and see what happens:</p>
        
    <a href="http://localhost/test_dfm/index.php" class="btn" onclick="logClick('Dashboard')">Main Dashboard</a>
    <a href="http://localhost/test_dfm/modules/department/index.php" class="btn" onclick="logClick('Department')">Department</a>
    <a href="http://localhost/test_dfm/modules/faculty/index.php" class="btn" onclick="logClick('Faculty')">Faculty</a>
    <a href="http://localhost/test_dfm/modules/student/index.php" class="btn" onclick="logClick('Student')">Student</a>
    </div>

    <div class="test-box">
        <h2>Relative Link Tests</h2>
        <p>These use relative paths like the dashboard:</p>
        
        <a href="modules/department/index.php" class="btn" onclick="logClick('Rel Department')">Department (Relative)</a>
        <a href="modules/faculty/index.php" class="btn" onclick="logClick('Rel Faculty')">Faculty (Relative)</a>
        <a href="modules/student/index.php" class="btn" onclick="logClick('Rel Student')">Student (Relative)</a>
    </div>

    <div class="test-box">
        <h2>Authentication Test</h2>
        <a href="http://localhost/test_dfm/quick_login.php" class="btn">Quick Login</a>
        <a href="http://localhost/test_dfm/test_faculty_student.php" class="btn">Full Test Page</a>
    </div>

    <div class="test-box">
        <h2>📝 Click Log</h2>
        <div id="clickLog">No clicks yet...</div>
    </div>

    <script>
        // Display current info
        document.getElementById('currentUrl').textContent = window.location.href;
        document.getElementById('userAgent').textContent = navigator.userAgent;
        document.getElementById('localStorage').textContent = localStorage.length + ' items';

        // Log clicks
        function logClick(linkName) {
            const time = new Date().toLocaleTimeString();
            const logDiv = document.getElementById('clickLog');
            const entry = `<div>[${time}] Clicked: ${linkName}</div>`;
            
            if (logDiv.innerHTML === 'No clicks yet...') {
                logDiv.innerHTML = entry;
            } else {
                logDiv.innerHTML += entry;
            }
        }

        // Check for JavaScript errors
        window.onerror = function(msg, url, line) {
            const logDiv = document.getElementById('clickLog');
            logDiv.innerHTML += `<div class="error">[ERROR] ${msg} at line ${line}</div>`;
        };

        // Test AJAX connectivity
        function testConnectivity() {
            fetch('http://localhost/test_dfm/index.php')
                .then(response => {
                    if (response.ok) {
                        document.getElementById('clickLog').innerHTML += '<div class="success">[CONNECTIVITY] ✅ Server responding</div>';
                    } else {
                        document.getElementById('clickLog').innerHTML += '<div class="error">[CONNECTIVITY] ❌ Server error: ' + response.status + '</div>';
                    }
                })
                .catch(error => {
                    document.getElementById('clickLog').innerHTML += '<div class="error">[CONNECTIVITY] ❌ Network error: ' + error.message + '</div>';
                });
        }

        // Run connectivity test on load
        setTimeout(testConnectivity, 1000);
    </script>
</body>
</html>
