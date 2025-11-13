<?php
/**
 * Simple diagnostics page to help local setup.
 * Shows DB connection status and whether key tables exist.
 */
require_once __DIR__ . '/../config/database.php';

function checkTableExists($pdo, $table) {
    try {
        $stmt = $pdo->prepare("SHOW TABLES LIKE :t");
        $stmt->execute([':t' => $table]);
        return $stmt->rowCount() > 0;
    } catch (Exception $e) {
        return false;
    }
}

echo "<h2>Application Diagnostics</h2>";

try {
    $db = new Database();
    $pdo = $db->getConnection();
    echo "<div style='color:green; padding:8px;'>Database connection OK.</div>";

    $required = ['users', 'academic_calendar', 'student_admission', 'research_publications'];
    echo "<h3>Required tables</h3>";
    echo "<ul>";
    $missing = [];
    foreach ($required as $t) {
        $ok = checkTableExists($pdo, $t);
        if ($ok) echo "<li style='color:green;'>$t — exists</li>";
        else { echo "<li style='color:orange;'>$t — <strong>missing</strong></li>"; $missing[] = $t; }
    }
    echo "</ul>";

    if (!empty($missing)) {
        echo "<div style='margin-top:12px; padding:10px; background:#fff8e1; border:1px solid #ffe082;'>Some tables are missing. Run the Import Schema tool to create them.</div>";
        echo "<p><a href='/test_dfm/setup/import_schema.php' class='btn btn-primary'>Open Import Schema</a> ";
        echo "or run from terminal:<br><code>C:\\xampp\\php\\php.exe C:\\xampp\\htdocs\\test_dfm\\setup\\import_schema.php</code></p>";
    } else {
        echo "<div style='color:green; padding:8px;'>All required tables appear present.</div>";
    }

} catch (Exception $e) {
    echo "<div style='color:red; padding:8px;'>Database connection failed: " . htmlspecialchars($e->getMessage()) . "</div>";
    echo "<p>Make sure XAMPP Apache & MySQL are running. Then retry this page or run the importer: <a href='/test_dfm/setup/import_schema.php'>Import Schema</a></p>";
}

echo "<p><a href='/test_dfm/index.php'>Back to Dashboard</a></p>";

?>
