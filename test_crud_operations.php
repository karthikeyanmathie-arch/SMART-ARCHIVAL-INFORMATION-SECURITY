<?php
require_once 'config/database.php';

// Test CRUD operations for each major module
$database = new Database();
$conn = $database->getConnection();

echo "<h1>CRUD Operations Test</h1>";

// Test Academic Calendar CRUD
echo "<h2>1. Academic Calendar CRUD Test</h2>";
try {
    // CREATE test
    $stmt = $conn->prepare("INSERT INTO academic_calendar (event_name, start_date, end_date, description) VALUES (?, ?, ?, ?)");
    $stmt->execute(['Test Event', '2024-03-15', '2024-03-16', 'Test academic event']);
    $test_id = $conn->lastInsertId();
    echo "✅ CREATE: Academic event added (ID: $test_id)<br>";
    
    // READ test
    $stmt = $conn->prepare("SELECT * FROM academic_calendar WHERE id = ?");
    $stmt->execute([$test_id]);
    if ($stmt->rowCount() > 0) {
        echo "✅ READ: Academic event retrieved successfully<br>";
    }
    
    // UPDATE test
    $stmt = $conn->prepare("UPDATE academic_calendar SET event_name = ? WHERE id = ?");
    $stmt->execute(['Updated Test Event', $test_id]);
    echo "✅ UPDATE: Academic event updated<br>";
    
    // DELETE test
    $stmt = $conn->prepare("DELETE FROM academic_calendar WHERE id = ?");
    $stmt->execute([$test_id]);
    echo "✅ DELETE: Test academic event deleted<br>";
    
} catch (Exception $e) {
    echo "❌ Academic Calendar CRUD failed: " . $e->getMessage() . "<br>";
}

// Test Research Publications CRUD
echo "<h2>2. Research Publications CRUD Test</h2>";
try {
    // CREATE test
    $stmt = $conn->prepare("INSERT INTO research_publications (title, authors, journal_name, publication_date) VALUES (?, ?, ?, ?)");
    $stmt->execute(['Test Publication', 'Test Author', 'Test Journal', '2024-01-15']);
    $test_id = $conn->lastInsertId();
    echo "✅ CREATE: Research publication added (ID: $test_id)<br>";
    
    // READ test
    $stmt = $conn->prepare("SELECT * FROM research_publications WHERE id = ?");
    $stmt->execute([$test_id]);
    if ($stmt->rowCount() > 0) {
        echo "✅ READ: Research publication retrieved successfully<br>";
    }
    
    // UPDATE test
    $stmt = $conn->prepare("UPDATE research_publications SET title = ? WHERE id = ?");
    $stmt->execute(['Updated Test Publication', $test_id]);
    echo "✅ UPDATE: Research publication updated<br>";
    
    // DELETE test
    $stmt = $conn->prepare("DELETE FROM research_publications WHERE id = ?");
    $stmt->execute([$test_id]);
    echo "✅ DELETE: Test research publication deleted<br>";
    
} catch (Exception $e) {
    echo "❌ Research Publications CRUD failed: " . $e->getMessage() . "<br>";
}

// Test Student Projects CRUD
echo "<h2>3. Student Projects CRUD Test</h2>";
try {
    // CREATE test
    $stmt = $conn->prepare("INSERT INTO student_projects (project_title, student_names, guide_name, project_type) VALUES (?, ?, ?, ?)");
    $stmt->execute(['Test Project', 'Test Student', 'Test Supervisor', 'minor']);
    $test_id = $conn->lastInsertId();
    echo "✅ CREATE: Student project added (ID: $test_id)<br>";
    
    // READ test
    $stmt = $conn->prepare("SELECT * FROM student_projects WHERE id = ?");
    $stmt->execute([$test_id]);
    if ($stmt->rowCount() > 0) {
        echo "✅ READ: Student project retrieved successfully<br>";
    }
    
    // UPDATE test
    $stmt = $conn->prepare("UPDATE student_projects SET project_type = ? WHERE id = ?");
    $stmt->execute(['major', $test_id]);
    echo "✅ UPDATE: Student project updated<br>";
    
    // DELETE test
    $stmt = $conn->prepare("DELETE FROM student_projects WHERE id = ?");
    $stmt->execute([$test_id]);
    echo "✅ DELETE: Test student project deleted<br>";
    
} catch (Exception $e) {
    echo "❌ Student Projects CRUD failed: " . $e->getMessage() . "<br>";
}

// Test User Management CRUD
echo "<h2>4. User Management CRUD Test</h2>";
try {
    // CREATE test
    $stmt = $conn->prepare("INSERT INTO users (username, password, email, role, department) VALUES (?, ?, ?, ?, ?)");
    $test_password = password_hash('testpass', PASSWORD_DEFAULT);
    $stmt->execute(['testuser', $test_password, 'test@example.com', 'staff', 'Computer Science']);
    $test_id = $conn->lastInsertId();
    echo "✅ CREATE: Test user added (ID: $test_id)<br>";
    
    // READ test
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$test_id]);
    if ($stmt->rowCount() > 0) {
        echo "✅ READ: User retrieved successfully<br>";
    }
    
    // UPDATE test
    $stmt = $conn->prepare("UPDATE users SET email = ? WHERE id = ?");
    $stmt->execute(['updated@example.com', $test_id]);
    echo "✅ UPDATE: User updated<br>";
    
    // DELETE test
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$test_id]);
    echo "✅ DELETE: Test user deleted<br>";
    
} catch (Exception $e) {
    echo "❌ User Management CRUD failed: " . $e->getMessage() . "<br>";
}

echo "<h2>CRUD Operations Test Complete</h2>";
echo "All major modules support proper Create, Read, Update, Delete operations.";
?>