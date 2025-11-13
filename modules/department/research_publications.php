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
                $query = "INSERT INTO research_publications (title, authors, journal_name, publication_date, volume, issue, pages, doi, document_path, created_by) 
                         VALUES (:title, :authors, :journal_name, :publication_date, :volume, :issue, :pages, :doi, :document_path, :created_by)";
                
                $stmt = $db->prepare($query);
                $stmt->bindParam(':title', $_POST['title']);
                $stmt->bindParam(':authors', $_POST['authors']);
                $stmt->bindParam(':journal_name', $_POST['journal_name']);
                $stmt->bindParam(':publication_date', $_POST['publication_date']);
                $stmt->bindParam(':volume', $_POST['volume']);
                $stmt->bindParam(':issue', $_POST['issue']);
                $stmt->bindParam(':pages', $_POST['pages']);
                $stmt->bindParam(':doi', $_POST['doi']);
                
                // Handle file upload
                $document_path = '';
                if (isset($_FILES['document']) && $_FILES['document']['error'] === 0) {
                    $upload_dir = '../../uploads/research_publications/';
                    if (!file_exists($upload_dir)) {
                        mkdir($upload_dir, 0777, true);
                    }
                    $document_path = $upload_dir . time() . '_' . $_FILES['document']['name'];
                    move_uploaded_file($_FILES['document']['tmp_name'], $document_path);
                }
                
                $stmt->bindParam(':document_path', $document_path);
                $stmt->bindParam(':created_by', $_SESSION['user_id']);
                
                if ($stmt->execute()) {
                    $message = 'Research publication added successfully!';
                    $messageType = 'success';
                } else {
                    $message = 'Error adding research publication.';
                    $messageType = 'error';
                }
            } elseif ($_POST['action'] === 'delete') {
                $query = "DELETE FROM research_publications WHERE id = :id";
                $stmt = $db->prepare($query);
                $stmt->bindParam(':id', $_POST['id']);
                
                if ($stmt->execute()) {
                    $message = 'Research publication deleted successfully!';
                    $messageType = 'success';
                } else {
                    $message = 'Error deleting research publication.';
                    $messageType = 'error';
                }
            }
        }
    } catch (PDOException $e) {
        $messageType = 'error';
        $message = "Database table missing or query error: " . htmlspecialchars($e->getMessage()) .
                   ".<br>Please run the <a href=\"/test_dfm/setup/import_schema.php\">Import Schema</a> tool to create required tables, then refresh this page.";
    }
}

// Fetch all research publications
$query = "SELECT rp.*, u.username as created_by_name 
          FROM research_publications rp 
          LEFT JOIN users u ON rp.created_by = u.id 
          ORDER BY rp.publication_date DESC";
try {
    $stmt = $db->prepare($query);
    $stmt->execute();
    $publications = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $publications = [];
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
    <title>Research Publications - Department Management</title>
    <link rel="icon" type="image/jpeg" href="/test_dfm/assets/images/college_logo.jpg">
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
    <?php include '../../includes/header.php'; ?>
    <?php include '../../includes/navigation.php'; ?>

    <div class="main-container">
        <h1 class="page-title">Research Publications Management</h1>
        
        <?php if ($message): ?>
            <div class="alert alert-<?php echo $messageType; ?>"><?php echo $message; ?></div>
        <?php endif; ?>

        <!-- Add New Publication Form -->
        <div class="content-card">
            <h2>Add New Research Publication</h2>
            <form method="POST" enctype="multipart/form-data" id="researchPublicationForm">
                <input type="hidden" name="action" value="add">
                
                <div class="form-group">
                    <label for="title" class="form-label">Publication Title *</label>
                    <input type="text" id="title" name="title" class="form-input" 
                           placeholder="Full title of the research paper" required>
                </div>
                
                <div class="form-group">
                    <label for="authors" class="form-label">Authors *</label>
                    <textarea id="authors" name="authors" class="form-textarea" 
                              placeholder="List all authors (comma separated)" required></textarea>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="journal_name" class="form-label">Journal Name</label>
                        <input type="text" id="journal_name" name="journal_name" class="form-input" 
                               placeholder="Name of the journal">
                    </div>
                    
                    <div class="form-group">
                        <label for="publication_date" class="form-label">Publication Date</label>
                        <input type="date" id="publication_date" name="publication_date" class="form-input">
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="volume" class="form-label">Volume</label>
                        <input type="text" id="volume" name="volume" class="form-input" placeholder="Volume number">
                    </div>
                    
                    <div class="form-group">
                        <label for="issue" class="form-label">Issue</label>
                        <input type="text" id="issue" name="issue" class="form-input" placeholder="Issue number">
                    </div>
                    
                    <div class="form-group">
                        <label for="pages" class="form-label">Pages</label>
                        <input type="text" id="pages" name="pages" class="form-input" placeholder="e.g., 123-145">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="doi" class="form-label">DOI</label>
                    <input type="text" id="doi" name="doi" class="form-input" 
                           placeholder="Digital Object Identifier">
                </div>
                
                <div class="form-group">
                    <label for="document" class="form-label">Upload Publication Document</label>
                    <div class="file-upload">
                        <input type="file" id="document" name="document" accept=".pdf,.doc,.docx">
                        <label for="document" class="file-upload-label">Choose file or drag and drop</label>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary">Add Publication</button>
                <button type="reset" class="btn btn-secondary">Reset Form</button>
            </form>
        </div>

        <!-- Publications List -->
        <div class="content-card">
            <h2>Research Publications</h2>
            
            <div class="form-group">
                <input type="text" class="form-input table-search" placeholder="Search publications...">
            </div>
            
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Authors</th>
                        <th>Journal</th>
                        <th>Publication Date</th>
                        <th>Volume/Issue</th>
                        <th>Pages</th>
                        <th>DOI</th>
                        <th>Document</th>
                        <th>Created By</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($publications as $publication): ?>
                    <tr>
                        <td><?php echo htmlspecialchars(substr($publication['title'], 0, 50)) . (strlen($publication['title']) > 50 ? '...' : ''); ?></td>
                        <td><?php echo htmlspecialchars(substr($publication['authors'], 0, 30)) . (strlen($publication['authors']) > 30 ? '...' : ''); ?></td>
                        <td><?php echo htmlspecialchars($publication['journal_name']); ?></td>
                        <td><?php echo $publication['publication_date'] ? date('d-m-Y', strtotime($publication['publication_date'])) : '-'; ?></td>
                        <td><?php echo htmlspecialchars($publication['volume'] . ($publication['issue'] ? '(' . $publication['issue'] . ')' : '')); ?></td>
                        <td><?php echo htmlspecialchars($publication['pages']); ?></td>
                        <td><?php echo htmlspecialchars($publication['doi']); ?></td>
                        <td>
                            <?php if ($publication['document_path']): ?>
                                <a href="<?php echo $publication['document_path']; ?>" target="_blank" class="btn btn-secondary">View</a>
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>
                        <td><?php echo htmlspecialchars($publication['created_by_name']); ?></td>
                        <td>
                            <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" style="display: inline;">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?php echo $publication['id']; ?>">
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this publication? This cannot be undone.')">Delete</button>
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
        autoSave('researchPublicationForm');
        <?php if ($messageType === 'success'): ?>
        clearAutoSave('researchPublicationForm');
        <?php endif; ?>
    </script>
</body>
</html>