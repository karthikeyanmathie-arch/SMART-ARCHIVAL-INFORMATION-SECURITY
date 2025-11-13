<?php
require_once '../../includes/auth.php';
$auth = checkAuth();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Higher Study Data - Smart Archival & Information System</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
    <?php include '../../includes/header.php'; ?>
    <?php include '../../includes/navigation.php'; ?>

    <div class="main-container">
        <div class="page-header">
            <h1 class="page-title">🎓 Higher Study Data Management</h1>
            <p class="page-description">Track and manage student higher education pursuits and achievements</p>
        </div>

        <div class="action-bar">
            <button class="btn btn-primary" onclick="showAddForm()">➕ Add Student Record</button>
            <button class="btn btn-secondary" onclick="exportData()">📤 Export Data</button>
        </div>

        <div class="content-grid">
            <div class="content-card">
                <h2>Higher Study Records</h2>
                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Student Name</th>
                                <th>Roll Number</th>
                                <th>Graduation Year</th>
                                <th>Higher Study Type</th>
                                <th>Institution</th>
                                <th>Course/Program</th>
                                <th>Country</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="9" class="no-data">No higher study records found. Click "Add Student Record" to get started.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="content-card">
                <h3>Higher Study Analytics</h3>
                <div class="stat-grid">
                    <div class="stat-item">
                        <div class="stat-number">0</div>
                        <div class="stat-label">Total Students</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">0</div>
                        <div class="stat-label">Pursuing Masters</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">0</div>
                        <div class="stat-label">Pursuing PhD</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">0</div>
                        <div class="stat-label">Foreign Universities</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="addStudyModal" class="modal" style="display: none;">
        <div class="modal-content">
            <h3>Add Higher Study Record</h3>
            <form id="studyForm">
                <div class="form-grid">
                    <div class="form-group">
                        <label for="student_name">Student Name:</label>
                        <input type="text" id="student_name" name="student_name" placeholder="John Doe" required>
                    </div>
                    <div class="form-group">
                        <label for="roll_number">Roll Number:</label>
                        <input type="text" id="roll_number" name="roll_number" placeholder="CS2020001" required>
                    </div>
                    <div class="form-group">
                        <label for="graduation_year">Graduation Year:</label>
                        <input type="number" id="graduation_year" name="graduation_year" placeholder="2024" min="2000" max="2030" required>
                    </div>
                    <div class="form-group">
                        <label for="study_type">Higher Study Type:</label>
                        <select id="study_type" name="study_type" required>
                            <option value="">Select Type</option>
                            <option value="Masters">Masters Degree</option>
                            <option value="PhD">PhD/Doctorate</option>
                            <option value="Professional Course">Professional Course</option>
                            <option value="Certification">Certification Program</option>
                            <option value="Research">Research Program</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="institution">Institution:</label>
                        <input type="text" id="institution" name="institution" placeholder="MIT" required>
                    </div>
                    <div class="form-group">
                        <label for="course_program">Course/Program:</label>
                        <input type="text" id="course_program" name="course_program" placeholder="M.S. in Computer Science" required>
                    </div>
                    <div class="form-group">
                        <label for="country">Country:</label>
                        <input type="text" id="country" name="country" placeholder="USA" required>
                    </div>
                    <div class="form-group">
                        <label for="admission_year">Admission Year:</label>
                        <input type="number" id="admission_year" name="admission_year" placeholder="2024" min="2020" max="2030">
                    </div>
                    <div class="form-group">
                        <label for="status">Status:</label>
                        <select id="status" name="status" required>
                            <option value="Applied">Applied</option>
                            <option value="Admitted">Admitted</option>
                            <option value="Enrolled">Enrolled</option>
                            <option value="Completed">Completed</option>
                            <option value="Dropped Out">Dropped Out</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="scholarship">Scholarship/Funding:</label>
                        <input type="text" id="scholarship" name="scholarship" placeholder="Full Scholarship, TA, etc.">
                    </div>
                    <div class="form-group">
                        <label for="gre_score">GRE Score:</label>
                        <input type="text" id="gre_score" name="gre_score" placeholder="320">
                    </div>
                    <div class="form-group">
                        <label for="ielts_toefl">IELTS/TOEFL Score:</label>
                        <input type="text" id="ielts_toefl" name="ielts_toefl" placeholder="7.5 IELTS / 100 TOEFL">
                    </div>
                    <div class="form-group full-width">
                        <label for="notes">Additional Notes:</label>
                        <textarea id="notes" name="notes" rows="3" placeholder="Any additional information..."></textarea>
                    </div>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Save Record</button>
                    <button type="button" class="btn btn-secondary" onclick="hideAddForm()">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function showAddForm() {
            document.getElementById('addStudyModal').style.display = 'block';
        }

        function hideAddForm() {
            document.getElementById('addStudyModal').style.display = 'none';
        }

        function exportData() {
            alert('Export functionality will be implemented soon!');
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            var modal = document.getElementById('addStudyModal');
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }
    </script>
</body>
</html>
