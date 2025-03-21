<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    
    require_once '../utils/database_connect.php';
    
    // Function to search for a student by ID (case-sensitive LIKE search)
    function searchStudentById($stu_id) {
        global $database_connection;
    
        // SQL query using LIKE instead of =
        $sql = "SELECT uuid, khmer_name, latin_name, father_name, mother_name, date_of_birth, place_of_birth,
                       original_email, school_email, phone_number, profile, major, gender, expired_date, stu_id
                FROM students WHERE stu_id LIKE ? AND is_deleted = 0 LIMIT 1"; 
    
        if ($stmt = mysqli_prepare($database_connection, $sql)) {
            // Add wildcards for partial matching (e.g., searching "123" will match "12345")
            $stu_id = $stu_id . '%';  // Adjust this to '%'.$stu_id.'%' for a more flexible search
            
            // Bind the parameter
            mysqli_stmt_bind_param($stmt, "s", $stu_id);
        
            // Execute the query
            mysqli_stmt_execute($stmt);
        
            // Fetch results
            $result = mysqli_stmt_get_result($stmt);
            
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
