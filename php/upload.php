<?php
include(__DIR__ . "/session_helper.php");
init_session();
include(__DIR__ . "/config.php");

// Check if the user is logged in
if (!isset($_SESSION['valid'])) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['id'];

if (isset($_POST['submit'])) {
    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);
    $gender = trim($_POST['gender']);
    $email = trim($_POST['email']);
    $ssn = trim($_POST['ssn'] ?? '');
    $phoneno = trim($_POST['phoneno']);
    $houseaddress = trim($_POST['houseaddress']);
    $bankname = trim($_POST['bankname']);
    $bankno = trim($_POST['bankno']);
    
    $job_id = isset($_POST['job_id']) ? intval($_POST['job_id']) : 0;
    if ($job_id === 0) {
        die("Invalid job reference. Please apply from a valid job listing.");
    }

    // Fetch job requirements
    $job_query = "SELECT req_passport, req_id, req_coverletter FROM jobs WHERE id = $job_id";
    $job_result = mysqli_query($con, $job_query);
    if (!$job_result || mysqli_num_rows($job_result) === 0) {
        die("Job not found.");
    }
    $job_reqs = mysqli_fetch_assoc($job_result);

    $allowed_extensions = ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png'];
    $max_size = 10000000; // 10MB

    // Helper function to process a file upload into base64
    function processUpload($fieldName, $allowed_extensions, $max_size) {
        if (!isset($_FILES[$fieldName]) || $_FILES[$fieldName]['error'] !== UPLOAD_ERR_OK) {
            return ['data' => null, 'filename' => null];
        }

        $original_filename = $_FILES[$fieldName]["name"];
        $file_extension = strtolower(pathinfo($original_filename, PATHINFO_EXTENSION));

        if (!in_array($file_extension, $allowed_extensions)) {
            die("Error: Only PDF, DOC, DOCX, JPG, and PNG files are allowed for " . htmlspecialchars($fieldName) . ".");
        }

        if ($_FILES[$fieldName]["size"] > $max_size) {
            die("Error: " . htmlspecialchars($fieldName) . " is too large (Maximum 10MB).");
        }

        $file_content = file_get_contents($_FILES[$fieldName]["tmp_name"]);
        return [
            'data' => base64_encode($file_content),
            'filename' => $original_filename
        ];
    }

    // Process file uploads
    // Resume is always required
    if (!isset($_FILES['resume']) || $_FILES['resume']['error'] !== UPLOAD_ERR_OK) {
        die("Error: Please upload a valid resume/CV document.");
    }
    
    // Check dynamic requirements
    if ($job_reqs['req_id'] && (!isset($_FILES['driverlicense']) || $_FILES['driverlicense']['error'] !== UPLOAD_ERR_OK)) {
        die("Error: Please upload a valid National ID / Driver's License.");
    }
    if ($job_reqs['req_coverletter'] && (!isset($_FILES['coverletter']) || $_FILES['coverletter']['error'] !== UPLOAD_ERR_OK)) {
        die("Error: Please upload a valid Cover Letter.");
    }
    if ($job_reqs['req_passport'] && (!isset($_FILES['passport']) || $_FILES['passport']['error'] !== UPLOAD_ERR_OK)) {
        die("Error: Please upload a valid Passport Photo.");
    }

    $resume = processUpload('resume', $allowed_extensions, $max_size);
    $id_doc = processUpload('driverlicense', $allowed_extensions, $max_size);
    $passport = processUpload('passport', ['jpg', 'jpeg', 'png'], $max_size);

    // Process cover letter ONLY if uploaded (since it can be optional)
    if (isset($_FILES['coverletter']) && $_FILES['coverletter']['error'] === UPLOAD_ERR_OK) {
        $coverletter = processUpload('coverletter', $allowed_extensions, $max_size);
    } else {
        $coverletter = ['data' => null, 'filename' => null];
    }

    // --- Database Insertion ---
    $sql = "INSERT INTO applications (job_id, user_id, firstname, lastname, gender, email, driverlicense_path, resume_data, resume_filename, id_data, id_filename, coverletter_data, coverletter_filename, photo_data, photo_filename, ssn, phoneno, houseaddress, bankname, bankno) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $con->prepare($sql);
    if (!$stmt) {
        die("Database Error: " . $con->error);
    }
    
    // driverlicense_path stores resume filename for backwards compat
    $stmt->bind_param("iissssssssssssssssss", 
        $job_id, $user_id, $firstname, $lastname, $gender, $email, 
        $resume['filename'],           // driverlicense_path (legacy)
        $resume['data'],               // resume_data
        $resume['filename'],           // resume_filename
        $id_doc['data'],               // id_data
        $id_doc['filename'],           // id_filename
        $coverletter['data'],          // coverletter_data
        $coverletter['filename'],      // coverletter_filename
        $passport['data'],             // photo_data
        $passport['filename'],         // photo_filename
        $ssn, $phoneno, $houseaddress, $bankname, $bankno
    );

    if ($stmt->execute()) {
        header("Location: ../jobs.php?status=applied");
        exit();
    } else {
        echo "Error saving application to database: " . $stmt->error;
    }
}
?>
