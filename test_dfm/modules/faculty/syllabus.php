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
            $query = "INSERT INTO syllabus (academic_year, semester, course, subject, syllabus_content, document_path, approved_by, approval_date, created_by) 
                     VALUES (:academic_year, :semester, :course, :subject, :syllabus_content, :document_path, :approved_by, :approval_date, :created_by)";
            
            $stmt = $db->prepare($query);
            $stmt->bindParam(':academic_year', $_POST['academic_year']);
            $stmt->bindParam(':semester', $_POST['semester']);
            $stmt->bindParam(':course', $_POST['course']);
            $stmt->bindParam(':subject', $_POST['subject']);
            $stmt->bindParam(':syllabus_content', $_POST['syllabus_content']);
            $stmt->bindParam(':approved_by', $_POST['approved_by']);
            $stmt->bindParam(':approval_date', $_POST['approval_date']);
            
            // Handle file upload
            $document_path = '';
            if (isset($_FILES['document']) && $_FILES['document']['error'] === 0) {
                $upload_dir = '../../uploads/syllabus/';
                if (!file_exists($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }
                $document_path = $upload_dir . time() . '_' . $_FILES['document']['name'];
                move_uploaded_file($_FILES['document']['tmp_name'], $document_path);
            }
            
            $stmt->bindParam(':document_path', $document_path);
            $stmt->bindParam(':created_by', $_SESSION['user_id']);
            
            if ($stmt->execute()) {
                $message = 'Syllabus added successfully!';
                $messageType = 'success';
            } else {
                $message = 'Error adding syllabus.';
                $messageType = 'error';
            }
        } elseif ($_POST['action'] === 'delete') {
            $query = "DELETE FROM syllabus WHERE id = :id";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':id', $_POST['id']);
            
            if ($stmt->execute()) {
                $message = 'Syllabus deleted successfully!';
                $messageType = 'success';
            } else {
                $message = 'Error deleting syllabus.';
                $messageType = 'error';
            }
        }
    }
}

// Fetch all syllabus records
$query = "SELECT s.*, u.username as created_by_name 
          FROM syllabus s 
          LEFT JOIN users u ON s.created_by = u.id 
          ORDER BY s.academic_year DESC, s.semester, s.course, s.subject";
$stmt = $db->prepare($query);
$stmt->execute();
$syllabi = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Syllabus Management - Smart Archival & Information System</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
    <?php include '../../includes/header.php'; ?>
    <?php include '../../includes/navigation.php'; ?>

    <div class="main-container">
        <h1 class="page-title">Syllabus Management</h1>
        
        <?php if ($message): ?>
            <div class="alert alert-<?php echo $messageType; ?>"><?php echo $message; ?></div>
        <?php endif; ?>

        <!-- Add New Syllabus Form -->
        <div class="content-card">
            <h2>Add New Syllabus</h2>
            <form method="POST" enctype="multipart/form-data" id="syllabusForm">
                <input type="hidden" name="action" value="add">
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="academic_year" class="form-label">Academic Year *</label>
                        <input type="text" id="academic_year" name="academic_year" class="form-input" 
                               placeholder="e.g., 2023-24" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="semester" class="form-label">Semester *</label>
                        <select id="semester" name="semester" class="form-select" required>
                            <option value="">Select Semester</option>
                            <option value="1">Semester 1</option>
                            <option value="2">Semester 2</option>
                            <option value="3">Semester 3</option>
                            <option value="4">Semester 4</option>
                            <option value="5">Semester 5</option>
                            <option value="6">Semester 6</option>
                            <option value="7">Semester 7</option>
                            <option value="8">Semester 8</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-row">
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
                    
                    <div class="form-group">
                        <label for="subject" class="form-label">Subject *</label>
                        <input type="text" id="subject" name="subject" class="form-input" 
                               placeholder="Subject name" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="syllabus_content" class="form-label">Syllabus Content</label>
                    <textarea id="syllabus_content" name="syllabus_content" class="form-textarea" 
                              placeholder="Detailed syllabus content, topics, and learning outcomes" rows="6"></textarea>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="approved_by" class="form-label">Approved By</label>
                        <input type="text" id="approved_by" name="approved_by" class="form-input" 
                               placeholder="Name of approving authority">
                    </div>
                    
                    <div class="form-group">
                        <label for="approval_date" class="form-label">Approval Date</label>
                        <input type="date" id="approval_date" name="approval_date" class="form-input">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="document" class="form-label">Upload Syllabus Document</label>
                    <div class="file-upload">
                        <input type="file" id="document" name="document" accept=".pdf,.doc,.docx">
                        <label for="document" class="file-upload-label">Choose file or drag and drop</label>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary">Add Syllabus</button>
                <button type="reset" class="btn btn-secondary">Reset Form</button>
            </form>
        </div>

        <!-- Syllabus List -->
        <div class="content-card">
            <h2>Syllabus Records</h2>
            
            <div class="form-group">
                <input type="text" class="form-input table-search" placeholder="Search syllabus...">
            </div>
            
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Academic Year</th>
                        <th>Semester</th>
                        <th>Course</th>
                        <th>Subject</th>
                        <th>Content Preview</th>
                        <th>Approved By</th>
                        <th>Approval Date</th>
                        <th>Document</th>
                        <th>Created By</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($syllabi as $syllabus): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($syllabus['academic_year']); ?></td>
                        <td><?php echo htmlspecialchars($syllabus['semester']); ?></td>
                        <td><?php echo htmlspecialchars($syllabus['course']); ?></td>
                        <td><?php echo htmlspecialchars($syllabus['subject']); ?></td>
                        <td><?php echo htmlspecialchars(substr($syllabus['syllabus_content'], 0, 50)) . (strlen($syllabus['syllabus_content']) > 50 ? '...' : ''); ?></td>
                        <td><?php echo htmlspecialchars($syllabus['approved_by']); ?></td>
                        <td><?php echo $syllabus['approval_date'] ? date('d-m-Y', strtotime($syllabus['approval_date'])) : '-'; ?></td>
                        <td>
                            <?php if ($syllabus['document_path']): ?>
                                <a href="<?php echo $syllabus['document_path']; ?>" target="_blank" class="btn btn-secondary">View</a>
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>
                        <td><?php echo htmlspecialchars($syllabus['created_by_name']); ?></td>
                        <td>
                            <form method="POST" style="display: inline;">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?php echo $syllabus['id']; ?>">
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
        autoSave('syllabusForm');
        <?php if ($messageType === 'success'): ?>
        clearAutoSave('syllabusForm');
        <?php endif; ?>
    </script>
</body>
</html>