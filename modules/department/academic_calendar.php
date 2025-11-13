<?php
require_once '../../includes/auth.php';
require_once '../../config/database.php';
$auth = checkAuth();

$database = new Database();
$db = $database->getConnection();

$message = '';
$messageType = '';

// Handle form submission (guarded) - wrap DB actions so missing tables don't cause fatal errors
if ($_POST) {
    try {
        if (isset($_POST['action'])) {
            if ($_POST['action'] === 'add') {
                $query = "INSERT INTO academic_calendar (academic_year, semester, event_name, start_date, end_date, description, document_path, created_by) 
                         VALUES (:academic_year, :semester, :event_name, :start_date, :end_date, :description, :document_path, :created_by)";
                
                $stmt = $db->prepare($query);
                $stmt->bindParam(':academic_year', $_POST['academic_year']);
                $stmt->bindParam(':semester', $_POST['semester']);
                $stmt->bindParam(':event_name', $_POST['event_name']);
                $stmt->bindParam(':start_date', $_POST['start_date']);
                $stmt->bindParam(':end_date', $_POST['end_date']);
                $stmt->bindParam(':description', $_POST['description']);
                
                // Handle file upload
                $document_path = '';
                if (isset($_FILES['document']) && $_FILES['document']['error'] === 0) {
                    $upload_dir = '../../uploads/academic_calendar/';
                    if (!file_exists($upload_dir)) {
                        mkdir($upload_dir, 0777, true);
                    }
                    $document_path = $upload_dir . time() . '_' . $_FILES['document']['name'];
                    move_uploaded_file($_FILES['document']['tmp_name'], $document_path);
                }
                
                $stmt->bindParam(':document_path', $document_path);
                $stmt->bindParam(':created_by', $_SESSION['user_id']);
                
                if ($stmt->execute()) {
                    $message = 'Academic calendar event added successfully!';
                    $messageType = 'success';
                } else {
                    $message = 'Error adding academic calendar event.';
                    $messageType = 'error';
                }
            } elseif ($_POST['action'] === 'delete') {
                $query = "DELETE FROM academic_calendar WHERE id = :id";
                $stmt = $db->prepare($query);
                $stmt->bindParam(':id', $_POST['id']);
                
                if ($stmt->execute()) {
                    $message = 'Academic calendar event deleted successfully!';
                    $messageType = 'success';
                } else {
                    $message = 'Error deleting academic calendar event.';
                    $messageType = 'error';
                }
            }
        }
    } catch (PDOException $e) {
        // Database table missing or other DB error — show friendly message and link to importer
        $messageType = 'error';
        $message = "Database table missing or query error: " . htmlspecialchars($e->getMessage()) .
                   ".<br>Please run the <a href=\"/test_dfm/setup/import_schema.php\">Import Schema</a> tool to create required tables, then refresh this page.";
    }
}

// Fetch all academic calendar events
$query = "SELECT ac.*, u.username as created_by_name 
          FROM academic_calendar ac 
          LEFT JOIN users u ON ac.created_by = u.id 
          ORDER BY ac.start_date DESC";
try {
    $stmt = $db->prepare($query);
    $stmt->execute();
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Likely missing table — show friendly error and link to import schema
    $events = [];
    $messageType = 'error';
    $message = "Database table missing or query error: " . htmlspecialchars($e->getMessage()) . 
               ".<br>Please run the <a href=\"/test_dfm/setup/import_schema.php\">Import Schema</a> tool to create required tables, then refresh this page.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Academic Calendar - Department Management</title>
    <link rel="icon" type="image/jpeg" href="/test_dfm/assets/images/college_logo.jpg">
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
    <?php include '../../includes/header.php'; ?>
    <?php include '../../includes/navigation.php'; ?>

    <div class="main-container">
        <h1 class="page-title">Academic Calendar Management</h1>
        
        <?php if ($message): ?>
            <div class="alert alert-<?php echo $messageType; ?>"><?php echo $message; ?></div>
        <?php endif; ?>

        <!-- Add New Event Form -->
        <div class="content-card">
            <h2>Add New Academic Event</h2>
            <form method="POST" enctype="multipart/form-data" id="academicCalendarForm">
                <input type="hidden" name="action" value="add">
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="academic_year" class="form-label">Academic Year *</label>
                        <input type="text" id="academic_year" name="academic_year" class="form-input" 
                               placeholder="e.g., 2023-24" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="semester" class="form-label">Semester *</label>
                        <select id="semester" name="semester" class="form-select" required>
                            <option value="">Select Semester</option>
                            <option value="Odd">Odd Semester</option>
                            <option value="Even">Even Semester</option>
                            <option value="Summer">Summer Term</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="event_name" class="form-label">Event Name *</label>
                    <input type="text" id="event_name" name="event_name" class="form-input" 
                           placeholder="e.g., Mid-term Examinations" required>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="start_date" class="form-label">Start Date *</label>
                        <input type="date" id="start_date" name="start_date" class="form-input" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="end_date" class="form-label">End Date</label>
                        <input type="date" id="end_date" name="end_date" class="form-input">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="description" class="form-label">Description</label>
                    <textarea id="description" name="description" class="form-textarea" 
                              placeholder="Event description and details"></textarea>
                </div>
                
                <div class="form-group">
                    <label for="document" class="form-label">Upload Document</label>
                    <div class="file-upload">
                        <input type="file" id="document" name="document" accept=".pdf,.doc,.docx,.jpg,.png">
                        <label for="document" class="file-upload-label">Choose file or drag and drop</label>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary">Add Event</button>
                <button type="reset" class="btn btn-secondary">Reset Form</button>
            </form>
        </div>

        <!-- Events List -->
        <div class="content-card">
            <h2>Academic Calendar Events</h2>
            
            <div class="form-group">
                <input type="text" class="form-input table-search" placeholder="Search events...">
            </div>
            
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Academic Year</th>
                        <th>Semester</th>
                        <th>Event Name</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Description</th>
                        <th>Document</th>
                        <th>Created By</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($events as $event): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($event['academic_year']); ?></td>
                        <td><?php echo htmlspecialchars($event['semester']); ?></td>
                        <td><?php echo htmlspecialchars($event['event_name']); ?></td>
                        <td><?php echo date('d-m-Y', strtotime($event['start_date'])); ?></td>
                        <td><?php echo $event['end_date'] ? date('d-m-Y', strtotime($event['end_date'])) : '-'; ?></td>
                        <td><?php echo htmlspecialchars(substr($event['description'], 0, 100)) . (strlen($event['description']) > 100 ? '...' : ''); ?></td>
                        <td>
                            <?php if ($event['document_path']): ?>
                                <a href="<?php echo $event['document_path']; ?>" target="_blank" class="btn btn-secondary">View</a>
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>
                        <td><?php echo htmlspecialchars($event['created_by_name']); ?></td>
                        <td>
                            <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" style="display: inline;">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?php echo $event['id']; ?>">
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this record? This cannot be undone.')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="../../assets/js/script.js"></script>
    <script>
        // Auto-save form data
        autoSave('academicCalendarForm');
        
        // Clear auto-save on successful submission
        <?php if ($messageType === 'success'): ?>
        clearAutoSave('academicCalendarForm');
        <?php endif; ?>
    </script>
</body>
</html>