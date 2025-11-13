<?php
// Function to get the correct base URL for navigation
function getBaseUrl() {
    $currentPath = $_SERVER['REQUEST_URI'] ?? '';
    $projectRoot = '/test_dfm/';
    return $projectRoot;
}

$baseUrl = getBaseUrl();
?>
<nav class="nav-container">
    <ul class="nav-menu">
        <li class="nav-item">
            <a href="<?php echo $baseUrl; ?>index.php" class="nav-link">Dashboard</a>
        </li>
        
        <li class="nav-item">
            <a href="#" class="nav-link">Department</a>
            <div class="dropdown">
                <a href="<?php echo $baseUrl; ?>modules/department/index.php" class="dropdown-link">Department Dashboard</a>
                <a href="<?php echo $baseUrl; ?>modules/department/academic_calendar.php" class="dropdown-link">Academic Calendar</a>
                <a href="<?php echo $baseUrl; ?>modules/department/timetable.php" class="dropdown-link">Timetable</a>
                <a href="<?php echo $baseUrl; ?>modules/department/student_admission.php" class="dropdown-link">Student Admission</a>
                <a href="<?php echo $baseUrl; ?>modules/department/remedial_classes.php" class="dropdown-link">Remedial Classes</a>
                <a href="<?php echo $baseUrl; ?>modules/department/bridge_course.php" class="dropdown-link">Bridge Course Sessions</a>
                <a href="<?php echo $baseUrl; ?>modules/department/research_publications.php" class="dropdown-link">Research Publications</a>
                <a href="<?php echo $baseUrl; ?>modules/department/mou_collaboration.php" class="dropdown-link">MOU & Collaboration</a>
                <a href="<?php echo $baseUrl; ?>modules/department/higher_study.php" class="dropdown-link">Higher Study Data</a>
            </div>
        </li>
        
        <li class="nav-item">
            <a href="#" class="nav-link">Faculty</a>
            <div class="dropdown">
                <a href="<?php echo $baseUrl; ?>modules/faculty/index.php" class="dropdown-link">Faculty Dashboard</a>
                <a href="<?php echo $baseUrl; ?>modules/faculty/syllabus.php" class="dropdown-link">Syllabus</a>
                <a href="<?php echo $baseUrl; ?>modules/faculty/result_analysis.php" class="dropdown-link">Result Analysis</a>
                <a href="<?php echo $baseUrl; ?>modules/faculty/internal_assessment.php" class="dropdown-link">Internal Assessment</a>
                <a href="<?php echo $baseUrl; ?>modules/faculty/scholarship.php" class="dropdown-link">Scholarship Files</a>
                <a href="<?php echo $baseUrl; ?>modules/faculty/placement.php" class="dropdown-link">Placement Files</a>
                <a href="<?php echo $baseUrl; ?>modules/faculty/meeting_minutes.php" class="dropdown-link">Meeting Minutes</a>
                <a href="<?php echo $baseUrl; ?>modules/faculty/faculty_appraisal.php" class="dropdown-link">Faculty Appraisal</a>
            </div>
        </li>
        
        <li class="nav-item">
            <a href="#" class="nav-link">Student</a>
            <div class="dropdown">
                <a href="<?php echo $baseUrl; ?>modules/student/index.php" class="dropdown-link">Student Dashboard</a>
                <a href="<?php echo $baseUrl; ?>modules/student/alumni.php" class="dropdown-link">Alumni Details</a>
                <a href="<?php echo $baseUrl; ?>modules/student/value_added_courses.php" class="dropdown-link">Value Added Courses</a>
                <a href="<?php echo $baseUrl; ?>modules/student/extension_outreach.php" class="dropdown-link">Extension & Outreach</a>
                <a href="<?php echo $baseUrl; ?>modules/student/student_projects.php" class="dropdown-link">Student Projects</a>
                <a href="<?php echo $baseUrl; ?>modules/student/student_participation.php" class="dropdown-link">Student Participation</a>
            </div>
        </li>
        
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
        <li class="nav-item">
            <a href="<?php echo $baseUrl; ?>admin/users.php" class="nav-link">User Management</a>
        </li>
        <?php endif; ?>
        
        <li class="nav-item">
            <a href="<?php echo $baseUrl; ?>profile.php" class="nav-link">My Profile</a>
        </li>
    </ul>
</nav>