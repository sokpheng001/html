<?php
require_once __DIR__.'/../utils/database_connect.php'; // Make sure this file is included for DB connection
require_once __DIR__.'/../utils/environment.php';

// Check if the request is a POST and contains the necessary data
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["profile-photo"]) && isset($_POST["uuid"])) {
    
    // Get the UUID from the POST data
    $uuid = $_POST["uuid"];
    // Get the uploaded file
    $profilePhoto = $_FILES["profile-photo"];
    
    // Validate the file type (jpg, jpeg, png)
    $allowedTypes = ["jpg", "jpeg", "png"];
    $imageFileType = strtolower(pathinfo($profilePhoto["name"], PATHINFO_EXTENSION));
    
    if (in_array($imageFileType, $allowedTypes)) {
        
        // Create a unique file name for the uploaded file
        $uploadDir = "../../uploads/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true); // Create the directory if it doesn't exist
        }

        $newFileName = uniqid('', true) . "." . $imageFileType;
        $targetFile = $uploadDir . $newFileName;

        // Move the uploaded file to the target directory
        if (move_uploaded_file($profilePhoto["tmp_name"], $targetFile)) {
            // Build the file URL
            $filePath =$web_url. "/uploads/" . $newFileName;

            // Prepare SQL query to update the profile picture in the database
            $sql = "UPDATE students SET profile = ? WHERE uuid = ?";
            
            // Database connection
            $conn = $database_connection;
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }
            // Prepare and execute the SQL statement
            if ($stmt = mysqli_prepare($conn, $sql)) {
                mysqli_stmt_bind_param($stmt, "ss", $filePath, $uuid);

                if (mysqli_stmt_execute($stmt)) {
                    // Return success response
                    echo json_encode(["success" => true, "message"=> "Updated profile picture successfully"]);
                } else {
                    // Return error response if the query fails
                    echo json_encode(["success" => false, "message" => "Error updating profile picture in database."]);
                }
                mysqli_stmt_close($stmt);
            } else {
                echo json_encode(["success" => false, "message" => "Error preparing database query."]);
            }
            mysqli_close($conn);
        } else {
            // If file upload fails
            echo json_encode(["success" => false, "message" => "Error uploading the file."]);
        }
    } else {
        // Invalid file type
        echo json_encode(["success" => false, "message" => "Invalid file type! Only JPG, JPEG, and PNG are allowed."]);
    }
} else {
    // Missing required data (file or UUID)
    echo json_encode(["success" => false, "message" => "Missing required data."]);
}
?>
