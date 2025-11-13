<?php
require_once 'config/database.php';
require_once 'includes/auth.php';

echo "Testing User Profile for Banumathi...\n";

$database = new Database();
$conn = $database->getConnection();

// Test Banumathi's profile access
echo "\n1. Testing profile data retrieval:\n";
try {
    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute(['Banumathi']);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user) {
        echo "✅ Profile data found:\n";
        echo "   - ID: {$user['id']}\n";
        echo "   - Username: {$user['username']}\n";
        echo "   - Email: {$user['email']}\n";
        echo "   - Role: {$user['role']}\n";
        echo "   - Department: " . ($user['department'] ?? 'Not Set') . "\n";
        echo "   - Created: {$user['created_at']}\n";
    } else {
        echo "❌ No profile data found\n";
    }
} catch (Exception $e) {
    echo "❌ Error retrieving profile: " . $e->getMessage() . "\n";
}

// Test profile update
echo "\n2. Testing profile update:\n";
try {
    $updateQuery = "UPDATE users SET department = ? WHERE username = ?";
    $stmt = $conn->prepare($updateQuery);
    $newDepartment = "Computer Science with AI (Updated)";
    
    if ($stmt->execute([$newDepartment, 'Banumathi'])) {
        echo "✅ Profile update successful\n";
        
        // Verify update
        $verifyStmt = $conn->prepare("SELECT department FROM users WHERE username = ?");
        $verifyStmt->execute(['Banumathi']);
        $result = $verifyStmt->fetch(PDO::FETCH_ASSOC);
        
        if ($result['department'] === $newDepartment) {
            echo "✅ Update verified: {$result['department']}\n";
            
            // Restore original department
            $restoreStmt = $conn->prepare("UPDATE users SET department = ? WHERE username = ?");
            $restoreStmt->execute(['computer science with Artificial intelligence', 'Banumathi']);
            echo "✅ Original department restored\n";
        } else {
            echo "❌ Update verification failed\n";
        }
    } else {
        echo "❌ Profile update failed\n";
    }
} catch (Exception $e) {
    echo "❌ Error updating profile: " . $e->getMessage() . "\n";
}

// Test password verification
echo "\n3. Testing password functionality:\n";
try {
    $stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
    $stmt->execute(['Banumathi']);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user && password_verify('password', $user['password'])) {
        echo "✅ Password verification works\n";
    } else {
        echo "❌ Password verification failed\n";
    }
} catch (Exception $e) {
    echo "❌ Error testing password: " . $e->getMessage() . "\n";
}

// Test profile page accessibility
echo "\n4. Testing profile page file:\n";
if (file_exists('profile.php')) {
    echo "✅ Profile page file exists\n";
    
    // Check for PHP syntax errors
    $output = shell_exec('C:\\xampp\\php\\php.exe -l "profile.php" 2>&1');
    if (strpos($output, 'No syntax errors') !== false) {
        echo "✅ Profile page has valid PHP syntax\n";
    } else {
        echo "❌ Profile page has syntax errors: $output\n";
    }
} else {
    echo "❌ Profile page file not found\n";
}

echo "\nProfile testing completed!\n";
?>