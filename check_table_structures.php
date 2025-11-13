<?php
require_once 'config/database.php';

$database = new Database();
$conn = $database->getConnection();

echo "Database Table Structures:\n\n";

$tables = ['academic_calendar', 'research_publications', 'student_projects', 'student_admission', 'syllabus', 'placement_data', 'alumni_data'];

foreach ($tables as $table) {
    echo "=== $table ===\n";
    try {
        $stmt = $conn->query("DESCRIBE $table");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo $row['Field'] . ' (' . $row['Type'] . ")\n";
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
    echo "\n";
}
?>