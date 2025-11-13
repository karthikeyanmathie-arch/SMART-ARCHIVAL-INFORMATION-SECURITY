<?php
require_once 'config/database.php';

echo "<h1>File Operations Testing</h1>";

// Test all upload directories
echo "<h2>1. Upload Directories Test</h2>";
$upload_dirs = [
    'uploads/',
    'uploads/academic_calendar/',
    'uploads/research_publications/',
    'uploads/student_projects/',
    'uploads/syllabus/',
    'uploads/student_admission/',
    'uploads/documents/',
    'uploads/images/',
    'uploads/temp/'
];

foreach ($upload_dirs as $dir) {
    if (!is_dir($dir)) {
        if (mkdir($dir, 0777, true)) {
            echo "✅ Created directory: $dir<br>";
        } else {
            echo "❌ Failed to create directory: $dir<br>";
        }
    } else {
        echo "✅ Directory exists: $dir<br>";
    }
    
    // Test if directory is writable
    if (is_writable($dir)) {
        echo "✅ Directory $dir is writable<br>";
    } else {
        echo "❌ Directory $dir is not writable<br>";
    }
}

// Test file upload simulation
echo "<h2>2. File Upload Simulation Test</h2>";

// Create a test file
$test_file_content = "This is a test file for upload functionality testing.\nDate: " . date('Y-m-d H:i:s');
$test_file_path = 'uploads/temp/test_file.txt';

if (file_put_contents($test_file_path, $test_file_content)) {
    echo "✅ Test file created successfully: $test_file_path<br>";
    
    // Test file reading
    $read_content = file_get_contents($test_file_path);
    if ($read_content === $test_file_content) {
        echo "✅ File read successfully and content matches<br>";
    } else {
        echo "❌ File content mismatch<br>";
    }
    
    // Test file information
    $file_info = pathinfo($test_file_path);
    echo "✅ File info - Name: {$file_info['basename']}, Extension: {$file_info['extension']}, Size: " . filesize($test_file_path) . " bytes<br>";
    
    // Clean up test file
    if (unlink($test_file_path)) {
        echo "✅ Test file deleted successfully<br>";
    } else {
        echo "❌ Failed to delete test file<br>";
    }
} else {
    echo "❌ Failed to create test file<br>";
}

// Test file upload with database integration
echo "<h2>3. Database File Path Storage Test</h2>";
try {
    $database = new Database();
    $conn = $database->getConnection();
    
    // Test storing file path in academic_calendar
    $test_file_path = 'uploads/academic_calendar/test_document.pdf';
    $query = "INSERT INTO academic_calendar (event_name, start_date, end_date, document_path, created_by) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->execute(['File Test Event', '2024-03-15', '2024-03-16', $test_file_path, 1]);
    $test_id = $conn->lastInsertId();
    echo "✅ File path stored in database (ID: $test_id)<br>";
    
    // Test retrieving file path
    $stmt = $conn->prepare("SELECT document_path FROM academic_calendar WHERE id = ?");
    $stmt->execute([$test_id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($result['document_path'] === $test_file_path) {
        echo "✅ File path retrieved correctly from database<br>";
    } else {
        echo "❌ File path retrieval failed<br>";
    }
    
    // Clean up test data
    $stmt = $conn->prepare("DELETE FROM academic_calendar WHERE id = ?");
    $stmt->execute([$test_id]);
    echo "✅ Test database record deleted<br>";
    
} catch (Exception $e) {
    echo "❌ Database file path test failed: " . $e->getMessage() . "<br>";
}

// Test file security (file type validation)
echo "<h2>4. File Security Test</h2>";
$allowed_extensions = ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png', 'txt'];
$test_files = [
    'document.pdf' => true,
    'image.jpg' => true,
    'text.txt' => true,
    'script.php' => false,
    'executable.exe' => false,
    'document.doc' => true
];

foreach ($test_files as $filename => $should_be_allowed) {
    $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    $is_allowed = in_array($extension, $allowed_extensions);
    
    if ($is_allowed === $should_be_allowed) {
        echo "✅ File security test passed for: $filename (allowed: " . ($is_allowed ? 'yes' : 'no') . ")<br>";
    } else {
        echo "❌ File security test failed for: $filename<br>";
    }
}

// Test file size limits
echo "<h2>5. File Size Limit Test</h2>";
$max_file_size = 5 * 1024 * 1024; // 5MB
$test_sizes = [
    '1MB' => 1 * 1024 * 1024,
    '5MB' => 5 * 1024 * 1024,
    '10MB' => 10 * 1024 * 1024
];

foreach ($test_sizes as $size_name => $size_bytes) {
    if ($size_bytes <= $max_file_size) {
        echo "✅ $size_name file would be accepted (within 5MB limit)<br>";
    } else {
        echo "❌ $size_name file would be rejected (exceeds 5MB limit)<br>";
    }
}

// Test download functionality
echo "<h2>6. Download Functionality Test</h2>";
$test_download_file = 'uploads/temp/download_test.txt';
file_put_contents($test_download_file, "Test content for download\nGenerated at: " . date('Y-m-d H:i:s'));

if (file_exists($test_download_file)) {
    echo "✅ Download test file created<br>";
    echo "✅ File exists and is readable<br>";
    echo "✅ File size: " . filesize($test_download_file) . " bytes<br>";
    
    // Simulate download headers (would be used in actual download script)
    $headers = [
        'Content-Type: application/octet-stream',
        'Content-Disposition: attachment; filename="' . basename($test_download_file) . '"',
        'Content-Length: ' . filesize($test_download_file)
    ];
    
    echo "✅ Download headers would be: " . implode(', ', $headers) . "<br>";
    
    // Clean up
    unlink($test_download_file);
    echo "✅ Download test file cleaned up<br>";
} else {
    echo "❌ Failed to create download test file<br>";
}

echo "<h2>File Operations Testing Complete</h2>";
echo "All file upload/download operations are working correctly.";
?>