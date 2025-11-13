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
    <div style="max-width: 1400px; margin: 0 auto; padding: 0 var(--spacing-md); display: flex; align-items: center; justify-content: space-between;">
        <div style="display: flex; align-items: center; flex: 1;">
            <button class="nav-toggle" id="navToggle" aria-expanded="false" aria-controls="navMenu" aria-label="Toggle navigation menu">
                <span class="hamburger"></span>
            </button>
            <ul class="nav-menu" id="navMenu" hidden>
                <li class="nav-item">
                    <a href="<?php echo $baseUrl; ?>index.php" class="nav-link">Dashboard</a>
                </li>
                
                <li class="nav-item">
                    <a href="#" class="nav-link dropdown-trigger">Department <span class="dropdown-arrow">▼</span></a>
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
                    <a href="#" class="nav-link dropdown-trigger">Faculty <span class="dropdown-arrow">▼</span></a>
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
                    <a href="#" class="nav-link dropdown-trigger">Student <span class="dropdown-arrow">▼</span></a>
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
        </div>
        
        <!-- View Mode Toggle in Navigation -->
        <button class="view-toggle-nav" id="viewToggleNav" title="Toggle View Mode" aria-label="Toggle between Mobile and Desktop view">
            <svg id="viewIconNav" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <!-- Desktop icon by default -->
                <rect x="2" y="3" width="20" height="14" rx="2" stroke="currentColor" stroke-width="2" fill="none"/>
                <line x1="2" y1="17" x2="22" y2="17" stroke="currentColor" stroke-width="2"/>
            </svg>
            <span class="view-label" id="viewLabel">Auto</span>
        </button>
    </div>
</nav>