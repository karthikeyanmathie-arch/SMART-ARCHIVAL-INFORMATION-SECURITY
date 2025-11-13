<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Navigation - Smart Archival & Information System</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="main-container">
        <h1>🧪 Navigation Test Page</h1>
        <p>Test all navigation links without authentication</p>
        
        <div class="content-card">
            <h2>Department Links</h2>
            <ul>
                <li><a href="modules/department/academic_calendar.php">Academic Calendar</a></li>
                <li><a href="modules/department/timetable.php">Timetable</a></li>
                <li><a href="modules/department/student_admission.php">Student Admission</a></li>
                <li><a href="modules/department/remedial_classes.php">Remedial Classes</a></li>
                <li><a href="modules/department/bridge_course.php">Bridge Course Sessions</a></li>
                <li><a href="modules/department/research_publications.php">Research Publications</a></li>
                <li><a href="modules/department/mou_collaboration.php">MOU & Collaboration</a></li>
                <li><a href="modules/department/higher_study.php">Higher Study Data</a></li>
            </ul>
        </div>

        <div class="content-card">
            <h2>Faculty Links</h2>
            <ul>
                <li><a href="modules/faculty/syllabus.php">Syllabus</a></li>
                <li><a href="modules/faculty/result_analysis.php">Result Analysis</a></li>
                <li><a href="modules/faculty/internal_assessment.php">Internal Assessment</a></li>
                <li><a href="modules/faculty/scholarship.php">Scholarship Files</a></li>
                <li><a href="modules/faculty/placement.php">Placement Files</a></li>
                <li><a href="modules/faculty/meeting_minutes.php">Meeting Minutes</a></li>
                <li><a href="modules/faculty/faculty_appraisal.php">Faculty Appraisal</a></li>
            </ul>
        </div>

        <div class="content-card">
            <h2>Student Links</h2>
            <ul>
                <li><a href="modules/student/alumni.php">Alumni Details</a></li>
                <li><a href="modules/student/value_added_courses.php">Value Added Courses</a></li>
                <li><a href="modules/student/extension_outreach.php">Extension & Outreach</a></li>
                <li><a href="modules/student/student_projects.php">Student Projects</a></li>
                <li><a href="modules/student/student_participation.php">Student Participation</a></li>
            </ul>
        </div>

        <div class="content-card">
            <h2>Main System Links</h2>
            <ul>
                <li><a href="welcome.php">Welcome Page</a></li>
                <li><a href="login.php">Login Page</a></li>
                <li><a href="index.php">Dashboard (requires login)</a></li>
            </ul>
        </div>
    </div>
    
    <style>
        .content-card {
            background: white;
            margin: 20px 0;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        li {
            margin: 10px 0;
        }
        a {
            color: #007bff;
            text-decoration: none;
            padding: 8px 12px;
            border: 1px solid #007bff;
            border-radius: 4px;
            display: inline-block;
        }
        a:hover {
            background-color: #007bff;
            color: white;
        }
    </style>
</body>
</html>
