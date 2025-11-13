<?php
/**
 * Simple schema importer — reads database/schema.sql and executes statements.
 * Usage: visit /test_dfm/setup/import_schema.php in the browser while XAMPP is running.
 */
require_once __DIR__ . '/../config/database.php';

// Show a confirmation UI on GET and run import on POST
echo "<h2>Import Database Schema</h2>\n";
try {
    $db = new Database();
    $pdo = $db->getConnection();
} catch (Exception $e) {
    echo "<div style='color: red;'>Database connection failed: " . htmlspecialchars($e->getMessage()) . "</div>";
    exit;
}

$sqlFile = __DIR__ . '/../database/schema.sql';
if (!file_exists($sqlFile)) {
    echo "<div style='color: red;'>Schema file not found at $sqlFile</div>";
    exit;
}

// Allow running from CLI (php setup/import_schema.php) or via POST from the browser
if (PHP_SAPI === 'cli') {
    // auto-run in CLI
} elseif ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "<p>This tool will execute the SQL statements in <code>database/schema.sql</code> to create missing database objects (tables, seed data).";
    echo " Use this if you see errors like 'Table ... doesn't exist'.</p>";
    echo "<form method='POST'><button type='submit' class='btn btn-primary'>Run Importer</button> ";
    echo "<a href='/test_dfm/index.php' class='btn' style='margin-left:10px;'>Back to Dashboard</a></form>";
    exit;
}

$sql = file_get_contents($sqlFile);

// Normalize line endings and remove SQL comments that start with --
$sql = preg_replace('/--.*?\n/', "\n", $sql);

// Split statements on semicolons (best-effort), but keep CREATE/INSERT together
$statements = preg_split('/;\s*(\r\n|\n)/', $sql);

$results = [];
foreach ($statements as $raw) {
    $stmt = trim($raw);
    if ($stmt === '') continue;

    // Try to extract a short label for user friendliness
    $label = substr($stmt, 0, 80);
    $short = preg_replace('/\s+/', ' ', substr($label, 0, 80));

    try {
        $pdo->exec($stmt);
        $results[] = ['sql' => $short, 'status' => 'ok', 'message' => 'Executed successfully'];
    } catch (PDOException $ex) {
        $results[] = ['sql' => $short, 'status' => 'warning', 'message' => $ex->getMessage()];
    }
}

// Render results
echo "<h3>Import Results</h3>";
echo "<div style='max-width:900px;'>";
$ok = 0; $warn = 0;
foreach ($results as $r) {
    if ($r['status'] === 'ok') { $ok++; echo "<div style='color:green; padding:6px; border-bottom:1px solid #eee;'>✔ " . htmlspecialchars($r['sql']) . "</div>"; }
    else { $warn++; echo "<div style='color:orange; padding:6px; border-bottom:1px solid #eee;'>⚠ " . htmlspecialchars($r['sql']) . " — " . htmlspecialchars($r['message']) . "</div>"; }
}
echo "</div>";

echo "<div style='margin-top:12px;'><strong>Summary:</strong> <span style='color:green;'>$ok executed</span>, <span style='color:orange;'>$warn warnings</span>.</div>";
echo "<p><a href='/test_dfm/index.php'>Back to Dashboard</a></p>";

?>
