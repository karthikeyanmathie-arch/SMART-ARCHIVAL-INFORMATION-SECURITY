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
                    // handle avatar upload after insert
                    $newUserId = $db->lastInsertId();
                    $uploaded = false;

                    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] !== UPLOAD_ERR_NO_FILE) {
                        $avatar = $_FILES['avatar'];
                        if ($avatar['error'] === UPLOAD_ERR_OK) {
                            $allowed = [
                                'image/png' => 'png',
                                'image/jpeg' => 'jpg',
                                'image/jpg' => 'jpg',
                                'image/gif' => 'gif',
                                'image/webp' => 'webp'
                            ];
                            $finfo = finfo_open(FILEINFO_MIME_TYPE);
                            $mime = finfo_file($finfo, $avatar['tmp_name']);
                            finfo_close($finfo);

                            if (array_key_exists($mime, $allowed) && $avatar['size'] <= 2 * 1024 * 1024) {
                                $ext = $allowed[$mime];
                                $uploadDir = __DIR__ . '/../uploads/users';
                                if (!is_dir($uploadDir)) {
                                    mkdir($uploadDir, 0755, true);
                                }
                                $dest = $uploadDir . '/' . $newUserId . '.' . $ext;

                                // Remove old avatars if any
                                foreach ($allowed as $e) {
                                    $maybe = $uploadDir . '/' . $newUserId . '.' . $e;
                                    if (file_exists($maybe) && $maybe !== $dest) @unlink($maybe);
                                }

                                if (move_uploaded_file($avatar['tmp_name'], $dest)) {
                                    $uploaded = true;
                                }
                            } else {
                                $message = 'Avatar must be PNG/JPG/GIF/WebP and under 2MB.';
                                $messageType = 'warning';
                            }
                        }
                    }

                    $message = 'User added successfully!';
                    if ($uploaded) $message .= ' Avatar uploaded.';
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
                    // remove avatar files if present
                    $uploadDir = __DIR__ . '/../uploads/users';
                    $extensions = ['png','jpg','jpeg','gif','webp'];
                    foreach ($extensions as $ext) {
                        $file = $uploadDir . '/' . intval($_POST['id']) . '.' . $ext;
                        if (file_exists($file)) @unlink($file);
                    }

                    $message = 'User deleted successfully!';
                    $messageType = 'success';
                } else {
                    $message = 'Error deleting user.';
                    $messageType = 'error';
                }
            }
        }
        elseif ($_POST['action'] === 'allow_reset') {
            // Create password_resets table if not exists
            try {
                $createSql = "CREATE TABLE IF NOT EXISTS password_resets (
                    id INT PRIMARY KEY AUTO_INCREMENT,
                    user_id INT NOT NULL,
                    token VARCHAR(128) NOT NULL,
                    expires_at DATETIME NOT NULL,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
                $db->exec($createSql);

                $userId = intval($_POST['id']);
                $token = bin2hex(random_bytes(16));
                $expiresAt = date('Y-m-d H:i:s', time() + 60 * 60 * 24); // 24 hours

                // remove previous tokens for user
                $del = $db->prepare("DELETE FROM password_resets WHERE user_id = :uid");
                $del->bindParam(':uid', $userId);
                $del->execute();

                $ins = $db->prepare("INSERT INTO password_resets (user_id, token, expires_at) VALUES (:uid, :token, :expires)");
                $ins->bindParam(':uid', $userId);
                $ins->bindParam(':token', $token);
                $ins->bindParam(':expires', $expiresAt);
                $ins->execute();

                $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
                $host = $_SERVER['HTTP_HOST'];
                $resetUrl = $protocol . '://' . $host . '/test_dfm/reset_password.php?token=' . $token;

                $message = 'Password reset link generated. Share this link with the user: <a href="' . htmlspecialchars($resetUrl) . '" target="_blank">' . htmlspecialchars($resetUrl) . '</a> (expires in 24 hours)';
                $messageType = 'success';
            } catch (Exception $e) {
                $message = 'Error generating reset link: ' . $e->getMessage();
                $messageType = 'error';
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
    <link rel="icon" type="image/jpeg" href="/test_dfm/assets/images/college_logo.jpg">
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
            <form method="POST" id="userForm" enctype="multipart/form-data">
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

                <div class="form-group">
                    <label for="avatar" class="form-label">Profile Picture</label>
                    <input type="file" id="avatar" name="avatar" accept="image/*" class="form-input">
                    <small class="form-text">Optional. PNG/JPG/GIF/WebP. Max 2MB.</small>
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
                        <td>
                            <?php
                                // determine avatar for this user (uploads/users/{id}.{ext}) or fallback initial SVG
                                $avatarSrc = '';
                                $docRoot = rtrim($_SERVER['DOCUMENT_ROOT'], "\\/");
                                $extensions = ['png','jpg','jpeg','webp','gif'];
                                foreach ($extensions as $ext) {
                                    $possible = $docRoot . '/test_dfm/uploads/users/' . $user['id'] . '.' . $ext;
                                    if (file_exists($possible)) {
                                        $avatarSrc = '/test_dfm/uploads/users/' . $user['id'] . '.' . $ext;
                                        break;
                                    }
                                }
                                if (!$avatarSrc) {
                                    $initial = strtoupper(substr($user['username'],0,1));
                                    $svg = '<svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24"><rect fill="#374151" width="24" height="24" rx="3"/><text x="50%" y="50%" fill="#ffffff" dy=".35em" font-family="Poppins, Arial, sans-serif" font-size="10" text-anchor="middle">'.htmlspecialchars($initial).'</text></svg>';
                                    $avatarSrc = 'data:image/svg+xml;utf8,'.rawurlencode($svg);
                                }
                            ?>
                            <img src="<?php echo $avatarSrc; ?>" alt="" class="avatar-sm"> <?php echo htmlspecialchars($user['username']); ?>
                        </td>
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
                                    <form method="POST" style="display: inline; margin-right:6px;">
                                        <input type="hidden" name="action" value="allow_reset">
                                        <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                                        <button type="submit" class="btn btn-secondary">Generate Reset Link</button>
                                    </form>
                                    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" style="display: inline;">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this user? This cannot be undone.')">Delete</button>
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