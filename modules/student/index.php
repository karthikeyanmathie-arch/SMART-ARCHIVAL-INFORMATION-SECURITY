<?php
require_once '../../includes/auth.php';
$auth = checkAuth();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student - Document Management System</title>
    <link rel="icon" type="image/jpeg" href="/test_dfm/assets/images/college_logo.jpg">
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
    <?php include '../../includes/header.php'; ?>
    <?php include '../../includes/navigation.php'; ?>

    <div class="main-container">
    <h1 class="page-title">Student</h1>
        
        <div class="dashboard-grid">
            <div class="dashboard-card">
                <h3>Alumni Details</h3>
                <p>Manage alumni information and contact details</p>
                <a href="alumni.php" class="btn btn-primary">Manage</a>
            </div>

            <div class="dashboard-card">
                <h3>Value Added Courses</h3>
                <p>Additional courses and skill development programs</p>
                <a href="value_added_courses.php" class="btn btn-primary">Manage</a>
            </div>

            <div class="dashboard-card">
                <h3>Extension & Outreach</h3>
                <p>Community service and outreach programs</p>
                <a href="extension_outreach.php" class="btn btn-primary">Manage</a>
            </div>

            <div class="dashboard-card">
                <h3>Student Projects</h3>
                <p>Student project activities and records</p>
                <a href="student_projects.php" class="btn btn-primary">Manage</a>
            </div>

            <div class="dashboard-card">
                <h3>Student Participation</h3>
                <p>Student participation in other college events</p>
                <a href="student_participation.php" class="btn btn-primary">Manage</a>
            </div>
        </div>
    </div>

    <script src="../../assets/js/script.js"></script>
</body>
</html>