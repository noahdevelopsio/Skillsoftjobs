<?php
include(__DIR__ . "/session_helper.php");
init_session();
include(__DIR__ . "/config.php");

// Check if the user is logged in
if (!isset($_SESSION['valid'])) {
    header("Location: ../login.php");
    exit();
}

// Retrieve the logged-in user's ID
$user_id = $_SESSION['id'];

// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Get form data (with basic sanitization)
    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);
    $gender = trim($_POST['gender']);
    $email = trim($_POST['email']);
    $ssn = trim($_POST['ssn']);
    $phoneno = trim($_POST['phoneno']);
    $houseaddress = trim($_POST['houseaddress']);
    $bankname = trim($_POST['bankname']);
    $bankno = trim($_POST['bankno']);
    
    // Ensure we have a job context
    $job_id = isset($_POST['job_id']) ? intval($_POST['job_id']) : 0;
    
    if ($job_id === 0) {
        die("Invalid job reference. Please apply from a valid job listing.");
    }

    // --- File Upload Logic for Resume ---
    $fileInputName = 'resume'; 
    
    if (!isset($_FILES[$fileInputName]) || $_FILES[$fileInputName]['error'] !== UPLOAD_ERR_OK) {
        die("Error: Please upload a valid resume/CV document.");
    }

    // Validate file extension
    $original_filename = $_FILES[$fileInputName]["name"];
    $file_extension = strtolower(pathinfo($original_filename, PATHINFO_EXTENSION));
    $allowed_extensions = ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png'];
    
    if (!in_array($file_extension, $allowed_extensions)) {
        die("Error: Only PDF, DOC, DOCX, JPG, and PNG files are allowed.");
    }
    
    // Check file size (10MB limit)
    if ($_FILES[$fileInputName]["size"] > 10000000) {
        die("Error: File is too large (Maximum 10MB).");
    }

    // Read file content and encode as base64 for database storage
    // (Vercel has a read-only filesystem, so we can't use move_uploaded_file)
    $file_content = file_get_contents($_FILES[$fileInputName]["tmp_name"]);
    $resume_base64 = base64_encode($file_content);
    $resume_filename = $original_filename;

    // Determine MIME type for download
    $mime_types = [
        'pdf' => 'application/pdf',
        'doc' => 'application/msword',
        'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'png' => 'image/png',
    ];
    $resume_mime = $mime_types[$file_extension] ?? 'application/octet-stream';

    // --- Database Insertion ---
    $sql = "INSERT INTO applications (job_id, user_id, firstname, lastname, gender, email, driverlicense_path, resume_data, resume_filename, ssn, phoneno, houseaddress, bankname, bankno) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $con->prepare($sql);
    if (!$stmt) {
        die("Database Error: " . $con->error);
    }
    
    // driverlicense_path stores the original filename for backwards compat
    $stmt->bind_param("iissssssssssss", $job_id, $user_id, $firstname, $lastname, $gender, $email, $resume_filename, $resume_base64, $resume_filename, $ssn, $phoneno, $houseaddress, $bankname, $bankno);

    if ($stmt->execute()) {
        header("Location: ../jobs.php?status=applied");
        exit();
    } else {
        echo "Error saving application to database: " . $stmt->error;
    }
}
?>
