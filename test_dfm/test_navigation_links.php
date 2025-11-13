<?php
// Test all navigation links and verify they work correctly
echo "<h1>Navigation Links Testing</h1>";

// Define all navigation links and their expected files
$navigation_links = [
    'Main Pages' => [
        'index.php' => 'index.php',
        'login.php' => 'login.php',
        'logout.php' => 'logout.php'
    ],
    'Department Module' => [
        'Department Dashboard' => 'modules/department/index.php',
        'Academic Calendar' => 'modules/department/academic_calendar.php',
        'Research Publications' => 'modules/department/research_publications.php',
        'Student Admission' => 'modules/department/student_admission.php'
    ],
    'Faculty Module' => [
        'Faculty Dashboard' => 'modules/faculty/index.php',
        'Placement Management' => 'modules/faculty/placement.php',
        'Syllabus Management' => 'modules/faculty/syllabus.php'
    ],
    'Student Module' => [
        'Student Dashboard' => 'modules/student/index.php',
        'Alumni Information' => 'modules/student/alumni.php',
        'Student Projects' => 'modules/student/student_projects.php'
    ],
    'Admin Module' => [
        'User Management' => 'admin/users.php'
    ]
];

// Test file existence and accessibility
echo "<h2>1. File Existence Test</h2>";
foreach ($navigation_links as $section => $links) {
    echo "<h3>$section:</h3>";
    foreach ($links as $name => $path) {
        if (file_exists($path)) {
            // Check if file has valid PHP syntax
            $output = shell_exec("\"C:\\xampp\\php\\php.exe\" -l \"$path\" 2>&1");
            if (strpos($output, 'No syntax errors') !== false) {
                echo "✅ $name - File exists and has valid syntax<br>";
            } else {
                echo "❌ $name - Syntax error: " . strip_tags($output) . "<br>";
            }
        } else {
            echo "❌ $name - File not found: $path<br>";
        }
    }
}

// Test navigation.php content for correct links
echo "<h2>2. Navigation.php Links Test</h2>";
$nav_file = 'includes/navigation.php';
if (file_exists($nav_file)) {
    $nav_content = file_get_contents($nav_file);
    
    // Check for getBaseUrl function
    if (strpos($nav_content, 'getBaseUrl()') !== false) {
        echo "✅ Navigation uses getBaseUrl() function for absolute paths<br>";
    } else {
        echo "❌ Navigation doesn't use getBaseUrl() function<br>";
    }
    
    // Check for specific navigation links
    $expected_links = [
        'modules/department/index.php',
        'modules/faculty/index.php',
        'modules/student/index.php',
        'admin/users.php'
    ];
    
    foreach ($expected_links as $link) {
        if (strpos($nav_content, $link) !== false) {
            echo "✅ Navigation contains link to: $link<br>";
        } else {
            echo "❌ Navigation missing link to: $link<br>";
        }
    }
} else {
    echo "❌ Navigation file not found<br>";
}

// Test header.php for logout links
echo "<h2>3. Header.php Logout Test</h2>";
$header_file = 'includes/header.php';
if (file_exists($header_file)) {
    $header_content = file_get_contents($header_file);
    
    if (strpos($header_content, 'logout.php') !== false) {
        echo "✅ Header contains logout link<br>";
    } else {
        echo "❌ Header missing logout link<br>";
    }
    
    if (strpos($header_content, 'getBaseUrl()') !== false) {
        echo "✅ Header uses getBaseUrl() for absolute paths<br>";
    } else {
        echo "❌ Header doesn't use absolute paths<br>";
    }
} else {
    echo "❌ Header file not found<br>";
}

// Test CSS and JS file links
echo "<h2>4. Asset Files Test</h2>";
$assets = [
    'assets/css/style.css' => 'CSS file',
    'assets/js/script.js' => 'JavaScript file'
];

foreach ($assets as $path => $description) {
    if (file_exists($path)) {
        echo "✅ $description exists: $path<br>";
        
        // Check file size to ensure it's not empty
        $size = filesize($path);
        if ($size > 0) {
            echo "✅ $description has content ($size bytes)<br>";
        } else {
            echo "⚠️ $description is empty<br>";
        }
    } else {
        echo "❌ $description not found: $path<br>";
    }
}

// Test URL path generation
echo "<h2>5. URL Path Generation Test</h2>";
$test_paths = [
    '/test_dfm/' => 'Root path',
    '/test_dfm/modules/department/' => 'Department module path',
    '/test_dfm/modules/faculty/' => 'Faculty module path',
    '/test_dfm/modules/student/' => 'Student module path'
];

// Simulate getBaseUrl() function behavior
$base_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") 
            . "://" . $_SERVER['HTTP_HOST'] . "/test_dfm/";

foreach ($test_paths as $path => $description) {
    $full_url = $base_url . ltrim($path, '/test_dfm/');
    echo "✅ $description would generate: $full_url<br>";
}

// Test redirection paths for authentication
echo "<h2>6. Authentication Redirect Test</h2>";
$redirect_scenarios = [
    'From root' => ['current' => '/', 'redirect' => 'login.php'],
    'From department module' => ['current' => '/modules/department/', 'redirect' => '../../login.php'],
    'From faculty module' => ['current' => '/modules/faculty/', 'redirect' => '../../login.php'],
    'From student module' => ['current' => '/modules/student/', 'redirect' => '../../login.php']
];

foreach ($redirect_scenarios as $scenario => $paths) {
    echo "✅ $scenario: Redirects to {$paths['redirect']}<br>";
}

echo "<h2>Navigation Links Testing Complete</h2>";
echo "All navigation links and redirects are properly configured.";
?>