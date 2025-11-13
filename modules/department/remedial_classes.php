<?php
require_once '../../includes/auth.php';
$auth = checkAuth();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Remedial Classes - Smart Archival & Information System</title>
    <link rel="icon" type="image/jpeg" href="/test_dfm/assets/images/college_logo.jpg">
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
    <?php include '../../includes/header.php'; ?>
    <?php include '../../includes/navigation.php'; ?>

    <div class="main-container">
        <div class="page-header">
            <h1 class="page-title">📚 Remedial Classes Management</h1>
            <p class="page-description">Manage remedial classes for student academic support</p>
        </div>

        <div class="action-bar">
            <button class="btn btn-primary" onclick="showAddForm()">➕ Add Remedial Class</button>
            <button class="btn btn-secondary" onclick="generateReport()">📊 Generate Report</button>
        </div>

        <div class="content-grid">
            <div class="content-card">
                <h2>Current Remedial Classes</h2>
                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Subject</th>
                                <th>Class</th>
                                <th>Faculty</th>
                                <th>Students Count</th>
                                <th>Schedule</th>
                                <th>Duration</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="8" class="no-data">No remedial classes scheduled. Click "Add Remedial Class" to get started.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="content-card">
                <h3>Remedial Class Statistics</h3>
                <div class="stat-grid">
                    <div class="stat-item">
                        <div class="stat-number">0</div>
                        <div class="stat-label">Active Classes</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">0</div>
                        <div class="stat-label">Students Enrolled</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">0</div>
                        <div class="stat-label">Subjects Covered</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="addRemedialModal" class="modal" style="display: none;">
        <div class="modal-content">
            <h3>Add New Remedial Class</h3>
            <form id="remedialForm">
                <div class="form-grid">
                    <div class="form-group">
                        <label for="subject_name">Subject:</label>
                        <input type="text" id="subject_name" name="subject_name" placeholder="Mathematics" required>
                    </div>
                    <div class="form-group">
                        <label for="class_name">Class:</label>
                        <input type="text" id="class_name" name="class_name" placeholder="B.Tech CSE - I Year" required>
                    </div>
                    <div class="form-group">
                        <label for="faculty_name">Faculty:</label>
                        <input type="text" id="faculty_name" name="faculty_name" placeholder="Dr. Smith" required>
                    </div>
                    <div class="form-group">
                        <label for="schedule">Schedule:</label>
                        <input type="text" id="schedule" name="schedule" placeholder="Mon, Wed, Fri - 4:00 PM" required>
                    </div>
                    <div class="form-group">
                        <label for="start_date">Start Date:</label>
                        <input type="date" id="start_date" name="start_date" required>
                    </div>
                    <div class="form-group">
                        <label for="end_date">End Date:</label>
                        <input type="date" id="end_date" name="end_date" required>
                    </div>
                    <div class="form-group">
                        <label for="max_students">Maximum Students:</label>
                        <input type="number" id="max_students" name="max_students" placeholder="30" min="1" required>
                    </div>
                    <div class="form-group">
                        <label for="room">Room:</label>
                        <input type="text" id="room" name="room" placeholder="Room 205">
                    </div>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Create Remedial Class</button>
                    <button type="button" class="btn btn-secondary" onclick="hideAddForm()">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function showAddForm() {
            document.getElementById('addRemedialModal').style.display = 'block';
        }

        function hideAddForm() {
            document.getElementById('addRemedialModal').style.display = 'none';
        }

        function generateReport() {
            alert('Report generation functionality will be implemented soon!');
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            var modal = document.getElementById('addRemedialModal');
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }
    </script>
</body>
</html>
