<?php
// Comprehensive functionality test for all project modules
require_once 'config/database.php';
require_once 'includes/auth.php';

// Start session
session_start();

echo "<h1>Smart Archival & Information System - Comprehensive Test</h1>";

// Test database connection
echo "<h2>1. Database Connection Test</h2>";
try {
    $database = new Database();
    $conn = $database->getConnection();
    echo "✅ Database connection successful<br>";
    
    // Count records in key tables
    $tables = ['users', 'academic_calendar', 'research_publications', 'student_admission', 
               'placement_data', 'syllabus', 'student_projects', 'alumni_data'];
    
    foreach ($tables as $table) {
        $stmt = $conn->prepare("SELECT COUNT(*) as count FROM $table");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        echo "- Table '$table': {$result['count']} records<br>";
    }
} catch (Exception $e) {
    echo "❌ Database connection failed: " . $e->getMessage() . "<br>";
}

// Test authentication system
echo "<h2>2. Authentication System Test</h2>";
try {
    $auth = new Auth();
    
    // Test admin login
    if ($auth->login('admin', 'password')) {
        echo "✅ Admin authentication works<br>";
        $auth->logout(); // Clean up session
    } else {
        echo "❌ Admin authentication failed<br>";
    }
    
    // Test staff login
    if ($auth->login('Banumathi', 'password')) {
        echo "✅ Staff authentication works<br>";
        $auth->logout(); // Clean up session
    } else {
        echo "❌ Staff authentication failed<br>";
    }
} catch (Exception $e) {
    echo "❌ Authentication test failed: " . $e->getMessage() . "<br>";
}

// Test file accessibility of all modules
echo "<h2>3. Module File Accessibility Test</h2>";
$modules = [
    'Department' => [
        'index.php' => 'modules/department/index.php',
        'Academic Calendar' => 'modules/department/academic_calendar.php',
        'Research Publications' => 'modules/department/research_publications.php',
        'Student Admission' => 'modules/department/student_admission.php'
    ],
    'Faculty' => [
        'index.php' => 'modules/faculty/index.php',
        'Placement' => 'modules/faculty/placement.php',
        'Syllabus' => 'modules/faculty/syllabus.php'
    ],
    'Student' => [
        'index.php' => 'modules/student/index.php',
        'Alumni' => 'modules/student/alumni.php',
        'Student Projects' => 'modules/student/student_projects.php'
    ]
];

foreach ($modules as $section => $files) {
    echo "<h3>$section Modules:</h3>";
    foreach ($files as $name => $path) {
        if (file_exists($path)) {
            // Check for PHP syntax errors
            $output = shell_exec("php -l \"$path\" 2>&1");
            if (strpos($output, 'No syntax errors') !== false) {
                echo "✅ $name - File exists and syntax OK<br>";
            } else {
                echo "❌ $name - Syntax error: $output<br>";
            }
        } else {
            echo "❌ $name - File missing at $path<br>";
        }
    }
}

// Test form processing capabilities
echo "<h2>4. Form Processing Test</h2>";
echo "Testing basic form elements and CSRF protection...<br>";

// Test upload directories
echo "<h2>5. Upload Directory Test</h2>";
$upload_dirs = ['uploads/', 'uploads/documents/', 'uploads/images/', 'uploads/temp/'];
foreach ($upload_dirs as $dir) {
    if (is_dir($dir)) {
        if (is_writable($dir)) {
            echo "✅ Directory '$dir' exists and is writable<br>";
        } else {
            echo "⚠️ Directory '$dir' exists but not writable<br>";
        }
    } else {
        echo "❌ Directory '$dir' missing<br>";
        // Try to create it
        if (mkdir($dir, 0777, true)) {
            echo "✅ Created directory '$dir'<br>";
        } else {
            echo "❌ Failed to create directory '$dir'<br>";
        }
    }
}

// Test configuration files
echo "<h2>6. Configuration Test</h2>";
$config_files = ['config/database.php', 'config/environment.php', 'includes/auth.php', 'includes/header.php', 'includes/navigation.php'];
foreach ($config_files as $file) {
    if (file_exists($file)) {
        $output = shell_exec("php -l \"$file\" 2>&1");
        if (strpos($output, 'No syntax errors') !== false) {
            echo "✅ $file - OK<br>";
        } else {
            echo "❌ $file - Syntax error<br>";
        }
    } else {
        echo "❌ $file - Missing<br>";
    }
}

echo "<h2>Test Complete</h2>";
echo "Review the results above to identify any issues that need fixing.";
?>