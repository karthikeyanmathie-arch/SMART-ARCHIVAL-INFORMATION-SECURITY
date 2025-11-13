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
            $query = "INSERT INTO result_analysis (academic_year, semester, course, subject, total_students, passed_students, failed_students, pass_percentage, analysis_details, document_path, created_by) 
                     VALUES (:academic_year, :semester, :course, :subject, :total_students, :passed_students, :failed_students, :pass_percentage, :analysis_details, :document_path, :created_by)";
            
            $stmt = $db->prepare($query);
            $stmt->bindParam(':academic_year', $_POST['academic_year']);
            $stmt->bindParam(':semester', $_POST['semester']);
            $stmt->bindParam(':course', $_POST['course']);
            $stmt->bindParam(':subject', $_POST['subject']);
            $stmt->bindParam(':total_students', $_POST['total_students']);
            
            $passed_students = (int)$_POST['total_students'] - (int)$_POST['failed_students'];
            $failed_students = (int)$_POST['total_students'] - $passed_students;
            $pass_percentage = ($passed_students / (int)$_POST['total_students']) * 100;
            
            $stmt->bindParam(':passed_students', $passed_students);
            $stmt->bindParam(':failed_students', $failed_students);
            $stmt->bindParam(':pass_percentage', $pass_percentage);
            $stmt->bindParam(':analysis_details', $_POST['observations']);
            
            // Handle file upload
            $document_path = '';
            if (isset($_FILES['document']) && $_FILES['document']['error'] === 0) {
                $upload_dir = '../../uploads/result_analysis/';
                if (!file_exists($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }
                $document_path = $upload_dir . time() . '_' . $_FILES['document']['name'];
                move_uploaded_file($_FILES['document']['tmp_name'], $document_path);
            }
            
            $stmt->bindParam(':document_path', $document_path);
            $stmt->bindParam(':created_by', $_SESSION['user_id']);
            
            if ($stmt->execute()) {
                $message = 'Result analysis added successfully!';
                $messageType = 'success';
            } else {
                $message = 'Error adding result analysis.';
                $messageType = 'error';
            }
        }
    }
}

// Fetch existing records
$query = "SELECT * FROM result_analysis ORDER BY created_at DESC";
$stmt = $db->prepare($query);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Result Analysis - Smart Archival & Information System</title>
    <link rel="icon" type="image/jpeg" href="/test_dfm/assets/images/college_logo.jpg">
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
    <?php include '../../includes/header.php'; ?>
    <?php include '../../includes/navigation.php'; ?>

    <div class="main-container">
        <?php if ($message): ?>
            <div class="alert alert-<?php echo $messageType; ?>"><?php echo $message; ?></div>
        <?php endif; ?>
        
        <div class="page-header">
            <h1 class="page-title">📊 Result Analysis Management</h1>
            <p class="page-description">Analyze and manage academic results and performance metrics</p>
        </div>

        <div class="action-bar">
            <button class="btn btn-primary" onclick="showAddForm()">➕ Add Result Analysis</button>
            <button class="btn btn-secondary" onclick="generateReport()">📈 Generate Report</button>
        </div>

        <div class="content-grid">
            <div class="content-card">
                <h2>Result Analysis Records</h2>
                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Academic Year</th>
                                <th>Semester</th>
                                <th>Class</th>
                                <th>Subject</th>
                                <th>Total Students</th>
                                <th>Pass Percentage</th>
                                <th>Average Marks</th>
                                <th>Analysis Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="9" class="no-data">No result analysis found. Click "Add Result Analysis" to get started.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="content-card">
                <h3>Performance Statistics</h3>
                <div class="stat-grid">
                    <div class="stat-item">
                        <div class="stat-number">0%</div>
                        <div class="stat-label">Overall Pass Rate</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">0</div>
                        <div class="stat-label">Subjects Analyzed</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">0</div>
                        <div class="stat-label">Students Evaluated</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="addAnalysisModal" class="modal" style="display: none;">
        <div class="modal-content">
            <h3>Add Result Analysis</h3>
            <form id="analysisForm" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" value="add">
                <div class="form-grid">
                    <div class="form-group">
                        <label for="academic_year">Academic Year:</label>
                        <input type="text" id="academic_year" name="academic_year" placeholder="2024-25" required>
                    </div>
                    <div class="form-group">
                        <label for="semester">Semester:</label>
                        <select id="semester" name="semester" required>
                            <option value="">Select Semester</option>
                            <option value="I">Semester I</option>
                            <option value="II">Semester II</option>
                            <option value="III">Semester III</option>
                            <option value="IV">Semester IV</option>
                            <option value="V">Semester V</option>
                            <option value="VI">Semester VI</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="class_name">Class:</label>
                        <input type="text" id="class_name" name="class_name" placeholder="B.Tech CSE" required>
                    </div>
                    <div class="form-group">
                        <label for="subject">Subject:</label>
                        <input type="text" id="subject" name="subject" placeholder="Data Structures" required>
                    </div>
                    <div class="form-group">
                        <label for="total_students">Total Students:</label>
                        <input type="number" id="total_students" name="total_students" placeholder="60" min="1" required>
                    </div>
                    <div class="form-group">
                        <label for="students_passed">Students Passed:</label>
                        <input type="number" id="students_passed" name="students_passed" placeholder="54" min="0" required>
                    </div>
                    <div class="form-group">
                        <label for="average_marks">Average Marks:</label>
                        <input type="number" id="average_marks" name="average_marks" placeholder="75.5" step="0.1" min="0" max="100" required>
                    </div>
                    <div class="form-group">
                        <label for="highest_marks">Highest Marks:</label>
                        <input type="number" id="highest_marks" name="highest_marks" placeholder="95" min="0" max="100">
                    </div>
                    <div class="form-group">
                        <label for="lowest_marks">Lowest Marks:</label>
                        <input type="number" id="lowest_marks" name="lowest_marks" placeholder="35" min="0" max="100">
                    </div>
                    <div class="form-group">
                        <label for="analysis_date">Analysis Date:</label>
                        <input type="date" id="analysis_date" name="analysis_date" required>
                    </div>
                    <div class="form-group full-width">
                        <label for="observations">Key Observations:</label>
                        <textarea id="observations" name="observations" rows="3" placeholder="Key findings and observations from the result analysis..."></textarea>
                    </div>
                    <div class="form-group full-width">
                        <label for="recommendations">Recommendations:</label>
                        <textarea id="recommendations" name="recommendations" rows="3" placeholder="Recommendations for improvement..."></textarea>
                    </div>
                    <div class="form-group full-width">
                        <label for="document">Upload Document (Optional):</label>
                        <input type="file" id="document" name="document" accept=".pdf,.doc,.docx,.xlsx,.xls">
                        <small>Supported formats: PDF, DOC, DOCX, XLS, XLSX</small>
                    </div>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Save Analysis</button>
                    <button type="button" class="btn btn-secondary" onclick="hideAddForm()">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function showAddForm() {
            document.getElementById('addAnalysisModal').style.display = 'block';
        }

        function hideAddForm() {
            document.getElementById('addAnalysisModal').style.display = 'none';
        }

        function generateReport() {
            alert('Report generation functionality will be implemented soon!');
        }

        // Auto-calculate pass percentage
        document.getElementById('students_passed').addEventListener('input', function() {
            const total = parseInt(document.getElementById('total_students').value) || 0;
            const passed = parseInt(this.value) || 0;
            
            if (total > 0) {
                const percentage = ((passed / total) * 100).toFixed(2);
                console.log('Pass Percentage: ' + percentage + '%');
            }
        });

        // Close modal when clicking outside
        window.onclick = function(event) {
            var modal = document.getElementById('addAnalysisModal');
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }
    </script>
</body>
</html>
