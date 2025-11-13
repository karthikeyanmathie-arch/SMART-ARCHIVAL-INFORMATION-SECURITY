<?php
require_once '../../includes/auth.php';
$auth = checkAuth();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Timetable Management - Smart Archival & Information System</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
    <?php include '../../includes/header.php'; ?>
    <?php include '../../includes/navigation.php'; ?>

    <div class="main-container">
        <div class="page-header">
            <h1 class="page-title">📅 Timetable Management</h1>
            <p class="page-description">Manage class schedules, faculty assignments, and timetable documents</p>
        </div>

        <div class="action-bar">
            <button class="btn btn-primary" onclick="showAddForm()">➕ Add New Timetable</button>
            <button class="btn btn-secondary" onclick="exportTimetable()">📤 Export Timetable</button>
        </div>

        <div class="content-grid">
            <div class="content-card">
                <h2>Current Academic Year Timetables</h2>
                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Academic Year</th>
                                <th>Semester</th>
                                <th>Class</th>
                                <th>Subject</th>
                                <th>Faculty</th>
                                <th>Day</th>
                                <th>Time</th>
                                <th>Room</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="9" class="no-data">No timetable entries found. Click "Add New Timetable" to get started.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="content-card">
                <h3>Quick Stats</h3>
                <div class="stat-grid">
                    <div class="stat-item">
                        <div class="stat-number">0</div>
                        <div class="stat-label">Total Classes</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">0</div>
                        <div class="stat-label">Faculty Assigned</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">0</div>
                        <div class="stat-label">Rooms Used</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="addTimetableModal" class="modal" style="display: none;">
        <div class="modal-content">
            <h3>Add New Timetable Entry</h3>
            <form id="timetableForm">
                <div class="form-grid">
                    <div class="form-group">
                        <label for="academic_year">Academic Year:</label>
                        <input type="text" id="academic_year" name="academic_year" placeholder="2024-25" required>
                    </div>
                    <div class="form-group">
                        <label for="semester">Semester:</label>
                        <select id="semester" name="semester" required>
                            <option value="">Select Semester</option>
                            <option value="I">Semester I</option>
                            <option value="II">Semester II</option>
                            <option value="III">Semester III</option>
                            <option value="IV">Semester IV</option>
                            <option value="V">Semester V</option>
                            <option value="VI">Semester VI</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="class_name">Class:</label>
                        <input type="text" id="class_name" name="class_name" placeholder="B.Tech CSE" required>
                    </div>
                    <div class="form-group">
                        <label for="subject">Subject:</label>
                        <input type="text" id="subject" name="subject" placeholder="Data Structures" required>
                    </div>
                    <div class="form-group">
                        <label for="faculty_name">Faculty Name:</label>
                        <input type="text" id="faculty_name" name="faculty_name" placeholder="Dr. Smith" required>
                    </div>
                    <div class="form-group">
                        <label for="day_of_week">Day:</label>
                        <select id="day_of_week" name="day_of_week" required>
                            <option value="">Select Day</option>
                            <option value="Monday">Monday</option>
                            <option value="Tuesday">Tuesday</option>
                            <option value="Wednesday">Wednesday</option>
                            <option value="Thursday">Thursday</option>
                            <option value="Friday">Friday</option>
                            <option value="Saturday">Saturday</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="start_time">Start Time:</label>
                        <input type="time" id="start_time" name="start_time" required>
                    </div>
                    <div class="form-group">
                        <label for="end_time">End Time:</label>
                        <input type="time" id="end_time" name="end_time" required>
                    </div>
                    <div class="form-group">
                        <label for="room_number">Room Number:</label>
                        <input type="text" id="room_number" name="room_number" placeholder="Room 101">
                    </div>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Save Timetable</button>
                    <button type="button" class="btn btn-secondary" onclick="hideAddForm()">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function showAddForm() {
            document.getElementById('addTimetableModal').style.display = 'block';
        }

        function hideAddForm() {
            document.getElementById('addTimetableModal').style.display = 'none';
        }

        function exportTimetable() {
            alert('Export functionality will be implemented soon!');
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            var modal = document.getElementById('addTimetableModal');
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }
    </script>
</body>
</html>
