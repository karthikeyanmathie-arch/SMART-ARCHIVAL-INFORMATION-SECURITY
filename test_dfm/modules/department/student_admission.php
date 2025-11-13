<?php
require_once '../../includes/auth.php';
require_once '../../config/database.php';
$auth = checkAuth();

$database = new Database();
$db = $database->getConnection();

$message = '';
$messageType = '';

// Handle form submission (guarded) - wrap DB actions so missing tables don't cause fatal errors
if ($_POST) {
    try {
        if (isset($_POST['action'])) {
            if ($_POST['action'] === 'add') {
                $query = "INSERT INTO student_admission (admission_year, student_name, registration_number, course, category, admission_date, documents_path, status, created_by) 
                         VALUES (:admission_year, :student_name, :registration_number, :course, :category, :admission_date, :documents_path, :status, :created_by)";
                
                $stmt = $db->prepare($query);
                $stmt->bindParam(':admission_year', $_POST['admission_year']);
                $stmt->bindParam(':student_name', $_POST['student_name']);
                $stmt->bindParam(':registration_number', $_POST['registration_number']);
                $stmt->bindParam(':course', $_POST['course']);
                $stmt->bindParam(':category', $_POST['category']);
                $stmt->bindParam(':admission_date', $_POST['admission_date']);
                $stmt->bindParam(':status', $_POST['status']);
                
                // Handle file upload
                $documents_path = '';
                if (isset($_FILES['documents']) && $_FILES['documents']['error'] === 0) {
                    $upload_dir = '../../uploads/student_admission/';
                    if (!file_exists($upload_dir)) {
                        mkdir($upload_dir, 0777, true);
                    }
                    $documents_path = $upload_dir . time() . '_' . $_FILES['documents']['name'];
                    move_uploaded_file($_FILES['documents']['tmp_name'], $documents_path);
                }
                
                $stmt->bindParam(':documents_path', $documents_path);
                $stmt->bindParam(':created_by', $_SESSION['user_id']);
                
                if ($stmt->execute()) {
                    $message = 'Student admission record added successfully!';
                    $messageType = 'success';
                } else {
                    $message = 'Error adding student admission record.';
                    $messageType = 'error';
                }
            } elseif ($_POST['action'] === 'delete') {
                $query = "DELETE FROM student_admission WHERE id = :id";
                $stmt = $db->prepare($query);
                $stmt->bindParam(':id', $_POST['id']);
                
                if ($stmt->execute()) {
                    $message = 'Student admission record deleted successfully!';
                    $messageType = 'success';
                } else {
                    $message = 'Error deleting student admission record.';
                    $messageType = 'error';
                }
            }
        }
    } catch (PDOException $e) {
        $messageType = 'error';
        $message = "Database table missing or query error: " . htmlspecialchars($e->getMessage()) .
                   ".<br>Please run the <a href=\"/test_dfm/setup/import_schema.php\">Import Schema</a> tool to create required tables, then refresh this page.";
    }
}

// Fetch all student admission records
$query = "SELECT sa.*, u.username as created_by_name 
          FROM student_admission sa 
          LEFT JOIN users u ON sa.created_by = u.id 
          ORDER BY sa.admission_date DESC";
try {
    $stmt = $db->prepare($query);
    $stmt->execute();
    $admissions = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $admissions = [];
    $messageType = 'error';
    $message = "Database table missing or query error: " . htmlspecialchars($e->getMessage()) . 
               ".<br>Please run the <a href=\"/test_dfm/setup/import_schema.php\">Import Schema</a> tool to create required tables, then refresh this page.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Admission - Department Management</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
    <?php include '../../includes/header.php'; ?>
    <?php include '../../includes/navigation.php'; ?>

    <div class="main-container">
        <h1 class="page-title">Student Admission Management</h1>
        
        <?php if ($message): ?>
            <div class="alert alert-<?php echo $messageType; ?>"><?php echo $message; ?></div>
        <?php endif; ?>

        <!-- Add New Admission Form -->
        <div class="content-card">
            <h2>Add New Student Admission</h2>
            <form method="POST" enctype="multipart/form-data" id="studentAdmissionForm">
                <input type="hidden" name="action" value="add">
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="admission_year" class="form-label">Admission Year *</label>
                        <input type="text" id="admission_year" name="admission_year" class="form-input" 
                               placeholder="e.g., 2023-24" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="student_name" class="form-label">Student Name *</label>
                        <input type="text" id="student_name" name="student_name" class="form-input" 
                               placeholder="Full name of student" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="registration_number" class="form-label">Registration Number *</label>
                        <input type="text" id="registration_number" name="registration_number" class="form-input" 
                               placeholder="Unique registration number" required>
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
                        <label for="category" class="form-label">Category</label>
                        <select id="category" name="category" class="form-select">
                            <option value="">Select Category</option>
                            <option value="General">General</option>
                            <option value="OBC">OBC</option>
                            <option value="SC">SC</option>
                            <option value="ST">ST</option>
                            <option value="EWS">EWS</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="admission_date" class="form-label">Admission Date *</label>
                        <input type="date" id="admission_date" name="admission_date" class="form-input" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="status" class="form-label">Status *</label>
                    <select id="status" name="status" class="form-select" required>
                        <option value="pending">Pending</option>
                        <option value="admitted">Admitted</option>
                        <option value="rejected">Rejected</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="documents" class="form-label">Upload Documents</label>
                    <div class="file-upload">
                        <input type="file" id="documents" name="documents" accept=".pdf,.doc,.docx,.jpg,.png">
                        <label for="documents" class="file-upload-label">Choose file or drag and drop</label>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary">Add Admission Record</button>
                <button type="reset" class="btn btn-secondary">Reset Form</button>
            </form>
        </div>

        <!-- Admissions List -->
        <div class="content-card">
            <h2>Student Admission Records</h2>
            
            <div class="form-group">
                <input type="text" class="form-input table-search" placeholder="Search admission records...">
            </div>
            
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Year</th>
                        <th>Student Name</th>
                        <th>Registration No.</th>
                        <th>Course</th>
                        <th>Category</th>
                        <th>Admission Date</th>
                        <th>Status</th>
                        <th>Documents</th>
                        <th>Created By</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($admissions as $admission): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($admission['admission_year']); ?></td>
                        <td><?php echo htmlspecialchars($admission['student_name']); ?></td>
                        <td><?php echo htmlspecialchars($admission['registration_number']); ?></td>
                        <td><?php echo htmlspecialchars($admission['course']); ?></td>
                        <td><?php echo htmlspecialchars($admission['category']); ?></td>
                        <td><?php echo date('d-m-Y', strtotime($admission['admission_date'])); ?></td>
                        <td>
                            <span class="badge badge-<?php echo $admission['status']; ?>">
                                <?php echo ucfirst($admission['status']); ?>
                            </span>
                        </td>
                        <td>
                            <?php if ($admission['documents_path']): ?>
                                <a href="<?php echo $admission['documents_path']; ?>" target="_blank" class="btn btn-secondary">View</a>
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>
                        <td><?php echo htmlspecialchars($admission['created_by_name']); ?></td>
                        <td>
                            <form method="POST" style="display: inline;">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?php echo $admission['id']; ?>">
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
        // Auto-save form data
        autoSave('studentAdmissionForm');
        
        // Clear auto-save on successful submission
        <?php if ($messageType === 'success'): ?>
        clearAutoSave('studentAdmissionForm');
        <?php endif; ?>
    </script>
    
    <style>
        .badge {
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            font-size: 0.8rem;
            font-weight: 500;
        }
        .badge-pending { background: #ffc107; color: #212529; }
        .badge-admitted { background: #28a745; color: white; }
        .badge-rejected { background: #dc3545; color: white; }
    </style>
</body>
</html>