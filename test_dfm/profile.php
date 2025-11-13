<?php
require_once 'includes/auth.php';
require_once 'config/database.php';
$auth = checkAuth();

$database = new Database();
$db = $database->getConnection();

$message = '';
$messageType = '';

// Handle form submission for profile update
if ($_POST && isset($_POST['action']) && $_POST['action'] === 'update_profile') {
    try {
        // Update user profile
        $query = "UPDATE users SET email = :email, department = :department WHERE id = :user_id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':email', $_POST['email']);
        $stmt->bindParam(':department', $_POST['department']);
        $stmt->bindParam(':user_id', $_SESSION['user_id']);
        
        if ($stmt->execute()) {
            // Update session data
            $_SESSION['department'] = $_POST['department'];
            $message = 'Profile updated successfully!';
            $messageType = 'success';
        } else {
            $message = 'Error updating profile.';
            $messageType = 'error';
        }
    } catch (Exception $e) {
        $message = 'Error: ' . $e->getMessage();
        $messageType = 'error';
    }
}

// Handle password change
if ($_POST && isset($_POST['action']) && $_POST['action'] === 'change_password') {
    try {
        // Verify current password
        $query = "SELECT password FROM users WHERE id = :user_id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':user_id', $_SESSION['user_id']);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user && password_verify($_POST['current_password'], $user['password'])) {
            if ($_POST['new_password'] === $_POST['confirm_password']) {
                // Update password
                $hashedPassword = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
                $query = "UPDATE users SET password = :password WHERE id = :user_id";
                $stmt = $db->prepare($query);
                $stmt->bindParam(':password', $hashedPassword);
                $stmt->bindParam(':user_id', $_SESSION['user_id']);
                
                if ($stmt->execute()) {
                    $message = 'Password changed successfully!';
                    $messageType = 'success';
                } else {
                    $message = 'Error changing password.';
                    $messageType = 'error';
                }
            } else {
                $message = 'New passwords do not match.';
                $messageType = 'error';
            }
        } else {
            $message = 'Current password is incorrect.';
            $messageType = 'error';
        }
    } catch (Exception $e) {
        $message = 'Error: ' . $e->getMessage();
        $messageType = 'error';
    }
}

// Get current user data
$query = "SELECT * FROM users WHERE id = :user_id";
$stmt = $db->prepare($query);
$stmt->bindParam(':user_id', $_SESSION['user_id']);
$stmt->execute();
$currentUser = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile - Department Management</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    <?php include 'includes/navigation.php'; ?>

    <div class="main-container">
        <h1 class="page-title">User Profile</h1>
        
        <?php if ($message): ?>
            <div class="alert alert-<?php echo $messageType; ?>"><?php echo $message; ?></div>
        <?php endif; ?>

        <div class="content-grid">
            <!-- Profile Information -->
            <div class="content-card">
                <h2>Profile Information</h2>
                <form method="POST" id="profileForm">
                    <input type="hidden" name="action" value="update_profile">
                    
                    <div class="form-group">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" id="username" name="username" class="form-control" 
                               value="<?php echo htmlspecialchars($currentUser['username']); ?>" readonly>
                        <small class="form-text">Username cannot be changed</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="email" class="form-label">Email *</label>
                        <input type="email" id="email" name="email" class="form-control" 
                               value="<?php echo htmlspecialchars($currentUser['email']); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="role" class="form-label">Role</label>
                        <input type="text" id="role" name="role" class="form-control" 
                               value="<?php echo htmlspecialchars(ucfirst($currentUser['role'])); ?>" readonly>
                        <small class="form-text">Role can only be changed by an administrator</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="department" class="form-label">Department</label>
                        <input type="text" id="department" name="department" class="form-control" 
                               value="<?php echo htmlspecialchars($currentUser['department'] ?? ''); ?>" 
                               placeholder="Enter your department">
                    </div>
                    
                    <div class="form-group">
                        <label for="created_at" class="form-label">Account Created</label>
                        <input type="text" id="created_at" name="created_at" class="form-control" 
                               value="<?php echo date('F j, Y', strtotime($currentUser['created_at'])); ?>" readonly>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Update Profile</button>
                </form>
            </div>

            <!-- Change Password -->
            <div class="content-card">
                <h2>Change Password</h2>
                <form method="POST" id="passwordForm">
                    <input type="hidden" name="action" value="change_password">
                    
                    <div class="form-group">
                        <label for="current_password" class="form-label">Current Password *</label>
                        <input type="password" id="current_password" name="current_password" 
                               class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="new_password" class="form-label">New Password *</label>
                        <input type="password" id="new_password" name="new_password" 
                               class="form-control" required minlength="8">
                        <small class="form-text">Password must be at least 8 characters long</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="confirm_password" class="form-label">Confirm New Password *</label>
                        <input type="password" id="confirm_password" name="confirm_password" 
                               class="form-control" required minlength="8">
                    </div>
                    
                    <button type="submit" class="btn btn-secondary">Change Password</button>
                </form>
            </div>
        </div>

        <!-- Activity Summary -->
        <div class="content-card">
            <h2>Account Summary</h2>
            <div class="info-grid">
                <div class="info-item">
                    <strong>Username:</strong> <?php echo htmlspecialchars($currentUser['username']); ?>
                </div>
                <div class="info-item">
                    <strong>Role:</strong> <?php echo htmlspecialchars(ucfirst($currentUser['role'])); ?>
                </div>
                <div class="info-item">
                    <strong>Department:</strong> <?php echo htmlspecialchars($currentUser['department'] ?? 'Not specified'); ?>
                </div>
                <div class="info-item">
                    <strong>Email:</strong> <?php echo htmlspecialchars($currentUser['email']); ?>
                </div>
                <div class="info-item">
                    <strong>Account Status:</strong> <span class="status-active">Active</span>
                </div>
                <div class="info-item">
                    <strong>Member Since:</strong> <?php echo date('F j, Y', strtotime($currentUser['created_at'])); ?>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Password confirmation validation
        document.getElementById('passwordForm').addEventListener('submit', function(e) {
            const newPassword = document.getElementById('new_password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            
            if (newPassword !== confirmPassword) {
                e.preventDefault();
                alert('New passwords do not match. Please try again.');
                return false;
            }
            
            if (newPassword.length < 8) {
                e.preventDefault();
                alert('Password must be at least 8 characters long.');
                return false;
            }
        });

        // Profile form validation
        document.getElementById('profileForm').addEventListener('submit', function(e) {
            const email = document.getElementById('email').value;
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            
            if (!emailRegex.test(email)) {
                e.preventDefault();
                alert('Please enter a valid email address.');
                return false;
            }
        });
    </script>
</body>
</html>