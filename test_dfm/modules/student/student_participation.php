<?php
require_once '../../includes/auth.php';
$auth = checkAuth();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Participation - Smart Archival & Information System</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
    <?php include '../../includes/header.php'; ?>
    <?php include '../../includes/navigation.php'; ?>

    <div class="main-container">
        <div class="page-header">
            <h1 class="page-title">🏆 Student Participation Management</h1>
            <p class="page-description">Track student participation in various activities and competitions</p>
        </div>

        <div class="action-bar">
            <button class="btn btn-primary" onclick="showAddForm()">➕ Add Participation Record</button>
            <button class="btn btn-secondary" onclick="exportData()">📤 Export Data</button>
        </div>

        <div class="content-grid">
            <div class="content-card">
                <h2>Student Participation Records</h2>
                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Student Name</th>
                                <th>Event/Activity</th>
                                <th>Type</th>
                                <th>Date</th>
                                <th>Level</th>
                                <th>Achievement</th>
                                <th>Certificate</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="8" class="no-data">No participation records found. Click "Add Participation Record" to get started.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="content-card">
                <h3>Participation Statistics</h3>
                <div class="stat-grid">
                    <div class="stat-item">
                        <div class="stat-number">0</div>
                        <div class="stat-label">Total Participations</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">0</div>
                        <div class="stat-label">Awards Won</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">0</div>
                        <div class="stat-label">Active Students</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="addParticipationModal" class="modal" style="display: none;">
        <div class="modal-content">
            <h3>Add Student Participation Record</h3>
            <form id="participationForm">
                <div class="form-grid">
                    <div class="form-group">
                        <label for="student_name">Student Name:</label>
                        <input type="text" id="student_name" name="student_name" placeholder="John Doe" required>
                    </div>
                    <div class="form-group">
                        <label for="roll_number">Roll Number:</label>
                        <input type="text" id="roll_number" name="roll_number" placeholder="CS2022001" required>
                    </div>
                    <div class="form-group">
                        <label for="event_name">Event/Activity Name:</label>
                        <input type="text" id="event_name" name="event_name" placeholder="National Coding Competition" required>
                    </div>
                    <div class="form-group">
                        <label for="activity_type">Activity Type:</label>
                        <select id="activity_type" name="activity_type" required>
                            <option value="">Select Type</option>
                            <option value="Competition">Competition</option>
                            <option value="Conference">Conference</option>
                            <option value="Workshop">Workshop</option>
                            <option value="Seminar">Seminar</option>
                            <option value="Sports">Sports</option>
                            <option value="Cultural">Cultural</option>
                            <option value="Technical">Technical</option>
                            <option value="Research">Research</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="event_date">Event Date:</label>
                        <input type="date" id="event_date" name="event_date" required>
                    </div>
                    <div class="form-group">
                        <label for="event_level">Event Level:</label>
                        <select id="event_level" name="event_level" required>
                            <option value="">Select Level</option>
                            <option value="Institutional">Institutional</option>
                            <option value="District">District</option>
                            <option value="State">State</option>
                            <option value="National">National</option>
                            <option value="International">International</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="organizer">Organized By:</label>
                        <input type="text" id="organizer" name="organizer" placeholder="XYZ University" required>
                    </div>
                    <div class="form-group">
                        <label for="achievement">Achievement:</label>
                        <select id="achievement" name="achievement">
                            <option value="Participation">Participation</option>
                            <option value="First Prize">First Prize</option>
                            <option value="Second Prize">Second Prize</option>
                            <option value="Third Prize">Third Prize</option>
                            <option value="Special Recognition">Special Recognition</option>
                            <option value="Merit Certificate">Merit Certificate</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="certificate_received">Certificate Received:</label>
                        <select id="certificate_received" name="certificate_received">
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                            <option value="Pending">Pending</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="mentor">Faculty Mentor:</label>
                        <input type="text" id="mentor" name="mentor" placeholder="Dr. Smith">
                    </div>
                    <div class="form-group full-width">
                        <label for="description">Event Description:</label>
                        <textarea id="description" name="description" rows="3" placeholder="Brief description of the event..."></textarea>
                    </div>
                    <div class="form-group full-width">
                        <label for="learning_outcomes">Learning Outcomes:</label>
                        <textarea id="learning_outcomes" name="learning_outcomes" rows="2" placeholder="What the student learned from this participation..."></textarea>
                    </div>
                    <div class="form-group full-width">
                        <label for="certificate_upload">Upload Certificate:</label>
                        <input type="file" id="certificate_upload" name="certificate_upload" accept=".pdf,.jpg,.png">
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
            document.getElementById('addParticipationModal').style.display = 'block';
        }

        function hideAddForm() {
            document.getElementById('addParticipationModal').style.display = 'none';
        }

        function exportData() {
            alert('Export functionality will be implemented soon!');
        }

        window.onclick = function(event) {
            var modal = document.getElementById('addParticipationModal');
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }
    </script>
</body>
</html>
