<?php
require_once '../../includes/auth.php';
$auth = checkAuth();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Appraisal - Smart Archival & Information System</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
    <?php include '../../includes/header.php'; ?>
    <?php include '../../includes/navigation.php'; ?>

    <div class="main-container">
        <div class="page-header">
            <h1 class="page-title">⭐ Faculty Appraisal Management</h1>
            <p class="page-description">Manage faculty performance appraisals and evaluations</p>
        </div>

        <div class="action-bar">
            <button class="btn btn-primary" onclick="showAddForm()">➕ Add Appraisal Record</button>
            <button class="btn btn-secondary" onclick="generateReport()">📊 Generate Report</button>
        </div>

        <div class="content-grid">
            <div class="content-card">
                <h2>Faculty Appraisal Records</h2>
                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Faculty Name</th>
                                <th>Employee ID</th>
                                <th>Appraisal Period</th>
                                <th>Overall Rating</th>
                                <th>Teaching Score</th>
                                <th>Research Score</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="8" class="no-data">No appraisal records found. Click "Add Appraisal Record" to get started.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="content-card">
                <h3>Appraisal Statistics</h3>
                <div class="stat-grid">
                    <div class="stat-item">
                        <div class="stat-number">0</div>
                        <div class="stat-label">Faculty Evaluated</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">0.0</div>
                        <div class="stat-label">Average Rating</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">0</div>
                        <div class="stat-label">Pending Reviews</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="addAppraisalModal" class="modal" style="display: none;">
        <div class="modal-content">
            <h3>Add Faculty Appraisal</h3>
            <form id="appraisalForm">
                <div class="form-grid">
                    <div class="form-group">
                        <label for="faculty_name">Faculty Name:</label>
                        <input type="text" id="faculty_name" name="faculty_name" placeholder="Dr. Jane Smith" required>
                    </div>
                    <div class="form-group">
                        <label for="employee_id">Employee ID:</label>
                        <input type="text" id="employee_id" name="employee_id" placeholder="FAC001" required>
                    </div>
                    <div class="form-group">
                        <label for="appraisal_period">Appraisal Period:</label>
                        <input type="text" id="appraisal_period" name="appraisal_period" placeholder="2024-25" required>
                    </div>
                    <div class="form-group">
                        <label for="department">Department:</label>
                        <input type="text" id="department" name="department" placeholder="Computer Science" required>
                    </div>
                    <div class="form-group">
                        <label for="teaching_score">Teaching Score (1-10):</label>
                        <input type="number" id="teaching_score" name="teaching_score" placeholder="8.5" min="1" max="10" step="0.1" required>
                    </div>
                    <div class="form-group">
                        <label for="research_score">Research Score (1-10):</label>
                        <input type="number" id="research_score" name="research_score" placeholder="7.8" min="1" max="10" step="0.1" required>
                    </div>
                    <div class="form-group">
                        <label for="service_score">Service Score (1-10):</label>
                        <input type="number" id="service_score" name="service_score" placeholder="8.0" min="1" max="10" step="0.1" required>
                    </div>
                    <div class="form-group">
                        <label for="overall_rating">Overall Rating:</label>
                        <select id="overall_rating" name="overall_rating" required>
                            <option value="">Select Rating</option>
                            <option value="Outstanding">Outstanding</option>
                            <option value="Excellent">Excellent</option>
                            <option value="Good">Good</option>
                            <option value="Satisfactory">Satisfactory</option>
                            <option value="Needs Improvement">Needs Improvement</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="appraisal_date">Appraisal Date:</label>
                        <input type="date" id="appraisal_date" name="appraisal_date" required>
                    </div>
                    <div class="form-group">
                        <label for="evaluator">Evaluator:</label>
                        <input type="text" id="evaluator" name="evaluator" placeholder="Dr. Department Head">
                    </div>
                    <div class="form-group full-width">
                        <label for="strengths">Key Strengths:</label>
                        <textarea id="strengths" name="strengths" rows="3" placeholder="Notable strengths and achievements..."></textarea>
                    </div>
                    <div class="form-group full-width">
                        <label for="areas_improvement">Areas for Improvement:</label>
                        <textarea id="areas_improvement" name="areas_improvement" rows="3" placeholder="Areas that need development..."></textarea>
                    </div>
                    <div class="form-group full-width">
                        <label for="recommendations">Recommendations:</label>
                        <textarea id="recommendations" name="recommendations" rows="3" placeholder="Professional development recommendations..."></textarea>
                    </div>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Save Appraisal</button>
                    <button type="button" class="btn btn-secondary" onclick="hideAddForm()">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function showAddForm() {
            document.getElementById('addAppraisalModal').style.display = 'block';
        }

        function hideAddForm() {
            document.getElementById('addAppraisalModal').style.display = 'none';
        }

        function generateReport() {
            alert('Report generation functionality will be implemented soon!');
        }

        window.onclick = function(event) {
            var modal = document.getElementById('addAppraisalModal');
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }
    </script>
</body>
</html>
