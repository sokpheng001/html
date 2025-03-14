<?php
    session_start();
    include '../utils/database_connect.php'; // Include database connection
    
    header('Content-Type: application/json');
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $uuid = trim($_POST['uuid']);
    
        // Check if UUID is null or empty
        if (empty($uuid)) {
            echo json_encode(["success" => false, "message" => "UUID is required"]);
            exit();
        }
    
        // Validate UUID format (UUIDv4 format)
        // if (!preg_match('/^[0-9a-fA-F]{8}-[0-9a-fA-F]{4}-[0-9a-fA-F]{4}-[0-9a-fA-F]{4}-[0-9a-fA-F]{12}$/', $uuid)) {
        //     echo json_encode(["success" => false, "message" => "Invalid UUID format"]);
        //     exit();
        // }
    
        // Prepare and execute the SQL query to select the fields excluding `id`
        $stmt = $database_connection->prepare("SELECT uuid, khmer_name, latin_name, father_name, mother_name, date_of_birth, 
                                                        place_of_birth, gender, original_email, school_email, phone_number, 
                                                        profile, major, expired_date,password FROM students WHERE uuid = ? AND is_deleted=0");
        $stmt->bind_param("s", $uuid);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            echo json_encode([
                "success" => true,
                "uuid" => $user['uuid'],
                "khmer_name" => $user['khmer_name'],           // Khmer name
                "latin_name" => $user['latin_name'],           // Latin name
                "father_name" => $user['father_name'],         // Father's name
                "mother_name" => $user['mother_name'],         // Mother's name
                "date_of_birth" => $user['date_of_birth'],     // Date of birth
                "place_of_birth" => $user['place_of_birth'],   // Place of birth
                "gender" => $user['gender'],                   // Gender
                "original_email" => $user['original_email'],   // Original email (nullable)
                "school_email" => $user['school_email'],       // School email (unique)
                "phone_number" => $user['phone_number'],       // Phone number
                "profile" => $user['profile'],                 // Profile (nullable)
                "major" => $user['major'],                     // Major
                "expired_date" => $user['expired_date'],
                // "password" =>$user['password']
                      // Expiry date (nullable)
            ]);
        } else {
            echo json_encode(["success" => false, "message" => "User not found"]);
        }
    
        $stmt->close();
        $database_connection->close();
    } else {
        echo json_encode(["success" => false, "message" => "Invalid request"]);
    }
?>
