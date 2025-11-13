<?php
require_once '../../includes/auth.php';
$auth = checkAuth();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scholarship Files - Smart Archival & Information System</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
    <?php include '../../includes/header.php'; ?>
    <?php include '../../includes/navigation.php'; ?>

    <div class="main-container">
        <div class="page-header">
            <h1 class="page-title">🎓 Scholarship Files Management</h1>
            <p class="page-description">Manage scholarship applications, awards, and documentation</p>
        </div>

        <div class="action-bar">
            <button class="btn btn-primary" onclick="showAddForm()">➕ Add Scholarship Record</button>
            <button class="btn btn-secondary" onclick="generateReport()">📊 Generate Report</button>
        </div>

        <div class="content-grid">
            <div class="content-card">
                <h2>Scholarship Records</h2>
                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Student Name</th>
                                <th>Scholarship Type</th>
                                <th>Amount</th>
                                <th>Academic Year</th>
                                <th>Status</th>
                                <th>Award Date</th>
                                <th>Documents</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="8" class="no-data">No scholarship records found. Click "Add Scholarship Record" to get started.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="content-card">
                <h3>Scholarship Statistics</h3>
                <div class="stat-grid">
                    <div class="stat-item">
                        <div class="stat-number">₹0</div>
                        <div class="stat-label">Total Amount Awarded</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">0</div>
                        <div class="stat-label">Students Benefited</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">0</div>
                        <div class="stat-label">Active Scholarships</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="addScholarshipModal" class="modal" style="display: none;">
        <div class="modal-content">
            <h3>Add Scholarship Record</h3>
            <form id="scholarshipForm">
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
                        <label for="scholarship_type">Scholarship Type:</label>
                        <select id="scholarship_type" name="scholarship_type" required>
                            <option value="">Select Type</option>
                            <option value="Merit Scholarship">Merit Scholarship</option>
                            <option value="Need Based">Need Based</option>
                            <option value="Government Scholarship">Government Scholarship</option>
                            <option value="Private Scholarship">Private Scholarship</option>
                            <option value="Sports Scholarship">Sports Scholarship</option>
                            <option value="Research Fellowship">Research Fellowship</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="amount">Amount (₹):</label>
                        <input type="number" id="amount" name="amount" placeholder="50000" min="0" required>
                    </div>
                    <div class="form-group">
                        <label for="academic_year">Academic Year:</label>
                        <input type="text" id="academic_year" name="academic_year" placeholder="2024-25" required>
                    </div>
                    <div class="form-group">
                        <label for="award_date">Award Date:</label>
                        <input type="date" id="award_date" name="award_date" required>
                    </div>
                    <div class="form-group">
                        <label for="status">Status:</label>
                        <select id="status" name="status" required>
                            <option value="Applied">Applied</option>
                            <option value="Under Review">Under Review</option>
                            <option value="Approved">Approved</option>
                            <option value="Disbursed">Disbursed</option>
                            <option value="Rejected">Rejected</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="provider">Scholarship Provider:</label>
                        <input type="text" id="provider" name="provider" placeholder="Institution/Government/Organization">
                    </div>
                    <div class="form-group full-width">
                        <label for="criteria">Selection Criteria Met:</label>
                        <textarea id="criteria" name="criteria" rows="2" placeholder="Academic performance, financial need, etc."></textarea>
                    </div>
                    <div class="form-group full-width">
                        <label for="documents">Required Documents:</label>
                        <input type="file" id="documents" name="documents" multiple accept=".pdf,.jpg,.png,.doc,.docx">
                        <small>Upload application documents, certificates, etc.</small>
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
            document.getElementById('addScholarshipModal').style.display = 'block';
        }

        function hideAddForm() {
            document.getElementById('addScholarshipModal').style.display = 'none';
        }

        function generateReport() {
            alert('Report generation functionality will be implemented soon!');
        }

        window.onclick = function(event) {
            var modal = document.getElementById('addScholarshipModal');
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }
    </script>
</body>
</html>
