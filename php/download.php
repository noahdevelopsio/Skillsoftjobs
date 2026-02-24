<?php
include(__DIR__ . "/session_helper.php");
init_session();
include(__DIR__ . "/config.php");

// Only admins can download applicant files
if (!isset($_SESSION['valid']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    http_response_code(403);
    die("Access denied.");
}

$app_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$type = isset($_GET['type']) ? $_GET['type'] : 'resume';

if ($app_id === 0) {
    die("Invalid application ID.");
}

// Map type to DB columns
$type_map = [
    'resume' => ['data' => 'resume_data', 'filename' => 'resume_filename'],
    'id'     => ['data' => 'id_data', 'filename' => 'id_filename'],
    'cover'  => ['data' => 'coverletter_data', 'filename' => 'coverletter_filename'],
];

if (!isset($type_map[$type])) {
    die("Invalid file type.");
}

$data_col = $type_map[$type]['data'];
$name_col = $type_map[$type]['filename'];

// Fetch file data from the database
$stmt = $con->prepare("SELECT $data_col, $name_col FROM applications WHERE id = ?");
$stmt->bind_param("i", $app_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Application not found.");
}

$row = $result->fetch_assoc();

if (empty($row[$data_col])) {
    die("No file attached for this type.");
}

$filename = $row[$name_col] ?: 'download';
$file_data = base64_decode($row[$data_col]);

// Determine content type from extension
$ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
$mime_types = [
    'pdf' => 'application/pdf',
    'doc' => 'application/msword',
    'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    'jpg' => 'image/jpeg',
    'jpeg' => 'image/jpeg',
    'png' => 'image/png',
];
$content_type = $mime_types[$ext] ?? 'application/octet-stream';

// Serve the file
header("Content-Type: $content_type");
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Content-Length: " . strlen($file_data));
echo $file_data;
exit();
?>
