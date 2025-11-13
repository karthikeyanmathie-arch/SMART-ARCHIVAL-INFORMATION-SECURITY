<?php
require_once '../../includes/auth.php';
require_once '../../config/database.php';
$auth = checkAuth();

$database = new Database();
$db = $database->getConnection();

$message = '';
$messageType = '';

// Handle form submission
if ($_POST) {
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'add') {
            $query = "INSERT INTO alumni_details (student_name, registration_number, graduation_year, course, current_organization, current_position, contact_email, contact_phone, address, achievements, document_path, created_by) 
                     VALUES (:student_name, :registration_number, :graduation_year, :course, :current_organization, :current_position, :contact_email, :contact_phone, :address, :achievements, :document_path, :created_by)";
            
            $stmt = $db->prepare($query);
            $stmt->bindParam(':student_name', $_POST['student_name']);
            $stmt->bindParam(':registration_number', $_POST['registration_number']);
            $stmt->bindParam(':graduation_year', $_POST['graduation_year']);
            $stmt->bindParam(':course', $_POST['course']);
            $stmt->bindParam(':current_organization', $_POST['current_organization']);
            $stmt->bindParam(':current_position', $_POST['current_position']);
            $stmt->bindParam(':contact_email', $_POST['contact_email']);
            $stmt->bindParam(':contact_phone', $_POST['contact_phone']);
            $stmt->bindParam(':address', $_POST['address']);
            $stmt->bindParam(':achievements', $_POST['achievements']);
            
            // Handle file upload
            $document_path = '';
            if (isset($_FILES['document']) && $_FILES['document']['error'] === 0) {
                $upload_dir = '../../uploads/alumni/';
                if (!file_exists($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }
                $document_path = $upload_dir . time() . '_' . $_FILES['document']['name'];
                move_uploaded_file($_FILES['document']['tmp_name'], $document_path);
            }
            
            $stmt->bindParam(':document_path', $document_path);
            $stmt->bindParam(':created_by', $_SESSION['user_id']);
            
            if ($stmt->execute()) {
                $message = 'Alumni record added successfully!';
                $messageType = 'success';
            } else {
                $message = 'Error adding alumni record.';
                $messageType = 'error';
            }
        } elseif ($_POST['action'] === 'delete') {
            $query = "DELETE FROM alumni_details WHERE id = :id";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':id', $_POST['id']);
            
            if ($stmt->execute()) {
                $message = 'Alumni record deleted successfully!';
                $messageType = 'success';
            } else {
                $message = 'Error deleting alumni record.';
                $messageType = 'error';
            }
        }
    }
}

// Fetch all alumni records
$query = "SELECT ad.*, u.username as created_by_name 
          FROM alumni_details ad 
          LEFT JOIN users u ON ad.created_by = u.id 
          ORDER BY ad.graduation_year DESC, ad.student_name";
$stmt = $db->prepare($query);
$stmt->execute();
$alumni = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alumni Management - Smart Archival & Information System</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
    <?php include '../../includes/header.php'; ?>
    <?php include '../../includes/navigation.php'; ?>

    <div class="main-container">
        <h1 class="page-title">Alumni Management</h1>
        
        <?php if ($message): ?>
            <div class="alert alert-<?php echo $messageType; ?>"><?php echo $message; ?></div>
        <?php endif; ?>

        <!-- Add New Alumni Form -->
        <div class="content-card">
            <h2>Add New Alumni Record</h2>
            <form method="POST" enctype="multipart/form-data" id="alumniForm">
                <input type="hidden" name="action" value="add">
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="student_name" class="form-label">Student Name *</label>
                        <input type="text" id="student_name" name="student_name" class="form-input" 
                               placeholder="Full name of alumni" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="registration_number" class="form-label">Registration Number *</label>
                        <input type="text" id="registration_number" name="registration_number" class="form-input" 
                               placeholder="Student registration number" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="graduation_year" class="form-label">Graduation Year *</label>
                        <input type="text" id="graduation_year" name="graduation_year" class="form-input" 
                               placeholder="e.g., 2023" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="course" class="form-label">Course *</label>
                        <select id="course" name="course" class="form-select" required>
                            <option value="">Select Course</option>
                            <option value="B.Tech Computer Science">B.Tech Computer Science</option>
                            <option value="B.Tech Electronics">B.Tech Electronics</option>
                            <option value="B.Tech Mechanical">B.Tech Mechanical</option>
                            <option value="B.Tech Civil">B.Tech Civil</option>
                            <option value="M.Tech Computer Science">M.Tech Computer Science</option>
                            <option value="MBA">MBA</option>
                            <option value="MCA">MCA</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="current_organization" class="form-label">Current Organization</label>
                        <input type="text" id="current_organization" name="current_organization" class="form-input" 
                               placeholder="Current workplace">
                    </div>
                    
                    <div class="form-group">
                        <label for="current_position" class="form-label">Current Position</label>
                        <input type="text" id="current_position" name="current_position" class="form-input" 
                               placeholder="Job title/position">
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="contact_email" class="form-label">Contact Email</label>
                        <input type="email" id="contact_email" name="contact_email" class="form-input" 
                               placeholder="Email address">
                    </div>
                    
                    <div class="form-group">
                        <label for="contact_phone" class="form-label">Contact Phone</label>
                        <input type="tel" id="contact_phone" name="contact_phone" class="form-input" 
                               placeholder="Phone number">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="address" class="form-label">Address</label>
                    <textarea id="address" name="address" class="form-textarea" 
                              placeholder="Current address"></textarea>
                </div>
                
                <div class="form-group">
                    <label for="achievements" class="form-label">Achievements</label>
                    <textarea id="achievements" name="achievements" class="form-textarea" 
                              placeholder="Notable achievements, awards, recognitions"></textarea>
                </div>
                
                <div class="form-group">
                    <label for="document" class="form-label">Upload Document</label>
                    <div class="file-upload">
                        <input type="file" id="document" name="document" accept=".pdf,.doc,.docx,.jpg,.png">
                        <label for="document" class="file-upload-label">Choose file or drag and drop</label>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary">Add Alumni Record</button>
                <button type="reset" class="btn btn-secondary">Reset Form</button>
            </form>
        </div>

        <!-- Alumni List -->
        <div class="content-card">
            <h2>Alumni Records</h2>
            
            <div class="form-group">
                <input type="text" class="form-input table-search" placeholder="Search alumni...">
            </div>
            
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Registration No.</th>
                        <th>Graduation Year</th>
                        <th>Course</th>
                        <th>Current Organization</th>
                        <th>Position</th>
                        <th>Contact Email</th>
                        <th>Phone</th>
                        <th>Document</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($alumni as $alumnus): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($alumnus['student_name']); ?></td>
                        <td><?php echo htmlspecialchars($alumnus['registration_number']); ?></td>
                        <td><?php echo htmlspecialchars($alumnus['graduation_year']); ?></td>
                        <td><?php echo htmlspecialchars($alumnus['course']); ?></td>
                        <td><?php echo htmlspecialchars($alumnus['current_organization']); ?></td>
                        <td><?php echo htmlspecialchars($alumnus['current_position']); ?></td>
                        <td><?php echo htmlspecialchars($alumnus['contact_email']); ?></td>
                        <td><?php echo htmlspecialchars($alumnus['contact_phone']); ?></td>
                        <td>
                            <?php if ($alumnus['document_path']): ?>
                                <a href="<?php echo $alumnus['document_path']; ?>" target="_blank" class="btn btn-secondary">View</a>
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>
                        <td>
                            <form method="POST" style="display: inline;">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?php echo $alumnus['id']; ?>">
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="../../assets/js/script.js"></script>
    <script>
        autoSave('alumniForm');
        <?php if ($messageType === 'success'): ?>
        clearAutoSave('alumniForm');
        <?php endif; ?>
    </script>
</body>
</html>