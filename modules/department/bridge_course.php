<?php
require_once '../../includes/auth.php';
$auth = checkAuth();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bridge Course Sessions - Smart Archival & Information System</title>
    <link rel="icon" type="image/jpeg" href="/test_dfm/assets/images/college_logo.jpg">
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
    <?php include '../../includes/header.php'; ?>
    <?php include '../../includes/navigation.php'; ?>

    <div class="main-container">
        <div class="page-header">
            <h1 class="page-title">🌉 Bridge Course Sessions</h1>
            <p class="page-description">Manage bridge courses to help students transition between academic levels</p>
        </div>

        <div class="action-bar">
            <button class="btn btn-primary" onclick="showAddForm()">➕ Add Bridge Course</button>
            <button class="btn btn-secondary" onclick="exportData()">📤 Export Data</button>
        </div>

        <div class="content-grid">
            <div class="content-card">
                <h2>Current Bridge Courses</h2>
                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Course Name</th>
                                <th>Target Level</th>
                                <th>Instructor</th>
                                <th>Duration</th>
                                <th>Students</th>
                                <th>Start Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="8" class="no-data">No bridge courses available. Click "Add Bridge Course" to get started.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="content-card">
                <h3>Bridge Course Analytics</h3>
                <div class="stat-grid">
                    <div class="stat-item">
                        <div class="stat-number">0</div>
                        <div class="stat-label">Active Courses</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">0</div>
                        <div class="stat-label">Total Participants</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">0%</div>
                        <div class="stat-label">Completion Rate</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="addBridgeModal" class="modal" style="display: none;">
        <div class="modal-content">
            <h3>Add New Bridge Course</h3>
            <form id="bridgeForm">
                <div class="form-grid">
                    <div class="form-group">
                        <label for="course_name">Course Name:</label>
                        <input type="text" id="course_name" name="course_name" placeholder="Mathematics Foundation" required>
                    </div>
                    <div class="form-group">
                        <label for="target_level">Target Level:</label>
                        <select id="target_level" name="target_level" required>
                            <option value="">Select Level</option>
                            <option value="School to College">School to College</option>
                            <option value="Diploma to Degree">Diploma to Degree</option>
                            <option value="UG to PG">UG to PG</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="instructor">Instructor:</label>
                        <input type="text" id="instructor" name="instructor" placeholder="Dr. Johnson" required>
                    </div>
                    <div class="form-group">
                        <label for="duration_weeks">Duration (weeks):</label>
                        <input type="number" id="duration_weeks" name="duration_weeks" placeholder="8" min="1" required>
                    </div>
                    <div class="form-group">
                        <label for="max_participants">Max Participants:</label>
                        <input type="number" id="max_participants" name="max_participants" placeholder="50" min="1" required>
                    </div>
                    <div class="form-group">
                        <label for="start_date">Start Date:</label>
                        <input type="date" id="start_date" name="start_date" required>
                    </div>
                    <div class="form-group">
                        <label for="schedule">Schedule:</label>
                        <input type="text" id="schedule" name="schedule" placeholder="Mon-Fri, 10:00 AM - 12:00 PM" required>
                    </div>
                    <div class="form-group">
                        <label for="venue">Venue:</label>
                        <input type="text" id="venue" name="venue" placeholder="Conference Hall A">
                    </div>
                    <div class="form-group full-width">
                        <label for="description">Course Description:</label>
                        <textarea id="description" name="description" rows="3" placeholder="Brief description of the bridge course..."></textarea>
                    </div>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Create Bridge Course</button>
                    <button type="button" class="btn btn-secondary" onclick="hideAddForm()">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function showAddForm() {
            document.getElementById('addBridgeModal').style.display = 'block';
        }

        function hideAddForm() {
            document.getElementById('addBridgeModal').style.display = 'none';
        }

        function exportData() {
            alert('Export functionality will be implemented soon!');
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            var modal = document.getElementById('addBridgeModal');
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }
    </script>
</body>
</html>
