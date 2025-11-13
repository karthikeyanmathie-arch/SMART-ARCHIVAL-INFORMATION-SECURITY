<?php
require_once '../../includes/auth.php';
$auth = checkAuth();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Extension & Outreach - Smart Archival & Information System</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
    <?php include '../../includes/header.php'; ?>
    <?php include '../../includes/navigation.php'; ?>

    <div class="main-container">
        <div class="page-header">
            <h1 class="page-title">🌐 Extension & Outreach Programs</h1>
            <p class="page-description">Manage community extension and outreach activities</p>
        </div>

        <div class="action-bar">
            <button class="btn btn-primary" onclick="showAddForm()">➕ Add Program</button>
            <button class="btn btn-secondary" onclick="generateReport()">📊 Generate Report</button>
        </div>

        <div class="content-grid">
            <div class="content-card">
                <h2>Extension & Outreach Programs</h2>
                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Program Name</th>
                                <th>Type</th>
                                <th>Target Community</th>
                                <th>Date</th>
                                <th>Participants</th>
                                <th>Coordinator</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="8" class="no-data">No outreach programs found. Click "Add Program" to get started.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="content-card">
                <h3>Outreach Impact</h3>
                <div class="stat-grid">
                    <div class="stat-item">
                        <div class="stat-number">0</div>
                        <div class="stat-label">Programs Conducted</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">0</div>
                        <div class="stat-label">People Reached</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">0</div>
                        <div class="stat-label">Communities Served</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="addProgramModal" class="modal" style="display: none;">
        <div class="modal-content">
            <h3>Add Extension/Outreach Program</h3>
            <form id="programForm">
                <div class="form-grid">
                    <div class="form-group">
                        <label for="program_name">Program Name:</label>
                        <input type="text" id="program_name" name="program_name" placeholder="Digital Literacy Drive" required>
                    </div>
                    <div class="form-group">
                        <label for="program_type">Program Type:</label>
                        <select id="program_type" name="program_type" required>
                            <option value="">Select Type</option>
                            <option value="Community Service">Community Service</option>
                            <option value="Awareness Campaign">Awareness Campaign</option>
                            <option value="Skill Development">Skill Development</option>
                            <option value="Health Initiative">Health Initiative</option>
                            <option value="Environmental">Environmental</option>
                            <option value="Educational">Educational</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="target_community">Target Community:</label>
                        <input type="text" id="target_community" name="target_community" placeholder="Rural villages, Urban slums, etc." required>
                    </div>
                    <div class="form-group">
                        <label for="program_date">Program Date:</label>
                        <input type="date" id="program_date" name="program_date" required>
                    </div>
                    <div class="form-group">
                        <label for="duration_days">Duration (Days):</label>
                        <input type="number" id="duration_days" name="duration_days" placeholder="3" min="1" required>
                    </div>
                    <div class="form-group">
                        <label for="coordinator">Program Coordinator:</label>
                        <input type="text" id="coordinator" name="coordinator" placeholder="Dr. Smith" required>
                    </div>
                    <div class="form-group">
                        <label for="participants_count">Expected Participants:</label>
                        <input type="number" id="participants_count" name="participants_count" placeholder="100" min="1">
                    </div>
                    <div class="form-group">
                        <label for="location">Location:</label>
                        <input type="text" id="location" name="location" placeholder="Village XYZ" required>
                    </div>
                    <div class="form-group full-width">
                        <label for="objectives">Program Objectives:</label>
                        <textarea id="objectives" name="objectives" rows="3" placeholder="Main goals and objectives of the program..."></textarea>
                    </div>
                    <div class="form-group full-width">
                        <label for="activities">Activities Planned:</label>
                        <textarea id="activities" name="activities" rows="3" placeholder="List of activities to be conducted..."></textarea>
                    </div>
                    <div class="form-group full-width">
                        <label for="expected_impact">Expected Impact:</label>
                        <textarea id="expected_impact" name="expected_impact" rows="2" placeholder="Expected outcomes and impact..."></textarea>
                    </div>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Save Program</button>
                    <button type="button" class="btn btn-secondary" onclick="hideAddForm()">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function showAddForm() {
            document.getElementById('addProgramModal').style.display = 'block';
        }

        function hideAddForm() {
            document.getElementById('addProgramModal').style.display = 'none';
        }

        function generateReport() {
            alert('Report generation functionality will be implemented soon!');
        }

        window.onclick = function(event) {
            var modal = document.getElementById('addProgramModal');
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }
    </script>
</body>
</html>
