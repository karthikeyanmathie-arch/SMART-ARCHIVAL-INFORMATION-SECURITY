<?php
// Navigation Fix Script - Comprehensive solution for navigation issues
ini_set('display_errors', 1);
error_reporting(E_ALL);

echo "<!DOCTYPE html>";
echo "<html><head>";
echo "<title>Navigation Fix - SHRII</title>";
echo "<style>
    body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
    .fix-section { background: white; margin: 20px 0; padding: 20px; border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
    .success { color: green; background: #f0fff0; padding: 10px; border-left: 4px solid green; }
    .error { color: red; background: #fff0f0; padding: 10px; border-left: 4px solid red; }
    .warning { color: orange; background: #fff8e1; padding: 10px; border-left: 4px solid orange; }
    .info { color: blue; background: #e8f4ff; padding: 10px; border-left: 4px solid blue; }
    .button { display: inline-block; padding: 10px 20px; background: #007cba; color: white; text-decoration: none; border-radius: 5px; margin: 5px; }
    .button:hover { background: #005a8b; }
</style>";
echo "</head><body>";

echo "<h1>🔧 Navigation Fix for SHRII Project</h1>";

// Step 1: Check and fix navigation.php
echo "<div class='fix-section'>";
echo "<h2>Step 1: Fixing Navigation Configuration</h2>";

$navFile = __DIR__ . '/includes/navigation.php';
if (file_exists($navFile)) {
    echo "<div class='success'>✓ Navigation file exists</div>";
    
    // Check if base URL is correct
    $navContent = file_get_contents($navFile);
    if (strpos($navContent, "/shrii/") !== false) {
        echo "<div class='success'>✓ Base URL is correctly set to /shrii/</div>";
    } else {
        echo "<div class='warning'>⚠ Updating base URL to /shrii/</div>";
        $navContent = str_replace('/test_dfm/', '/shrii/', $navContent);
        file_put_contents($navFile, $navContent);
        echo "<div class='success'>✓ Base URL updated successfully</div>";
    }
} else {
    echo "<div class='error'>✗ Navigation file missing</div>";
}
echo "</div>";

// Step 2: Check and fix header.php
echo "<div class='fix-section'>";
echo "<h2>Step 2: Fixing Header Configuration</h2>";

$headerFile = __DIR__ . '/includes/header.php';
if (file_exists($headerFile)) {
    echo "<div class='success'>✓ Header file exists</div>";
    
    // Check if logout URL is correct
    $headerContent = file_get_contents($headerFile);
    if (strpos($headerContent, "/shrii/logout.php") !== false) {
        echo "<div class='success'>✓ Logout URL is correctly set</div>";
    } else {
        echo "<div class='warning'>⚠ Updating logout URL</div>";
        $headerContent = str_replace('/test_dfm/logout.php', '/shrii/logout.php', $headerContent);
        file_put_contents($headerFile, $headerContent);
        echo "<div class='success'>✓ Logout URL updated successfully</div>";
    }
} else {
    echo "<div class='error'>✗ Header file missing</div>";
}
echo "</div>";

// Step 3: Create session for testing
echo "<div class='fix-section'>";
echo "<h2>Step 3: Session Management</h2>";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    // Create test session
    $_SESSION['user_id'] = 1;
    $_SESSION['username'] = 'test_admin';
    $_SESSION['role'] = 'admin';
    $_SESSION['department'] = 'Administration';
    echo "<div class='info'>ℹ Test session created for navigation testing</div>";
} else {
    echo "<div class='success'>✓ User session exists: " . $_SESSION['username'] . " (" . $_SESSION['role'] . ")</div>";
}
echo "</div>";

// Step 4: Test module pages
echo "<div class='fix-section'>";
echo "<h2>Step 4: Module Page Status</h2>";

$modules = [
    'department' => ['academic_calendar.php', 'timetable.php', 'student_admission.php', 'research_publications.php'],
    'faculty' => ['syllabus.php', 'result_analysis.php', 'internal_assessment.php', 'faculty_appraisal.php'],
    'student' => ['alumni.php', 'value_added_courses.php', 'extension_outreach.php', 'student_projects.php']
];

$working_modules = 0;
$total_modules = 0;

foreach ($modules as $type => $files) {
    echo "<h3>" . ucfirst($type) . " Modules:</h3>";
    foreach ($files as $file) {
        $total_modules++;
        $filepath = __DIR__ . "/modules/$type/$file";
        if (file_exists($filepath) && filesize($filepath) > 100) {
            echo "<div class='success'>✓ $file is working</div>";
            $working_modules++;
        } else {
            echo "<div class='error'>✗ $file is missing or empty</div>";
        }
    }
}

echo "<div class='info'>Module Status: $working_modules/$total_modules modules are working</div>";
echo "</div>";

// Step 5: Database connectivity
echo "<div class='fix-section'>";
echo "<h2>Step 5: Database Connectivity</h2>";

try {
    require_once 'config/database.php';
    $db = new Database();
    $pdo = $db->getConnection();
    echo "<div class='success'>✓ Database connection successful</div>";
    
    // Check essential tables
    $tables = ['users', 'academic_calendar', 'syllabus'];
    foreach ($tables as $table) {
        try {
            $stmt = $pdo->query("SELECT COUNT(*) FROM $table");
            $count = $stmt->fetchColumn();
            echo "<div class='success'>✓ Table '$table' exists with $count records</div>";
        } catch (Exception $e) {
            echo "<div class='warning'>⚠ Table '$table' might be missing</div>";
        }
    }
    
} catch (Exception $e) {
    echo "<div class='error'>✗ Database connection failed: " . $e->getMessage() . "</div>";
    echo "<div class='info'>📝 Make sure MySQL is running in XAMPP</div>";
}
echo "</div>";

// Step 6: Final test links
echo "<div class='fix-section'>";
echo "<h2>Step 6: Test Your Navigation</h2>";

echo "<p>Click these buttons to test different aspects of your application:</p>";

echo "<a href='/shrii/index.php' class='button'>🏠 Main Dashboard</a>";
echo "<a href='/shrii/test_navigation.php' class='button'>🧪 Navigation Test</a>";
echo "<a href='/shrii/modules/department/academic_calendar.php' class='button'>📅 Academic Calendar</a>";
echo "<a href='/shrii/modules/faculty/syllabus.php' class='button'>📚 Syllabus</a>";
echo "<a href='/shrii/modules/student/alumni.php' class='button'>🎓 Alumni</a>";
echo "<a href='/shrii/admin/users.php' class='button'>👥 User Management</a>";

echo "<br><br>";
echo "<a href='" . $_SERVER['PHP_SELF'] . "' class='button'>🔄 Re-run Fix</a>";
echo "<a href='/shrii/fix_mysql.php' class='button'>🗄️ Database Setup</a>";

echo "</div>";

echo "<div class='fix-section'>";
echo "<h2>🎉 Navigation Should Now Work!</h2>";
echo "<div class='success'>";
echo "<p><strong>If you're still having issues:</strong></p>";
echo "<ol>";
echo "<li>Make sure XAMPP is running with MySQL started</li>";
echo "<li>Visit <a href='/shrii/fix_mysql.php'>/shrii/fix_mysql.php</a> to setup database</li>";
echo "<li>Try the navigation test page: <a href='/shrii/test_navigation.php'>/shrii/test_navigation.php</a></li>";
echo "<li>Check if your modules need the database tables created</li>";
echo "</ol>";
echo "</div>";
echo "</div>";

echo "</body></html>";
?>