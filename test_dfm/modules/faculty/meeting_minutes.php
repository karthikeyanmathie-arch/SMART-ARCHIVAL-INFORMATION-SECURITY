<?php
require_once '../../includes/auth.php';
$auth = checkAuth();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meeting Minutes - Smart Archival & Information System</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
    <?php include '../../includes/header.php'; ?>
    <?php include '../../includes/navigation.php'; ?>

    <div class="main-container">
        <div class="page-header">
            <h1 class="page-title">📋 Meeting Minutes Management</h1>
            <p class="page-description">Record and manage departmental meeting minutes and decisions</p>
        </div>

        <div class="action-bar">
            <button class="btn btn-primary" onclick="showAddForm()">➕ Add Meeting Minutes</button>
            <button class="btn btn-secondary" onclick="exportData()">📤 Export Data</button>
        </div>

        <div class="content-grid">
            <div class="content-card">
                <h2>Meeting Records</h2>
                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Meeting Date</th>
                                <th>Meeting Type</th>
                                <th>Chairperson</th>
                                <th>Attendees</th>
                                <th>Agenda Items</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="7" class="no-data">No meeting minutes found. Click "Add Meeting Minutes" to get started.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div id="addMeetingModal" class="modal" style="display: none;">
        <div class="modal-content">
            <h3>Add Meeting Minutes</h3>
            <form id="meetingForm">
                <div class="form-grid">
                    <div class="form-group">
                        <label for="meeting_date">Meeting Date:</label>
                        <input type="date" id="meeting_date" name="meeting_date" required>
                    </div>
                    <div class="form-group">
                        <label for="meeting_type">Meeting Type:</label>
                        <select id="meeting_type" name="meeting_type" required>
                            <option value="">Select Type</option>
                            <option value="Department">Department Meeting</option>
                            <option value="Faculty">Faculty Meeting</option>
                            <option value="Academic">Academic Committee</option>
                            <option value="Administrative">Administrative</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="chairperson">Chairperson:</label>
                        <input type="text" id="chairperson" name="chairperson" placeholder="Dr. Smith" required>
                    </div>
                    <div class="form-group">
                        <label for="venue">Venue:</label>
                        <input type="text" id="venue" name="venue" placeholder="Conference Room A">
                    </div>
                    <div class="form-group full-width">
                        <label for="attendees">Attendees:</label>
                        <textarea id="attendees" name="attendees" rows="3" placeholder="List of attendees..." required></textarea>
                    </div>
                    <div class="form-group full-width">
                        <label for="agenda">Agenda Items:</label>
                        <textarea id="agenda" name="agenda" rows="4" placeholder="Meeting agenda..." required></textarea>
                    </div>
                    <div class="form-group full-width">
                        <label for="discussions">Key Discussions:</label>
                        <textarea id="discussions" name="discussions" rows="4" placeholder="Summary of discussions..."></textarea>
                    </div>
                    <div class="form-group full-width">
                        <label for="decisions">Decisions Made:</label>
                        <textarea id="decisions" name="decisions" rows="3" placeholder="Key decisions and resolutions..."></textarea>
                    </div>
                    <div class="form-group full-width">
                        <label for="action_items">Action Items:</label>
                        <textarea id="action_items" name="action_items" rows="3" placeholder="Action items and responsible persons..."></textarea>
                    </div>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Save Minutes</button>
                    <button type="button" class="btn btn-secondary" onclick="hideAddForm()">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function showAddForm() {
            document.getElementById('addMeetingModal').style.display = 'block';
        }

        function hideAddForm() {
            document.getElementById('addMeetingModal').style.display = 'none';
        }

        function exportData() {
            alert('Export functionality will be implemented soon!');
        }

        window.onclick = function(event) {
            var modal = document.getElementById('addMeetingModal');
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }
    </script>
</body>
</html>
