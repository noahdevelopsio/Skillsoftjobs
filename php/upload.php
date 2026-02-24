<?php
session_start();
include("config.php");

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
    // (In a real app, you'd handle license, cover letter, etc. We'll simplify to just one required document path for the DB, mapped to Resume to match user intentions previously)
    
    // Using the 'resume' input from the new UI
    $fileInputName = 'resume'; 
    
    if (!isset($_FILES[$fileInputName]) || $_FILES[$fileInputName]['error'] !== UPLOAD_ERR_OK) {
        die("Error: Please upload a valid resume/CV document.");
    }

    $target_dir = "../uploads/";
    
    // Create dir if doesn't exist
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0755, true);
    }
    
    // Generate a secure unique filename
    $file_extension = strtolower(pathinfo($_FILES[$fileInputName]["name"], PATHINFO_EXTENSION));
    $allowed_extensions = ['pdf', 'doc', 'docx'];
    
    if (!in_array($file_extension, $allowed_extensions)) {
        die("Error: Only PDF, DOC, and DOCX files are allowed.");
    }
    
    // Check file size (e.g., 10MB limit)
    if ($_FILES[$fileInputName]["size"] > 10000000) {
        die("Error: File is too large (Maximum 10MB).");
    }

    $unique_filename = uniqid("resume_user{$user_id}_", true) . '.' . $file_extension;
    $target_file = $target_dir . $unique_filename;

    // Attempt to move file
    if (move_uploaded_file($_FILES[$fileInputName]["tmp_name"], $target_file)) {
        
        // --- Database Insertion ---
        // Note: Omit the `id` column from the INSERT since it is AUTO_INCREMENT.
        // `driverlicense_path` is repurposed to store the primary document uploaded.
        
        $sql = "INSERT INTO applications (job_id, user_id, firstname, lastname, gender, email, driverlicense_path, ssn, phoneno, houseaddress, bankname, bankno) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $con->prepare($sql);
        if (!$stmt) {
            die("Database Error: " . $con->error);
        }
        
        // Bind parameters (2 integers + 10 strings)
        $stmt->bind_param("iissssssssss", $job_id, $user_id, $firstname, $lastname, $gender, $email, $target_file, $ssn, $phoneno, $houseaddress, $bankname, $bankno);

        if ($stmt->execute()) {
            // Redirect to a success page or back to jobs with a success flag
            header("Location: ../jobs.php?status=applied");
            exit();
        } else {
            echo "Error saving application to database: " . $stmt->error;
        }
        
    } else {
        echo "Sorry, there was an unknown error uploading your file. Check directory permissions.";
    }
}
?>
