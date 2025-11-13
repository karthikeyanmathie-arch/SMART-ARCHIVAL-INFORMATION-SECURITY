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
            $query = "INSERT INTO placement_files (student_name, registration_number, company_name, position, package_offered, placement_date, academic_year, document_path, created_by) 
                     VALUES (:student_name, :registration_number, :company_name, :position, :package_offered, :placement_date, :academic_year, :document_path, :created_by)";
            
            $stmt = $db->prepare($query);
            $stmt->bindParam(':student_name', $_POST['student_name']);
            $stmt->bindParam(':registration_number', $_POST['registration_number']);
            $stmt->bindParam(':company_name', $_POST['company_name']);
            $stmt->bindParam(':position', $_POST['position']);
            $stmt->bindParam(':package_offered', $_POST['package_offered']);
            $stmt->bindParam(':placement_date', $_POST['placement_date']);
            $stmt->bindParam(':academic_year', $_POST['academic_year']);
            
            // Handle file upload
            $document_path = '';
            if (isset($_FILES['document']) && $_FILES['document']['error'] === 0) {
                $upload_dir = '../../uploads/placement/';
                if (!file_exists($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }
                $document_path = $upload_dir . time() . '_' . $_FILES['document']['name'];
                move_uploaded_file($_FILES['document']['tmp_name'], $document_path);
            }
            
            $stmt->bindParam(':document_path', $document_path);
            $stmt->bindParam(':created_by', $_SESSION['user_id']);
            
            if ($stmt->execute()) {
                $message = 'Placement record added successfully!';
                $messageType = 'success';
            } else {
                $message = 'Error adding placement record.';
                $messageType = 'error';
            }
        } elseif ($_POST['action'] === 'delete') {
            $query = "DELETE FROM placement_files WHERE id = :id";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':id', $_POST['id']);
            
            if ($stmt->execute()) {
                $message = 'Placement record deleted successfully!';
                $messageType = 'success';
            } else {
                $message = 'Error deleting placement record.';
                $messageType = 'error';
            }
        }
    }
}

// Fetch all placement records
$query = "SELECT pf.*, u.username as created_by_name 
          FROM placement_files pf 
          LEFT JOIN users u ON pf.created_by = u.id 
          ORDER BY pf.placement_date DESC";
$stmt = $db->prepare($query);
$stmt->execute();
$placements = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Placement Management - Smart Archival & Information System</title>
    <link rel="icon" type="image/jpeg" href="/test_dfm/assets/images/college_logo.jpg">
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
    <?php include '../../includes/header.php'; ?>
    <?php include '../../includes/navigation.php'; ?>

    <div class="main-container">
        <h1 class="page-title">Placement Management</h1>
        
        <?php if ($message): ?>
            <div class="alert alert-<?php echo $messageType; ?>"><?php echo $message; ?></div>
        <?php endif; ?>

        <!-- Add New Placement Form -->
        <div class="content-card">
            <h2>Add New Placement Record</h2>
            <form method="POST" enctype="multipart/form-data" id="placementForm">
                <input type="hidden" name="action" value="add">
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="student_name" class="form-label">Student Name *</label>
                        <input type="text" id="student_name" name="student_name" class="form-input" 
                               placeholder="Full name of student" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="registration_number" class="form-label">Registration Number *</label>
                        <input type="text" id="registration_number" name="registration_number" class="form-input" 
                               placeholder="Student registration number" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="company_name" class="form-label">Company Name *</label>
                        <input type="text" id="company_name" name="company_name" class="form-input" 
                               placeholder="Name of the company" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="position" class="form-label">Position *</label>
                        <input type="text" id="position" name="position" class="form-input" 
                               placeholder="Job position/role" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="package_offered" class="form-label">Package Offered (LPA)</label>
                        <input type="number" id="package_offered" name="package_offered" class="form-input" 
                               placeholder="Annual package in lakhs" step="0.01" min="0">
                    </div>
                    
                    <div class="form-group">
                        <label for="placement_date" class="form-label">Placement Date *</label>
                        <input type="date" id="placement_date" name="placement_date" class="form-input" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="academic_year" class="form-label">Academic Year *</label>
                    <input type="text" id="academic_year" name="academic_year" class="form-input" 
                           placeholder="e.g., 2023-24" required>
                </div>
                
                <div class="form-group">
                    <label for="document" class="form-label">Upload Document</label>
                    <div class="file-upload">
                        <input type="file" id="document" name="document" accept=".pdf,.doc,.docx,.jpg,.png">
                        <label for="document" class="file-upload-label">Choose file or drag and drop</label>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary">Add Placement Record</button>
                <button type="reset" class="btn btn-secondary">Reset Form</button>
            </form>
        </div>

        <!-- Placement Statistics -->
        <div class="content-card">
            <h2>Placement Statistics</h2>
            <div class="dashboard-grid">
                <?php
                // Calculate statistics
                $totalPlacements = count($placements);
                $currentYear = date('Y');
                $currentYearPlacements = array_filter($placements, function($p) use ($currentYear) {
                    return strpos($p['academic_year'], $currentYear) !== false;
                });
                $avgPackage = 0;
                if ($totalPlacements > 0) {
                    $totalPackage = array_sum(array_column($placements, 'package_offered'));
                    $avgPackage = $totalPackage / $totalPlacements;
                }
                ?>
                <div class="dashboard-card">
                    <h3><?php echo $totalPlacements; ?></h3>
                    <p>Total Placements</p>
                </div>
                <div class="dashboard-card">
                    <h3><?php echo count($currentYearPlacements); ?></h3>
                    <p>Current Year Placements</p>
                </div>
                <div class="dashboard-card">
                    <h3><?php echo number_format($avgPackage, 2); ?> LPA</h3>
                    <p>Average Package</p>
                </div>
            </div>
        </div>

        <!-- Placements List -->
        <div class="content-card">
            <h2>Placement Records</h2>
            
            <div class="form-group">
                <input type="text" class="form-input table-search" placeholder="Search placement records...">
            </div>
            
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Student Name</th>
                        <th>Registration No.</th>
                        <th>Company</th>
                        <th>Position</th>
                        <th>Package (LPA)</th>
                        <th>Placement Date</th>
                        <th>Academic Year</th>
                        <th>Document</th>
                        <th>Created By</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($placements as $placement): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($placement['student_name']); ?></td>
                        <td><?php echo htmlspecialchars($placement['registration_number']); ?></td>
                        <td><?php echo htmlspecialchars($placement['company_name']); ?></td>
                        <td><?php echo htmlspecialchars($placement['position']); ?></td>
                        <td><?php echo $placement['package_offered'] ? number_format($placement['package_offered'], 2) : '-'; ?></td>
                        <td><?php echo date('d-m-Y', strtotime($placement['placement_date'])); ?></td>
                        <td><?php echo htmlspecialchars($placement['academic_year']); ?></td>
                        <td>
                            <?php if ($placement['document_path']): ?>
                                <a href="<?php echo $placement['document_path']; ?>" target="_blank" class="btn btn-secondary">View</a>
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>
                        <td><?php echo htmlspecialchars($placement['created_by_name']); ?></td>
                        <td>
                            <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" style="display: inline;">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?php echo $placement['id']; ?>">
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this placement record? This cannot be undone.')">Delete</button>
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
        autoSave('placementForm');
        <?php if ($messageType === 'success'): ?>
        clearAutoSave('placementForm');
        <?php endif; ?>
    </script>
</body>
</html>