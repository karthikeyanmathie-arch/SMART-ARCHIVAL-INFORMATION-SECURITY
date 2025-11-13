<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'includes/auth.php';
$auth = checkAuth();
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
    <?php include 'includes/header.php'; ?>
    <?php include 'includes/navigation.php'; ?>

    <div class="main-container">
        <h1 class="page-title">Dashboard</h1>
        
        <div class="dashboard-grid">
            <!-- Department Sector -->
            <div class="dashboard-card">
                <h3>Department Sector</h3>
                <p>Manage academic calendar, timetables, admissions, and research publications</p>
                <a href="modules/department/index.php" class="btn btn-primary">Access Department</a>
            </div>

            <!-- Faculty Sector -->
            <div class="dashboard-card">
                <h3>Faculty Sector</h3>
                <p>Handle syllabus, results, assessments, and faculty appraisals</p>
                <a href="modules/faculty/index.php" class="btn btn-primary">Access Faculty</a>
            </div>

            <!-- Student Sector -->
            <div class="dashboard-card">
                <h3>Student Sector</h3>
                <p>Manage alumni, value-added courses, and student activities</p>
                <a href="modules/student/index.php" class="btn btn-primary">Access Student</a>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="content-card">
            <h2>Quick Statistics</h2>
            <div class="dashboard-grid">
                <?php
                require_once 'config/database.php';
                $database = new Database();
                $db = $database->getConnection();

                // Get counts for various modules
                $stats = [
                    'Students Admitted' => 'student_admission',
                    'Research Publications' => 'research_publications',
                    'Active MOUs' => 'mou_collaboration',
                    'Alumni Records' => 'alumni_details',
                    'Faculty Appraisals' => 'faculty_appraisal',
                    'Student Projects' => 'student_projects'
                ];

                foreach ($stats as $label => $table) {
                    $query = "SELECT COUNT(*) as count FROM $table";
                    $stmt = $db->prepare($query);
                    $stmt->execute();
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
                    echo "<div class='dashboard-card'>";
                    echo "<h3>{$result['count']}</h3>";
                    echo "<p>$label</p>";
                    echo "</div>";
                }
                ?>
            </div>
        </div>
    </div>

    <script src="assets/js/script.js"></script>
</body>
</html>