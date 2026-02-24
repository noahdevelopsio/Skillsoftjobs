<?php
include(__DIR__ . "/session_helper.php");
init_session();
include(__DIR__ . "/config.php");

// Only admins can download resumes
if (!isset($_SESSION['valid']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    http_response_code(403);
    die("Access denied.");
}

$app_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($app_id === 0) {
    die("Invalid application ID.");
}

// Fetch resume data from the database
$stmt = $con->prepare("SELECT resume_data, resume_filename FROM applications WHERE id = ?");
$stmt->bind_param("i", $app_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Application not found.");
}

$row = $result->fetch_assoc();

if (empty($row['resume_data'])) {
    die("No resume file attached to this application.");
}

$filename = $row['resume_filename'] ?: 'resume.pdf';
$file_data = base64_decode($row['resume_data']);

// Determine content type from extension
$ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
$mime_types = [
    'pdf' => 'application/pdf',
    'doc' => 'application/msword',
    'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
];
$content_type = $mime_types[$ext] ?? 'application/octet-stream';

// Serve the file
header("Content-Type: $content_type");
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Content-Length: " . strlen($file_data));
echo $file_data;
exit();
?>
