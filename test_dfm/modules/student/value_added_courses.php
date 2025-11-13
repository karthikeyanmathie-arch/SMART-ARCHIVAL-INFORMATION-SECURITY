<?php
require_once '../../includes/auth.php';
$auth = checkAuth();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Value Added Courses - Smart Archival & Information System</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
    <?php include '../../includes/header.php'; ?>
    <?php include '../../includes/navigation.php'; ?>

    <div class="main-container">
        <div class="page-header">
            <h1 class="page-title">💡 Value Added Courses Management</h1>
            <p class="page-description">Manage value-added courses and skill development programs</p>
        </div>

        <div class="action-bar">
            <button class="btn btn-primary" onclick="showAddForm()">➕ Add Course</button>
            <button class="btn btn-secondary" onclick="exportData()">📤 Export Data</button>
        </div>

        <div class="content-grid">
            <div class="content-card">
                <h2>Value Added Courses</h2>
                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Course Name</th>
                                <th>Category</th>
                                <th>Instructor</th>
                                <th>Duration</th>
                                <th>Enrolled Students</th>
                                <th>Start Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="8" class="no-data">No value added courses found. Click "Add Course" to get started.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="content-card">
                <h3>Course Statistics</h3>
                <div class="stat-grid">
                    <div class="stat-item">
                        <div class="stat-number">0</div>
                        <div class="stat-label">Active Courses</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">0</div>
                        <div class="stat-label">Total Enrollments</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">0</div>
                        <div class="stat-label">Completed Courses</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="addCourseModal" class="modal" style="display: none;">
        <div class="modal-content">
            <h3>Add Value Added Course</h3>
            <form id="courseForm">
                <div class="form-grid">
                    <div class="form-group">
                        <label for="course_name">Course Name:</label>
                        <input type="text" id="course_name" name="course_name" placeholder="Python Programming" required>
                    </div>
                    <div class="form-group">
                        <label for="category">Category:</label>
                        <select id="category" name="category" required>
                            <option value="">Select Category</option>
                            <option value="Programming">Programming</option>
                            <option value="Data Science">Data Science</option>
                            <option value="Web Development">Web Development</option>
                            <option value="Mobile Development">Mobile Development</option>
                            <option value="AI/ML">AI/ML</option>
                            <option value="Cybersecurity">Cybersecurity</option>
                            <option value="Soft Skills">Soft Skills</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="instructor">Instructor:</label>
                        <input type="text" id="instructor" name="instructor" placeholder="Dr. Smith / External Expert" required>
                    </div>
                    <div class="form-group">
                        <label for="duration_hours">Duration (Hours):</label>
                        <input type="number" id="duration_hours" name="duration_hours" placeholder="30" min="1" required>
                    </div>
                    <div class="form-group">
                        <label for="max_students">Max Students:</label>
                        <input type="number" id="max_students" name="max_students" placeholder="50" min="1" required>
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
                        <label for="certification">Certification:</label>
                        <select id="certification" name="certification">
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                    </div>
                    <div class="form-group full-width">
                        <label for="description">Course Description:</label>
                        <textarea id="description" name="description" rows="3" placeholder="Brief description of the course..."></textarea>
                    </div>
                    <div class="form-group full-width">
                        <label for="learning_outcomes">Learning Outcomes:</label>
                        <textarea id="learning_outcomes" name="learning_outcomes" rows="3" placeholder="What students will learn..."></textarea>
                    </div>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Save Course</button>
                    <button type="button" class="btn btn-secondary" onclick="hideAddForm()">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function showAddForm() {
            document.getElementById('addCourseModal').style.display = 'block';
        }

        function hideAddForm() {
            document.getElementById('addCourseModal').style.display = 'none';
        }

        function exportData() {
            alert('Export functionality will be implemented soon!');
        }

        window.onclick = function(event) {
            var modal = document.getElementById('addCourseModal');
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }
    </script>
</body>
</html>
