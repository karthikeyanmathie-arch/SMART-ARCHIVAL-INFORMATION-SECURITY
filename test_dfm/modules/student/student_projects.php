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
            $query = "INSERT INTO student_projects (project_title, student_names, guide_name, academic_year, semester, project_type, project_description, document_path, created_by) 
                     VALUES (:project_title, :student_names, :guide_name, :academic_year, :semester, :project_type, :project_description, :document_path, :created_by)";
            
            $stmt = $db->prepare($query);
            $stmt->bindParam(':project_title', $_POST['project_title']);
            $stmt->bindParam(':student_names', $_POST['student_names']);
            $stmt->bindParam(':guide_name', $_POST['guide_name']);
            $stmt->bindParam(':academic_year', $_POST['academic_year']);
            $stmt->bindParam(':semester', $_POST['semester']);
            $stmt->bindParam(':project_type', $_POST['project_type']);
            $stmt->bindParam(':project_description', $_POST['project_description']);
            
            // Handle file upload
            $document_path = '';
            if (isset($_FILES['document']) && $_FILES['document']['error'] === 0) {
                $upload_dir = '../../uploads/student_projects/';
                if (!file_exists($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }
                $document_path = $upload_dir . time() . '_' . $_FILES['document']['name'];
                move_uploaded_file($_FILES['document']['tmp_name'], $document_path);
            }
            
            $stmt->bindParam(':document_path', $document_path);
            $stmt->bindParam(':created_by', $_SESSION['user_id']);
            
            if ($stmt->execute()) {
                $message = 'Student project added successfully!';
                $messageType = 'success';
            } else {
                $message = 'Error adding student project.';
                $messageType = 'error';
            }
        } elseif ($_POST['action'] === 'delete') {
            $query = "DELETE FROM student_projects WHERE id = :id";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':id', $_POST['id']);
            
            if ($stmt->execute()) {
                $message = 'Student project deleted successfully!';
                $messageType = 'success';
            } else {
                $message = 'Error deleting student project.';
                $messageType = 'error';
            }
        }
    }
}

// Fetch all student projects
$query = "SELECT sp.*, u.username as created_by_name 
          FROM student_projects sp 
          LEFT JOIN users u ON sp.created_by = u.id 
          ORDER BY sp.academic_year DESC, sp.semester DESC";
$stmt = $db->prepare($query);
$stmt->execute();
$projects = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Projects</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
    <?php include '../../includes/header.php'; ?>
    <?php include '../../includes/navigation.php'; ?>

    <div class="main-container">
        <h1 class="page-title">Student Projects Management</h1>
        
        <?php if ($message): ?>
            <div class="alert alert-<?php echo $messageType; ?>"><?php echo $message; ?></div>
        <?php endif; ?>

        <!-- Add New Project Form -->
        <div class="content-card">
            <h2>Add New Student Project</h2>
            <form method="POST" enctype="multipart/form-data" id="studentProjectForm">
                <input type="hidden" name="action" value="add">
                
                <div class="form-group">
                    <label for="project_title" class="form-label">Project Title *</label>
                    <input type="text" id="project_title" name="project_title" class="form-input" 
                           placeholder="Complete project title" required>
                </div>
                
                <div class="form-group">
                    <label for="student_names" class="form-label">Student Names *</label>
                    <textarea id="student_names" name="student_names" class="form-textarea" 
                              placeholder="List all student names (comma separated)" required></textarea>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="guide_name" class="form-label">Guide Name *</label>
                        <input type="text" id="guide_name" name="guide_name" class="form-input" 
                               placeholder="Project guide/supervisor name" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="project_type" class="form-label">Project Type *</label>
                        <select id="project_type" name="project_type" class="form-select" required>
                            <option value="">Select Project Type</option>
                            <option value="minor">Minor Project</option>
                            <option value="major">Major Project</option>
                            <option value="research">Research Project</option>
                        </select>
                    </div>
                </div>
                
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
                
                <div class="form-group">
                    <label for="project_description" class="form-label">Project Description</label>
                    <textarea id="project_description" name="project_description" class="form-textarea" 
                              placeholder="Detailed project description, objectives, and outcomes" rows="5"></textarea>
                </div>
                
                <div class="form-group">
                    <label for="document" class="form-label">Upload Project Document</label>
                    <div class="file-upload">
                        <input type="file" id="document" name="document" accept=".pdf,.doc,.docx">
                        <label for="document" class="file-upload-label">Choose file or drag and drop</label>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary">Add Project</button>
                <button type="reset" class="btn btn-secondary">Reset Form</button>
            </form>
        </div>

        <!-- Projects List -->
        <div class="content-card">
            <h2>Student Projects</h2>
            
            <div class="form-group">
                <input type="text" class="form-input table-search" placeholder="Search projects...">
            </div>
            
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Project Title</th>
                        <th>Students</th>
                        <th>Guide</th>
                        <th>Type</th>
                        <th>Academic Year</th>
                        <th>Semester</th>
                        <th>Description</th>
                        <th>Document</th>
                        <th>Created By</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($projects as $project): ?>
                    <tr>
                        <td><?php echo htmlspecialchars(substr($project['project_title'], 0, 40)) . (strlen($project['project_title']) > 40 ? '...' : ''); ?></td>
                        <td><?php echo htmlspecialchars(substr($project['student_names'], 0, 30)) . (strlen($project['student_names']) > 30 ? '...' : ''); ?></td>
                        <td><?php echo htmlspecialchars($project['guide_name']); ?></td>
                        <td>
                            <span class="badge badge-<?php echo $project['project_type']; ?>">
                                <?php echo ucfirst($project['project_type']); ?>
                            </span>
                        </td>
                        <td><?php echo htmlspecialchars($project['academic_year']); ?></td>
                        <td><?php echo htmlspecialchars($project['semester']); ?></td>
                        <td><?php echo htmlspecialchars(substr($project['project_description'], 0, 50)) . (strlen($project['project_description']) > 50 ? '...' : ''); ?></td>
                        <td>
                            <?php if ($project['document_path']): ?>
                                <a href="<?php echo $project['document_path']; ?>" target="_blank" class="btn btn-secondary">View</a>
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>
                        <td><?php echo htmlspecialchars($project['created_by_name']); ?></td>
                        <td>
                            <form method="POST" style="display: inline;">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?php echo $project['id']; ?>">
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
        autoSave('studentProjectForm');
        <?php if ($messageType === 'success'): ?>
        clearAutoSave('studentProjectForm');
        <?php endif; ?>
    </script>
    
    <style>
        .badge-minor { background: #17a2b8; color: white; }
        .badge-major { background: #28a745; color: white; }
        .badge-research { background: #6f42c1; color: white; }
    </style>
</body>
</html>