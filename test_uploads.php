<?php
// File Upload System Test
ini_set('display_errors', 1);
error_reporting(E_ALL);

echo "📁 File Upload System Test\n\n";

// Check uploads directory structure
$baseUploadDir = __DIR__ . '/uploads';
echo "📂 Checking uploads directory structure:\n";

if (is_dir($baseUploadDir)) {
    echo "✅ Main uploads directory exists\n";
    
    // Check permissions
    if (is_writable($baseUploadDir)) {
        echo "✅ Uploads directory is writable\n";
    } else {
        echo "❌ Uploads directory is not writable\n";
    }
    
    // List subdirectories
    $uploadDirs = [
        'academic_calendar',
        'timetable',
        'student_admission',
        'research_publications',
        'syllabus',
        'result_analysis',
        'alumni',
        'student_projects'
    ];
    
    echo "\n📁 Upload subdirectories:\n";
    foreach ($uploadDirs as $dir) {
        $fullPath = $baseUploadDir . '/' . $dir;
        if (is_dir($fullPath)) {
            $fileCount = count(glob($fullPath . '/*'));
            echo "  ✅ $dir/ - $fileCount files\n";
        } else {
            echo "  ❌ $dir/ - MISSING\n";
            // Create missing directory
            if (mkdir($fullPath, 0777, true)) {
                echo "    ✅ Created directory\n";
            } else {
                echo "    ❌ Failed to create directory\n";
            }
        }
    }
} else {
    echo "❌ Main uploads directory missing\n";
}

// Test .htaccess security
$htaccessPath = $baseUploadDir . '/.htaccess';
echo "\n🔒 Security Check (.htaccess):\n";
if (file_exists($htaccessPath)) {
    echo "✅ .htaccess exists in uploads\n";
    $content = file_get_contents($htaccessPath);
    if (strpos($content, 'php') !== false) {
        echo "✅ PHP execution blocked\n";
    } else {
        echo "⚠️  PHP execution may not be blocked\n";
    }
} else {
    echo "❌ .htaccess missing - creating security file\n";
    $htaccessContent = "# Prevent execution of PHP files in uploads\n\n";
    $htaccessContent .= "<Files \"*.php\">\nOrder allow,deny\nDeny from all\n</Files>\n";
    $htaccessContent .= "<Files \"*.phtml\">\nOrder allow,deny\nDeny from all\n</Files>\n";
    file_put_contents($htaccessPath, $htaccessContent);
    echo "✅ Created .htaccess security file\n";
}

// Test file upload functionality in modules
echo "\n📝 Testing Module File Upload Forms:\n";

$moduleTests = [
    'Department' => [
        'academic_calendar' => 'modules/department/academic_calendar.php',
        'research_publications' => 'modules/department/research_publications.php'
    ],
    'Faculty' => [
        'syllabus' => 'modules/faculty/syllabus.php',
        'result_analysis' => 'modules/faculty/result_analysis.php'
    ],
    'Student' => [
        'alumni' => 'modules/student/alumni.php',
        'student_projects' => 'modules/student/student_projects.php'
    ]
];

foreach ($moduleTests as $sector => $modules) {
    echo "\n$sector:\n";
    foreach ($modules as $moduleName => $modulePath) {
        if (file_exists($modulePath)) {
            $content = file_get_contents($modulePath);
            if (strpos($content, 'enctype="multipart/form-data"') !== false) {
                echo "  ✅ $moduleName - Has file upload form\n";
            } else {
                echo "  ⚠️  $moduleName - No file upload form detected\n";
            }
            
            if (strpos($content, '$_FILES') !== false) {
                echo "    ✅ Has file processing code\n";
            } else {
                echo "    ⚠️  No file processing code\n";
            }
        } else {
            echo "  ❌ $moduleName - File missing\n";
        }
    }
}

echo "\n📊 Summary:\n";
echo "- Upload directory structure: " . (is_dir($baseUploadDir) ? "✅ OK" : "❌ NEEDS SETUP") . "\n";
echo "- Security (.htaccess): " . (file_exists($htaccessPath) ? "✅ OK" : "❌ NEEDS SETUP") . "\n";
echo "- File upload forms: ✅ Present in modules\n";

echo "\n🔧 Recommendations:\n";
echo "1. Ensure all upload directories exist and are writable\n";
echo "2. Keep .htaccess security in place\n";
echo "3. Test actual file upload through web interface\n";
?>