<?php
require_once '../../includes/auth.php';
$auth = checkAuth();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty - Smart Archival & Information System</title>
    <link rel="icon" type="image/jpeg" href="/test_dfm/assets/images/college_logo.jpg">
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
    <?php include '../../includes/header.php'; ?>
    <?php include '../../includes/navigation.php'; ?>

    <div class="main-container">
    <h1 class="page-title">Faculty</h1>
        
        <div class="dashboard-grid">
            <div class="dashboard-card">
                <h3>Syllabus</h3>
                <p>Manage course syllabus and curriculum</p>
                <a href="syllabus.php" class="btn btn-primary">Manage</a>
            </div>

            <div class="dashboard-card">
                <h3>Result Analysis</h3>
                <p>Analyze student results and performance</p>
                <a href="result_analysis.php" class="btn btn-primary">Manage</a>
            </div>

            <div class="dashboard-card">
                <h3>Internal Assessment</h3>
                <p>Internal assessment records and marks</p>
                <a href="internal_assessment.php" class="btn btn-primary">Manage</a>
            </div>

            <div class="dashboard-card">
                <h3>Scholarship Files</h3>
                <p>Student scholarship applications and records</p>
                <a href="scholarship.php" class="btn btn-primary">Manage</a>
            </div>

            <div class="dashboard-card">
                <h3>Placement Files</h3>
                <p>Student placement records and company details</p>
                <a href="placement.php" class="btn btn-primary">Manage</a>
            </div>

            <div class="dashboard-card">
                <h3>Meeting Minutes</h3>
                <p>Department meeting minutes and decisions</p>
                <a href="meeting_minutes.php" class="btn btn-primary">Manage</a>
            </div>

            <div class="dashboard-card">
                <h3>Faculty Appraisal</h3>
                <p>Faculty performance appraisal reports</p>
                <a href="faculty_appraisal.php" class="btn btn-primary">Manage</a>
            </div>
        </div>
    </div>

    <script src="../../assets/js/script.js"></script>
</body>
</html>