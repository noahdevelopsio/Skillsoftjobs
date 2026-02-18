<?php
session_start();
include("config.php");

// Check if the user is logged in
if (!isset($_SESSION['valid'])) {
    header("Location: login.php");
    exit();
}

// Retrieve the logged-in user's ID from the session
$id = $_SESSION['id'];  // Assuming you store the user id in session

// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Get form data
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $driverlicense = $_FILES['driverlicense'];
    $ssn = $_POST['ssn'];
    $phoneno = $_POST['phoneno'];
    $houseaddress = $_POST['houseaddress'];
    $bankname = $_POST['bankname'];
    $bankno = $_POST['bankno'];

    // File upload logic
    $target_dir = "../uploads/";  // Directory where the uploaded file will be stored
    
    // Generate a unique filename to prevent overwriting
    $file_extension = strtolower(pathinfo($_FILES["driverlicense"]["name"], PATHINFO_EXTENSION));
    $unique_filename = uniqid("license_", true) . '.' . $file_extension;
    $target_file = $target_dir . $unique_filename;
    
    $uploadOk = 1;
    $imageFileType = $file_extension;

    // Check if file is a valid image
    $check = getimagesize($_FILES["driverlicense"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check if the file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Check file size (optional, set to 5MB here)
    if ($_FILES["driverlicense"]["size"] > 5000000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        // If everything is ok, try to upload file
        if (move_uploaded_file($_FILES["driverlicense"]["tmp_name"], $target_file)) {
            // File uploaded successfully, now save form data along with the image path into the database
            $sql = "INSERT INTO applications (id, firstname, lastname, gender, email, driverlicense_path, ssn, phoneno, houseaddress, bankname, bankno) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            
            $stmt = $con->prepare($sql);
            $stmt->bind_param("issssssssss", $id, $firstname, $lastname, $gender, $email, $target_file, $ssn, $phoneno, $houseaddress, $bankname, $bankno);

            if ($stmt->execute()) {
                echo "Application submitted successfully!";
            } else {
                echo "Error: " . $sql . "<br>" . $con->error;
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
$con->close();
?>
