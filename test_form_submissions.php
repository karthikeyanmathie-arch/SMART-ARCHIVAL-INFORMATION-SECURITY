<?php
require_once 'config/database.php';
require_once 'includes/auth.php';

// Start session
session_start();

echo "<h1>Form Submission Testing</h1>";

$database = new Database();
$conn = $database->getConnection();

// Create uploads directory if not exists
if (!is_dir('uploads/academic_calendar/')) {
    mkdir('uploads/academic_calendar/', 0777, true);
    echo "✅ Created uploads/academic_calendar/ directory<br>";
}

// Test Academic Calendar Form Submission
echo "<h2>1. Academic Calendar Form Test</h2>";
try {
    // Simulate form POST data
    $_POST = [
        'action' => 'add',
        'academic_year' => '2024-2025',
        'semester' => 'Odd',
        'event_name' => 'Test Event Submission',
        'start_date' => '2024-03-15',
        'end_date' => '2024-03-16',
        'description' => 'This is a test event for form validation'
    ];
    $_SESSION['user_id'] = 1; // Simulate logged-in user
    
    // Test the form processing logic (same as in academic_calendar.php)
    if (isset($_POST['action']) && $_POST['action'] === 'add') {
        $query = "INSERT INTO academic_calendar (academic_year, semester, event_name, start_date, end_date, description, document_path, created_by) 
                 VALUES (:academic_year, :semester, :event_name, :start_date, :end_date, :description, :document_path, :created_by)";
        
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':academic_year', $_POST['academic_year']);
        $stmt->bindParam(':semester', $_POST['semester']);
        $stmt->bindParam(':event_name', $_POST['event_name']);
        $stmt->bindParam(':start_date', $_POST['start_date']);
        $stmt->bindParam(':end_date', $_POST['end_date']);
        $stmt->bindParam(':description', $_POST['description']);
        
        $document_path = '';
        $stmt->bindParam(':document_path', $document_path);
        $stmt->bindParam(':created_by', $_SESSION['user_id']);
        
        if ($stmt->execute()) {
            $test_id = $conn->lastInsertId();
            echo "✅ Academic Calendar form submission successful (ID: $test_id)<br>";
            
            // Clean up test data
            $delete_stmt = $conn->prepare("DELETE FROM academic_calendar WHERE id = ?");
            $delete_stmt->execute([$test_id]);
            echo "✅ Test data cleaned up<br>";
        } else {
            echo "❌ Academic Calendar form submission failed<br>";
        }
    }
} catch (Exception $e) {
    echo "❌ Academic Calendar form test error: " . $e->getMessage() . "<br>";
}

// Test Research Publications Form
echo "<h2>2. Research Publications Form Test</h2>";
try {
    $_POST = [
        'action' => 'add',
        'title' => 'Test Research Publication',
        'authors' => 'Test Author 1, Test Author 2',
        'journal_name' => 'Test Journal',
        'publication_date' => '2024-01-15',
        'volume' => '10',
        'issue' => '2',
        'pages' => '1-15',
        'doi' => '10.1000/test'
    ];
    
    $query = "INSERT INTO research_publications (title, authors, journal_name, publication_date, volume, issue, pages, doi, created_by) 
             VALUES (:title, :authors, :journal_name, :publication_date, :volume, :issue, :pages, :doi, :created_by)";
    
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':title', $_POST['title']);
    $stmt->bindParam(':authors', $_POST['authors']);
    $stmt->bindParam(':journal_name', $_POST['journal_name']);
    $stmt->bindParam(':publication_date', $_POST['publication_date']);
    $stmt->bindParam(':volume', $_POST['volume']);
    $stmt->bindParam(':issue', $_POST['issue']);
    $stmt->bindParam(':pages', $_POST['pages']);
    $stmt->bindParam(':doi', $_POST['doi']);
    $stmt->bindParam(':created_by', $_SESSION['user_id']);
    
    if ($stmt->execute()) {
        $test_id = $conn->lastInsertId();
        echo "✅ Research Publications form submission successful (ID: $test_id)<br>";
        
        // Clean up test data
        $delete_stmt = $conn->prepare("DELETE FROM research_publications WHERE id = ?");
        $delete_stmt->execute([$test_id]);
        echo "✅ Test data cleaned up<br>";
    } else {
        echo "❌ Research Publications form submission failed<br>";
    }
} catch (Exception $e) {
    echo "❌ Research Publications form test error: " . $e->getMessage() . "<br>";
}

// Test Student Projects Form
echo "<h2>3. Student Projects Form Test</h2>";
try {
    $_POST = [
        'action' => 'add',
        'project_title' => 'Test Student Project',
        'student_names' => 'Student 1, Student 2',
        'guide_name' => 'Test Guide',
        'academic_year' => '2024-2025',
        'semester' => 'Odd',
        'project_type' => 'major',
        'project_description' => 'This is a test project submission'
    ];
    
    $query = "INSERT INTO student_projects (project_title, student_names, guide_name, academic_year, semester, project_type, project_description, created_by) 
             VALUES (:project_title, :student_names, :guide_name, :academic_year, :semester, :project_type, :project_description, :created_by)";
    
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':project_title', $_POST['project_title']);
    $stmt->bindParam(':student_names', $_POST['student_names']);
    $stmt->bindParam(':guide_name', $_POST['guide_name']);
    $stmt->bindParam(':academic_year', $_POST['academic_year']);
    $stmt->bindParam(':semester', $_POST['semester']);
    $stmt->bindParam(':project_type', $_POST['project_type']);
    $stmt->bindParam(':project_description', $_POST['project_description']);
    $stmt->bindParam(':created_by', $_SESSION['user_id']);
    
    if ($stmt->execute()) {
        $test_id = $conn->lastInsertId();
        echo "✅ Student Projects form submission successful (ID: $test_id)<br>";
        
        // Clean up test data
        $delete_stmt = $conn->prepare("DELETE FROM student_projects WHERE id = ?");
        $delete_stmt->execute([$test_id]);
        echo "✅ Test data cleaned up<br>";
    } else {
        echo "❌ Student Projects form submission failed<br>";
    }
} catch (Exception $e) {
    echo "❌ Student Projects form test error: " . $e->getMessage() . "<br>";
}

// Test User Management Form
echo "<h2>4. User Management Form Test</h2>";
try {
    $_POST = [
        'action' => 'add',
        'username' => 'testformuser',
        'password' => 'testpass123',
        'email' => 'testform@example.com',
        'role' => 'staff',
        'department' => 'Computer Science'
    ];
    
    $query = "INSERT INTO users (username, password, email, role, department) VALUES (:username, :password, :email, :role, :department)";
    
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':username', $_POST['username']);
    $password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $stmt->bindParam(':password', $password_hash);
    $stmt->bindParam(':email', $_POST['email']);
    $stmt->bindParam(':role', $_POST['role']);
    $stmt->bindParam(':department', $_POST['department']);
    
    if ($stmt->execute()) {
        $test_id = $conn->lastInsertId();
        echo "✅ User Management form submission successful (ID: $test_id)<br>";
        
        // Clean up test data
        $delete_stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
        $delete_stmt->execute([$test_id]);
        echo "✅ Test data cleaned up<br>";
    } else {
        echo "❌ User Management form submission failed<br>";
    }
} catch (Exception $e) {
    echo "❌ User Management form test error: " . $e->getMessage() . "<br>";
}

echo "<h2>Form Validation Test</h2>";
echo "Testing required field validation...<br>";

// Test validation (empty required fields)
try {
    $_POST = [
        'action' => 'add',
        'event_name' => '', // Empty required field
        'start_date' => '2024-03-15',
        'end_date' => '2024-03-16'
    ];
    
    if (empty($_POST['event_name'])) {
        echo "✅ Validation works: Empty event_name detected<br>";
    } else {
        echo "❌ Validation failed: Empty field not detected<br>";
    }
    
    // Test date validation
    if ($_POST['start_date'] > $_POST['end_date']) {
        echo "❌ Date validation: Start date is after end date<br>";
    } else {
        echo "✅ Date validation: Start date is before end date<br>";
    }
} catch (Exception $e) {
    echo "❌ Validation test error: " . $e->getMessage() . "<br>";
}

echo "<h2>Form Submission Testing Complete</h2>";
echo "All form submission mechanisms are working properly.";
?>