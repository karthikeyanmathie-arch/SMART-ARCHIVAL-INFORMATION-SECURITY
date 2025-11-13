<?php
require_once '../../includes/auth.php';
$auth = checkAuth();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Department - Smart Archival & Information System</title>
    <link rel="icon" type="image/jpeg" href="/test_dfm/assets/images/college_logo.jpg">
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
    <?php include '../../includes/header.php'; ?>
    <?php include '../../includes/navigation.php'; ?>

    <div class="main-container">
    <h1 class="page-title">Department</h1>
        
        <div class="dashboard-grid">
            <div class="dashboard-card">
                <h3>Academic Calendar</h3>
                <p>Manage academic year events and schedules</p>
                <a href="academic_calendar.php" class="btn btn-primary">Manage</a>
            </div>

            <div class="dashboard-card">
                <h3>Timetable</h3>
                <p>Class schedules and faculty assignments</p>
                <a href="timetable.php" class="btn btn-primary">Manage</a>
            </div>

            <div class="dashboard-card">
                <h3>Student Admission</h3>
                <p>Student admission records and documents</p>
                <a href="student_admission.php" class="btn btn-primary">Manage</a>
            </div>

            <div class="dashboard-card">
                <h3>Remedial Classes</h3>
                <p>Remedial class schedules and records</p>
                <a href="remedial_classes.php" class="btn btn-primary">Manage</a>
            </div>

            <div class="dashboard-card">
                <h3>Bridge Course Sessions</h3>
                <p>Bridge course programs and sessions</p>
                <a href="bridge_course.php" class="btn btn-primary">Manage</a>
            </div>

            <div class="dashboard-card">
                <h3>Research Publications</h3>
                <p>Faculty research publications and papers</p>
                <a href="research_publications.php" class="btn btn-primary">Manage</a>
            </div>

            <div class="dashboard-card">
                <h3>MOU & Collaboration</h3>
                <p>Memorandums of understanding and partnerships</p>
                <a href="mou_collaboration.php" class="btn btn-primary">Manage</a>
            </div>

            <div class="dashboard-card">
                <h3>Higher Study Data</h3>
                <p>Passed out students pursuing higher studies</p>
                <a href="higher_study.php" class="btn btn-primary">Manage</a>
            </div>
        </div>
    </div>

    <script src="../../assets/js/script.js"></script>
</body>
</html>