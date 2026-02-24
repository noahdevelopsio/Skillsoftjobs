<?php
include("php/config.php");

$sqlFile = "sql/skillsoft.sql";
$sql = file_get_contents($sqlFile);

if ($sql === false) {
    die("Error reading SQL file.");
}

// Split queries by semicolon (basic parsing, assumes no complex triggers/funcs with semicolons)
$queries = explode(";", $sql);

$successCount = 0;
$errorCount = 0;

echo "Starting import...\n";

foreach ($queries as $query) {
    $query = trim($query);
    if (!empty($query)) {
        if ($con->query($query)) {
            $successCount++;
        } else {
            // Ignore minor errors like "table already exists" if re-running
            echo "Error executing query: " . $con->error . "\n";
            $errorCount++;
        }
    }
}

echo "\nImport Finished.\n";
echo "Successful queries: $successCount\n";
echo "Failed queries: $errorCount\n";
?>
