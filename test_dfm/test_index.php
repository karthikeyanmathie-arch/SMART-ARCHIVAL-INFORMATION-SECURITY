<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Skip authentication for testing
//require_once 'includes/auth.php';
//$auth = checkAuth();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Archival & Information System</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="main-container">
        <h1 class="page-title">Dashboard</h1>
        
        <div class="dashboard-grid">
            <!-- Department -->
            <div class="dashboard-card">
                <h3>Department</h3>
                <p>Manage academic calendar, timetables, admissions, and research publications</p>
                <a href="modules/department/index.php" class="btn btn-primary">Access Department</a>
            </div>

            <!-- Faculty -->
            <div class="dashboard-card">
                <h3>Faculty</h3>
                <p>Handle syllabus, results, assessments, and faculty appraisals</p>
                <a href="modules/faculty/index.php" class="btn btn-primary">Access Faculty</a>
            </div>

            <!-- Student -->
            <div class="dashboard-card">
                <h3>Student</h3>
                <p>Manage alumni, value-added courses, and student activities</p>
                <a href="modules/student/index.php" class="btn btn-primary">Access Student</a>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="content-card">
            <h2>Quick Statistics</h2>
            <div class="dashboard-grid">
                <div class="stat-card">
                    <h3>Test without Auth</h3>
                    <div class="stat-number">Working!</div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
