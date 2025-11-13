<?php
// Module Pages Test Script
ini_set('display_errors', 1);
error_reporting(E_ALL);

echo "🧪 Testing All Module Pages\n\n";

// Test URLs for all modules
$modulePages = [
    'Department' => [
        'modules/department/index.php',
        'modules/department/academic_calendar.php',
        'modules/department/timetable.php',
        'modules/department/student_admission.php',
        'modules/department/remedial_classes.php',
        'modules/department/bridge_course.php',
        'modules/department/research_publications.php',
        'modules/department/mou_collaboration.php',
        'modules/department/higher_study.php'
    ],
    'Faculty' => [
        'modules/faculty/index.php',
        'modules/faculty/syllabus.php',
        'modules/faculty/result_analysis.php',
        'modules/faculty/internal_assessment.php',
        'modules/faculty/scholarship.php',
        'modules/faculty/placement.php',
        'modules/faculty/meeting_minutes.php',
        'modules/faculty/faculty_appraisal.php'
    ],
    'Student' => [
        'modules/student/index.php',
        'modules/student/alumni.php',
        'modules/student/value_added_courses.php',
        'modules/student/extension_outreach.php',
        'modules/student/student_projects.php',
        'modules/student/student_participation.php'
    ]
];

$totalPages = 0;
$existingPages = 0;
$workingPages = 0;

foreach ($modulePages as $sector => $pages) {
    echo "📂 $sector:\n";
    
    foreach ($pages as $page) {
        $totalPages++;
        $fullPath = __DIR__ . '/' . $page;
        
        if (file_exists($fullPath)) {
            $existingPages++;
            echo "  ✅ $page - EXISTS";
            
            // Test if PHP file has syntax errors
            $output = shell_exec("C:\\xampp\\php\\php.exe -l \"$fullPath\" 2>&1");
            if (strpos($output, 'No syntax errors') !== false) {
                $workingPages++;
                echo " - SYNTAX OK\n";
            } else {
                echo " - SYNTAX ERROR\n";
                echo "    Error: " . trim($output) . "\n";
            }
        } else {
            echo "  ❌ $page - MISSING\n";
        }
    }
    echo "\n";
}

echo "📊 Summary:\n";
echo "Total Pages: $totalPages\n";
echo "Existing Pages: $existingPages\n";
echo "Working Pages: $workingPages\n";
echo "Missing Pages: " . ($totalPages - $existingPages) . "\n";
echo "Pages with Errors: " . ($existingPages - $workingPages) . "\n";

if ($totalPages == $existingPages && $existingPages == $workingPages) {
    echo "\n🎉 ALL MODULE PAGES ARE WORKING!\n";
} else {
    echo "\n⚠️  Some pages need attention.\n";
}
?>
// Module Test Page - Check which modules are working
ini_set('display_errors', 1);
error_reporting(E_ALL);

echo "<h1>Navigation Module Testing</h1>";
echo "<style>
    body { font-family: Arial, sans-serif; margin: 20px; }
    .test-section { margin: 20px 0; padding: 15px; border: 1px solid #ccc; }
    .success { color: green; background: #f0fff0; padding: 5px; }
    .error { color: red; background: #fff0f0; padding: 5px; }
    .warning { color: orange; background: #fff8e1; padding: 5px; }
    table { border-collapse: collapse; width: 100%; }
    th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
    th { background-color: #f2f2f2; }
    .status-good { color: green; }
    .status-bad { color: red; }
    .test-link { margin: 5px; padding: 5px 10px; background: #007cba; color: white; text-decoration: none; border-radius: 3px; }
</style>";

// Test navigation links
$modules = [
    'Department' => [
        'academic_calendar.php',
        'timetable.php', 
        'student_admission.php',
        'remedial_classes.php',
        'bridge_course.php',
        'research_publications.php',
        'mou_collaboration.php',
        'higher_study.php'
    ],
    'Faculty' => [
        'syllabus.php',
        'result_analysis.php',
        'internal_assessment.php',
        'scholarship.php',
        'placement.php',
        'meeting_minutes.php',
        'faculty_appraisal.php'
    ],
    'Student' => [
        'alumni.php',
        'value_added_courses.php',
        'extension_outreach.php',
        'student_projects.php',
        'student_participation.php'
    ]
];

echo "<div class='test-section'>";
echo "<h2>Module File Status Check</h2>";
echo "<table>";
echo "<tr><th>Module Type</th><th>File Name</th><th>File Exists</th><th>File Size</th><th>Test Link</th></tr>";

foreach ($modules as $moduleType => $files) {
    foreach ($files as $file) {
        $filePath = __DIR__ . "/modules/" . strtolower($moduleType) . "/" . $file;
        $fileExists = file_exists($filePath);
        $fileSize = $fileExists ? filesize($filePath) : 0;
        
        echo "<tr>";
        echo "<td>" . ucfirst($moduleType) . "</td>";
        echo "<td>$file</td>";
        echo "<td class='" . ($fileExists ? 'status-good' : 'status-bad') . "'>" . ($fileExists ? '✓ Exists' : '✗ Missing') . "</td>";
        echo "<td>" . ($fileSize > 0 ? number_format($fileSize) . ' bytes' : 'Empty/Missing') . "</td>";
        echo "<td><a href='/shrii/modules/" . strtolower($moduleType) . "/$file' class='test-link' target='_blank'>Test</a></td>";
        echo "</tr>";
    }
}

echo "</table>";
echo "</div>";

// Test navigation include
echo "<div class='test-section'>";
echo "<h2>Navigation Include Test</h2>";
$navPath = __DIR__ . "/includes/navigation.php";
if (file_exists($navPath)) {
    echo "<div class='success'>✓ Navigation file exists</div>";
    echo "<h3>Navigation Preview:</h3>";
    echo "<div style='border: 1px solid #ccc; padding: 10px;'>";
    
    // Start session for navigation
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    
    // Set mock session data for navigation testing
    $_SESSION['user_id'] = 1;
    $_SESSION['username'] = 'test';
    $_SESSION['role'] = 'admin';
    
    include $navPath;
    echo "</div>";
} else {
    echo "<div class='error'>✗ Navigation file missing</div>";
}
echo "</div>";

// Test database connection
echo "<div class='test-section'>";
echo "<h2>Database Connection Test</h2>";
try {
    require_once 'config/database.php';
    $db = new Database();
    $pdo = $db->getConnection();
    echo "<div class='success'>✓ Database connection successful</div>";
    
    // Check if tables exist
    $tables = ['users', 'academic_calendar', 'syllabus', 'research_publications'];
    echo "<h3>Database Tables:</h3>";
    foreach ($tables as $table) {
        try {
            $stmt = $pdo->query("SHOW TABLES LIKE '$table'");
            if ($stmt->rowCount() > 0) {
                $count_stmt = $pdo->query("SELECT COUNT(*) as count FROM $table");
                $count = $count_stmt->fetch(PDO::FETCH_ASSOC)['count'];
                echo "<div class='success'>✓ Table '$table' exists ($count records)</div>";
            } else {
                echo "<div class='warning'>⚠ Table '$table' missing</div>";
            }
        } catch (Exception $e) {
            echo "<div class='error'>✗ Error checking table '$table': " . $e->getMessage() . "</div>";
        }
    }
    
} catch (Exception $e) {
    echo "<div class='error'>✗ Database connection failed: " . $e->getMessage() . "</div>";
}
echo "</div>";

echo "<div class='test-section'>";
echo "<h2>Quick Actions</h2>";
echo "<a href='/shrii/index.php' class='test-link'>Back to Dashboard</a>";
echo "<a href='/shrii/fix_mysql.php' class='test-link'>Database Setup</a>";
echo "<a href='javascript:location.reload()' class='test-link'>Refresh Tests</a>";
echo "</div>";
?>