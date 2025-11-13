<?php
require_once '../../includes/auth.php';
$auth = checkAuth();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MOU & Collaboration - Smart Archival & Information System</title>
    <link rel="icon" type="image/jpeg" href="/test_dfm/assets/images/college_logo.jpg">
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
    <?php include '../../includes/header.php'; ?>
    <?php include '../../includes/navigation.php'; ?>

    <div class="main-container">
        <div class="page-header">
            <h1 class="page-title">🤝 MOU & Collaboration Management</h1>
            <p class="page-description">Manage Memorandums of Understanding and institutional collaborations</p>
        </div>

        <div class="action-bar">
            <button class="btn btn-primary" onclick="showAddForm()">➕ Add New MOU</button>
            <button class="btn btn-secondary" onclick="generateReport()">📊 Generate Report</button>
        </div>

        <div class="content-grid">
            <div class="content-card">
                <h2>Current MOUs & Collaborations</h2>
                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Partner Organization</th>
                                <th>MOU Type</th>
                                <th>Signed Date</th>
                                <th>Validity Period</th>
                                <th>Purpose</th>
                                <th>Status</th>
                                <th>Document</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="8" class="no-data">No MOUs recorded. Click "Add New MOU" to get started.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="content-card">
                <h3>Collaboration Statistics</h3>
                <div class="stat-grid">
                    <div class="stat-item">
                        <div class="stat-number">0</div>
                        <div class="stat-label">Active MOUs</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">0</div>
                        <div class="stat-label">Partner Organizations</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">0</div>
                        <div class="stat-label">Expiring Soon</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="addMouModal" class="modal" style="display: none;">
        <div class="modal-content">
            <h3>Add New MOU/Collaboration</h3>
            <form id="mouForm">
                <div class="form-grid">
                    <div class="form-group">
                        <label for="partner_organization">Partner Organization:</label>
                        <input type="text" id="partner_organization" name="partner_organization" placeholder="ABC University" required>
                    </div>
                    <div class="form-group">
                        <label for="mou_type">MOU Type:</label>
                        <select id="mou_type" name="mou_type" required>
                            <option value="">Select Type</option>
                            <option value="Academic Exchange">Academic Exchange</option>
                            <option value="Research Collaboration">Research Collaboration</option>
                            <option value="Industry Partnership">Industry Partnership</option>
                            <option value="Student Exchange">Student Exchange</option>
                            <option value="Faculty Exchange">Faculty Exchange</option>
                            <option value="Joint Program">Joint Program</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="signed_date">Signed Date:</label>
                        <input type="date" id="signed_date" name="signed_date" required>
                    </div>
                    <div class="form-group">
                        <label for="validity_years">Validity (Years):</label>
                        <input type="number" id="validity_years" name="validity_years" placeholder="5" min="1" required>
                    </div>
                    <div class="form-group">
                        <label for="contact_person">Contact Person:</label>
                        <input type="text" id="contact_person" name="contact_person" placeholder="Dr. Smith">
                    </div>
                    <div class="form-group">
                        <label for="contact_email">Contact Email:</label>
                        <input type="email" id="contact_email" name="contact_email" placeholder="contact@partner.edu">
                    </div>
                    <div class="form-group">
                        <label for="status">Status:</label>
                        <select id="status" name="status" required>
                            <option value="Active">Active</option>
                            <option value="Pending">Pending</option>
                            <option value="Expired">Expired</option>
                            <option value="Terminated">Terminated</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="document_upload">MOU Document:</label>
                        <input type="file" id="document_upload" name="document_upload" accept=".pdf,.doc,.docx">
                    </div>
                    <div class="form-group full-width">
                        <label for="purpose">Purpose/Description:</label>
                        <textarea id="purpose" name="purpose" rows="3" placeholder="Describe the purpose and scope of this MOU..."></textarea>
                    </div>
                    <div class="form-group full-width">
                        <label for="benefits">Expected Benefits:</label>
                        <textarea id="benefits" name="benefits" rows="2" placeholder="List the expected benefits from this collaboration..."></textarea>
                    </div>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Save MOU</button>
                    <button type="button" class="btn btn-secondary" onclick="hideAddForm()">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function showAddForm() {
            document.getElementById('addMouModal').style.display = 'block';
        }

        function hideAddForm() {
            document.getElementById('addMouModal').style.display = 'none';
        }

        function generateReport() {
            alert('Report generation functionality will be implemented soon!');
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            var modal = document.getElementById('addMouModal');
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }
    </script>
</body>
</html>
