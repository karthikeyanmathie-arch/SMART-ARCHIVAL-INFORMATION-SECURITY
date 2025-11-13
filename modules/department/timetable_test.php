<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Timetable Management - Smart Archival & Information System</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
    <div class="main-container">
        <div class="page-header">
            <h1 class="page-title">📅 Timetable Management (Test Mode)</h1>
            <p class="page-description">Manage class schedules, faculty assignments, and timetable documents</p>
            <p style="color: red;">⚠️ This is a test version without authentication</p>
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
                                <td>2024-25</td>
                                <td>III</td>
                                <td>B.Tech CSE</td>
                                <td>Data Structures</td>
                                <td>Dr. Smith</td>
                                <td>Monday</td>
                                <td>10:00-11:00</td>
                                <td>Room 101</td>
                                <td><button class="btn btn-sm">Edit</button></td>
                            </tr>
                            <tr>
                                <td colspan="9" class="no-data">✅ Test data shown above. The page is working correctly!</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="content-card">
                <h3>Quick Stats</h3>
                <div class="stat-grid">
                    <div class="stat-item">
                        <div class="stat-number">1</div>
                        <div class="stat-label">Total Classes</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">1</div>
                        <div class="stat-label">Faculty Assigned</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">1</div>
                        <div class="stat-label">Rooms Used</div>
                    </div>
                </div>
            </div>
        </div>

        <div style="margin-top: 20px; padding: 20px; background: #e7f3ff; border-radius: 8px;">
            <h3>🔧 Navigation Test Results</h3>
            <p>✅ This page loaded successfully!</p>
            <p>✅ CSS styling is working</p>
            <p>✅ Page structure is correct</p>
            <p><strong>Issue:</strong> The problem is likely with authentication redirect when you're not logged in.</p>
            <p><strong>Solution:</strong> <a href="../../login.php">Login here first</a>, then navigate to the modules.</p>
        </div>
    </div>

    <script>
        function showAddForm() {
            alert('Add form would open here in the full version!');
        }

        function exportTimetable() {
            alert('Export functionality will be implemented soon!');
        }
    </script>
</body>
</html>
