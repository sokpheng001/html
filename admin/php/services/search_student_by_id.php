<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    
    require_once '../utils/database_connect.php';
    
    // Function to search student by ID
    function searchStudentById($stu_id) {
        global $database_connection;
    
        // SQL query to search for a student by stu_id
        $sql = "SELECT uuid, khmer_name, latin_name, father_name, mother_name, date_of_birth, place_of_birth,
                       original_email, school_email, phone_number, profile, major, gender, expired_date, stu_id
                FROM students WHERE stu_id = ? AND is_deleted = 0 LIMIT 1"; // Search only non-deleted students
    
        if ($stmt = mysqli_prepare($database_connection, $sql)) {
            // Bind stu_id to the query
            mysqli_stmt_bind_param($stmt, "s", $stu_id);
        
            // Execute the query
            mysqli_stmt_execute($stmt);
        
            // Bind the result to variables
            $result = mysqli_stmt_get_result($stmt);
            
            // Check if any result is found
            if ($row = mysqli_fetch_assoc($result)) {
                // Return the student data as JSON
                echo json_encode($row, JSON_PRETTY_PRINT);
            } else {
                echo json_encode(['error' => 'Student not found']);
            }
        
            // Close the statement
            mysqli_stmt_close($stmt);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to prepare statement']);
        }
    }
    
    // Check if the request is a GET request with a 'search' parameter
    if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['search'])) {
        $stu_id = $_GET['search'];
        searchStudentById($stu_id);
    }

?>
