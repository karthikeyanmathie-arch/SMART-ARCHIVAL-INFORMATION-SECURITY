<?php
// Start session and include auth
session_start();
require_once 'includes/auth.php';

// Check if logged in
$isLoggedIn = isset($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty & Student Test</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .test-section {
            margin: 20px 0;
            padding: 20px;
            border: 2px solid #ddd;
            border-radius: 8px;
        }
        .status-good { border-color: #28a745; background: #f8fff9; }
        .status-bad { border-color: #dc3545; background: #fff8f8; }
        .test-link {
            display: inline-block;
            margin: 5px;
            padding: 8px 12px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }
        .test-link:hover {
            background: #0056b3;
            color: white;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="main-container">
    <h1>🔧 Faculty & Student Diagnostic</h1>
        
        <div class="test-section <?php echo $isLoggedIn ? 'status-good' : 'status-bad'; ?>">
            <h2>🔐 Authentication Status</h2>
            <?php if ($isLoggedIn): ?>
                <p>✅ <strong>Logged in as:</strong> <?php echo $_SESSION['username']; ?> (<?php echo $_SESSION['role']; ?>)</p>
                <p>✅ Session active - All modules should work</p>
            <?php else: ?>
                <p>❌ <strong>Not logged in</strong> - This is likely the problem!</p>
                <p><a href="auto_login.php" class="test-link">Auto Login</a> <a href="login.php" class="test-link">Manual Login</a></p>
            <?php endif; ?>
        </div>

        <div class="test-section">
            <h2>🏢 Main Dashboard Links</h2>
            <a href="index.php" class="test-link">Main Dashboard</a>
            <a href="modules/department/index.php" class="test-link">Department Index</a>
            <a href="modules/faculty/index.php" class="test-link">Faculty Index</a>
            <a href="modules/student/index.php" class="test-link">Student Index</a>
        </div>

        <div class="test-section">
            <h2>👨‍🏫 Faculty - All Links</h2>
            <a href="modules/faculty/syllabus.php" class="test-link">Syllabus</a>
            <a href="modules/faculty/result_analysis.php" class="test-link">Result Analysis</a>
            <a href="modules/faculty/internal_assessment.php" class="test-link">Internal Assessment</a>
            <a href="modules/faculty/scholarship.php" class="test-link">Scholarship Files</a>
            <a href="modules/faculty/placement.php" class="test-link">Placement Files</a>
            <a href="modules/faculty/meeting_minutes.php" class="test-link">Meeting Minutes</a>
            <a href="modules/faculty/faculty_appraisal.php" class="test-link">Faculty Appraisal</a>
        </div>

        <div class="test-section">
            <h2>🎓 Student - All Links</h2>
            <a href="modules/student/alumni.php" class="test-link">Alumni Details</a>
            <a href="modules/student/value_added_courses.php" class="test-link">Value Added Courses</a>
            <a href="modules/student/extension_outreach.php" class="test-link">Extension & Outreach</a>
            <a href="modules/student/student_projects.php" class="test-link">Student Projects</a>
            <a href="modules/student/student_participation.php" class="test-link">Student Participation</a>
        </div>

        <div class="test-section">
            <h2>📋 File Existence Check</h2>
            <?php
            $facultyFiles = [
                'syllabus.php', 'result_analysis.php', 'internal_assessment.php', 
                'scholarship.php', 'placement.php', 'meeting_minutes.php', 'faculty_appraisal.php'
            ];
            
            $studentFiles = [
                'alumni.php', 'value_added_courses.php', 'extension_outreach.php', 
                'student_projects.php', 'student_participation.php'
            ];
            
            echo "<h4>Faculty Files:</h4>";
            foreach ($facultyFiles as $file) {
                $exists = file_exists("modules/faculty/$file");
                echo "<span style='color: " . ($exists ? 'green' : 'red') . "'>";
                echo ($exists ? '✅' : '❌') . " $file</span><br>";
            }
            
            echo "<h4>Student Files:</h4>";
            foreach ($studentFiles as $file) {
                $exists = file_exists("modules/student/$file");
                echo "<span style='color: " . ($exists ? 'green' : 'red') . "'>";
                echo ($exists ? '✅' : '❌') . " $file</span><br>";
            }
            ?>
        </div>

        <div class="test-section">
            <h2>🔍 Troubleshooting Steps</h2>
            <ol>
                <li><strong>Login First:</strong> Make sure you're logged in before accessing modules</li>
                <li><strong>Clear Browser Cache:</strong> Press Ctrl+F5 to refresh</li>
                <li><strong>Check URLs:</strong> Ensure you're using correct URLs</li>
                <li><strong>Test Direct Links:</strong> Use the links above to test each page</li>
            </ol>
        </div>
    </div>
</body>
</html>
