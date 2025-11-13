<?php
require_once '../includes/auth.php';
require_once '../config/database.php';
$auth = checkAuth();

// Check if user is admin
if (!$auth->hasRole('admin')) {
    header("Location: ../index.php");
    exit();
}

$database = new Database();
$db = $database->getConnection();

$message = '';
$messageType = '';

// Handle form submission
if ($_POST) {
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'add') {
            // Check if username already exists
            $checkQuery = "SELECT id FROM users WHERE username = :username OR email = :email";
            $checkStmt = $db->prepare($checkQuery);
            $checkStmt->bindParam(':username', $_POST['username']);
            $checkStmt->bindParam(':email', $_POST['email']);
            $checkStmt->execute();
            
            if ($checkStmt->rowCount() > 0) {
                $message = 'Username or email already exists!';
                $messageType = 'error';
            } else {
                $query = "INSERT INTO users (username, password, email, role, department) 
                         VALUES (:username, :password, :email, :role, :department)";
                
                $stmt = $db->prepare($query);
                $stmt->bindParam(':username', $_POST['username']);
                $hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
                $stmt->bindParam(':password', $hashedPassword);
                $stmt->bindParam(':email', $_POST['email']);
                $stmt->bindParam(':role', $_POST['role']);
                $stmt->bindParam(':department', $_POST['department']);
                
                if ($stmt->execute()) {
                    $message = 'User added successfully!';
                    $messageType = 'success';
                } else {
                    $message = 'Error adding user.';
                    $messageType = 'error';
                }
            }
        } elseif ($_POST['action'] === 'delete') {
            // Prevent deleting own account
            if ($_POST['id'] == $_SESSION['user_id']) {
                $message = 'You cannot delete your own account!';
                $messageType = 'error';
            } else {
                $query = "DELETE FROM users WHERE id = :id";
                $stmt = $db->prepare($query);
                $stmt->bindParam(':id', $_POST['id']);
                
                if ($stmt->execute()) {
                    $message = 'User deleted successfully!';
                    $messageType = 'success';
                } else {
                    $message = 'Error deleting user.';
                    $messageType = 'error';
                }
            }
        }
    }
}

// Fetch all users
$query = "SELECT * FROM users ORDER BY created_at DESC";
$stmt = $db->prepare($query);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management - Admin Panel</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <?php include '../includes/navigation.php'; ?>

    <div class="main-container">
        <h1 class="page-title">User Management</h1>
        
        <?php if ($message): ?>
            <div class="alert alert-<?php echo $messageType; ?>"><?php echo $message; ?></div>
        <?php endif; ?>

        <!-- Add New User Form -->
        <div class="content-card">
            <h2>Add New User</h2>
            <form method="POST" id="userForm">
                <input type="hidden" name="action" value="add">
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="username" class="form-label">Username *</label>
                        <input type="text" id="username" name="username" class="form-input" 
                               placeholder="Unique username" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="email" class="form-label">Email *</label>
                        <input type="email" id="email" name="email" class="form-input" 
                               placeholder="Email address" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="password" class="form-label">Password *</label>
                        <input type="password" id="password" name="password" class="form-input" 
                               placeholder="Password (min 6 characters)" required minlength="6">
                    </div>
                    
                    <div class="form-group">
                        <label for="role" class="form-label">Role *</label>
                        <select id="role" name="role" class="form-select" required>
                            <option value="">Select Role</option>
                            <option value="admin">Admin</option>
                            <option value="faculty">Faculty</option>
                            <option value="staff">Staff</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="department" class="form-label">Department</label>
                    <input type="text" id="department" name="department" class="form-input" 
                           placeholder="Department name">
                </div>
                
                <button type="submit" class="btn btn-primary">Add User</button>
                <button type="reset" class="btn btn-secondary">Reset Form</button>
            </form>
        </div>

        <!-- Users List -->
        <div class="content-card">
            <h2>System Users</h2>
            
            <div class="form-group">
                <input type="text" class="form-input table-search" placeholder="Search users...">
            </div>
            
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Department</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo $user['id']; ?></td>
                        <td><?php echo htmlspecialchars($user['username']); ?></td>
                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                        <td>
                            <span class="badge badge-<?php echo $user['role']; ?>">
                                <?php echo ucfirst($user['role']); ?>
                            </span>
                        </td>
                        <td><?php echo htmlspecialchars($user['department']); ?></td>
                        <td><?php echo date('d-m-Y H:i', strtotime($user['created_at'])); ?></td>
                        <td>
                            <?php if ($user['id'] != $_SESSION['user_id']): ?>
                                <form method="POST" style="display: inline;">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            <?php else: ?>
                                <span class="text-muted">Current User</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="../assets/js/script.js"></script>
    <script>
        autoSave('userForm');
        <?php if ($messageType === 'success'): ?>
        clearAutoSave('userForm');
        <?php endif; ?>
    </script>
    
    <style>
        .badge-admin { background: #dc3545; color: white; }
        .badge-faculty { background: #007bff; color: white; }
        .badge-staff { background: #28a745; color: white; }
        .text-muted { color: #6c757d; }
    </style>
</body>
</html>