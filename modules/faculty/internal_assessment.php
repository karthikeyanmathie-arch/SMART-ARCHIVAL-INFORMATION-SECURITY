<?php
require_once '../../includes/auth.php';
$auth = checkAuth();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Internal Assessment - Smart Archival & Information System</title>
    <link rel="icon" type="image/jpeg" href="/test_dfm/assets/images/college_logo.jpg">
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
    <?php include '../../includes/header.php'; ?>
    <?php include '../../includes/navigation.php'; ?>

    <div class="main-container">
        <div class="page-header">
            <h1 class="page-title">📝 Internal Assessment Management</h1>
            <p class="page-description">Manage internal assessments, assignments, and continuous evaluation</p>
        </div>

        <div class="action-bar">
            <button class="btn btn-primary" onclick="showAddForm()">➕ Add Assessment</button>
            <button class="btn btn-secondary" onclick="exportData()">📤 Export Data</button>
        </div>

        <div class="content-grid">
            <div class="content-card">
                <h2>Internal Assessments</h2>
                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Assessment Type</th>
                                <th>Subject</th>
                                <th>Class</th>
                                <th>Date</th>
                                <th>Max Marks</th>
                                <th>Students</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="8" class="no-data">No assessments found. Click "Add Assessment" to get started.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div id="addAssessmentModal" class="modal" style="display: none;">
        <div class="modal-content">
            <h3>Add Internal Assessment</h3>
            <form id="assessmentForm">
                <div class="form-grid">
                    <div class="form-group">
                        <label for="assessment_type">Assessment Type:</label>
                        <select id="assessment_type" name="assessment_type" required>
                            <option value="">Select Type</option>
                            <option value="Mid Term">Mid Term</option>
                            <option value="Assignment">Assignment</option>
                            <option value="Quiz">Quiz</option>
                            <option value="Project">Project</option>
                            <option value="Presentation">Presentation</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="subject">Subject:</label>
                        <input type="text" id="subject" name="subject" placeholder="Data Structures" required>
                    </div>
                    <div class="form-group">
                        <label for="class_name">Class:</label>
                        <input type="text" id="class_name" name="class_name" placeholder="B.Tech CSE - II Year" required>
                    </div>
                    <div class="form-group">
                        <label for="assessment_date">Assessment Date:</label>
                        <input type="date" id="assessment_date" name="assessment_date" required>
                    </div>
                    <div class="form-group">
                        <label for="max_marks">Maximum Marks:</label>
                        <input type="number" id="max_marks" name="max_marks" placeholder="50" min="1" required>
                    </div>
                    <div class="form-group">
                        <label for="duration">Duration (minutes):</label>
                        <input type="number" id="duration" name="duration" placeholder="90" min="1">
                    </div>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Save Assessment</button>
                    <button type="button" class="btn btn-secondary" onclick="hideAddForm()">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function showAddForm() {
            document.getElementById('addAssessmentModal').style.display = 'block';
        }

        function hideAddForm() {
            document.getElementById('addAssessmentModal').style.display = 'none';
        }

        function exportData() {
            alert('Export functionality will be implemented soon!');
        }

        window.onclick = function(event) {
            var modal = document.getElementById('addAssessmentModal');
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }
    </script>
</body>
</html>
