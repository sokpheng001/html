<?php
error_reporting(E_ALL);  // Enable all error reporting for debugging
ini_set('display_errors', 1); // Show errors on the page

require_once '../utils/database_connect.php';

// Function to get all users
    function getAllUsers() {
        global $database_connection; // Make sure to use the existing database connection

        // SQL query to get all students where 'is_deleted' is 0
        $sql = "SELECT uuid, khmer_name, latin_name, father_name, mother_name, date_of_birth, place_of_birth,
                       original_email, school_email, phone_number, profile, major, gender, expired_date, stu_id
                FROM students WHERE is_deleted = 0";
        
        $result = mysqli_query($database_connection, $sql);

        if (!$result) {
            // If query fails, display the error and return an empty array
            die("Query failed: " . mysqli_error($database_connection));
        }

        // Fetch all rows and store them in an array
        $users = [];
        while ($row = mysqli_fetch_assoc($result)) {
            // Exclude id and password, since they are not selected in the SQL query
            $users[] = $row;
        }

        // Optionally, close the connection if not used elsewhere
        // mysqli_close($conn);

        // Return the array of users in JSON format
        header('Content-Type: application/json');
        echo json_encode($users, JSON_PRETTY_PRINT);
    }


// Function to delete a user by stu_id
function deleteUser($stu_id) {

    global $database_connection;
    

    // SQL query to delete user based on stu_id
    $sql = "UPDATE students SET is_deleted = 1 WHERE stu_id = ?";

    if ($stmt = mysqli_prepare($database_connection, $sql)) {
        // Bind the stu_id parameter to the SQL query
        mysqli_stmt_bind_param($stmt, "s", $stu_id);

        // Execute the query
        if (mysqli_stmt_execute($stmt)) {
            echo json_encode(['message' => 'User deleted successfully']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to delete user']);
        }

        // Close statement
        mysqli_stmt_close($stmt);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to prepare statement']);
    }
}

// Function to create a user
function createUser($data) {
    global $database_connection;

    // SQL query to insert a new user
    $sql = "INSERT INTO students (uuid, khmer_name, latin_name, father_name, mother_name, date_of_birth, 
            place_of_birth, original_email, school_email, phone_number, profile, major, gender, expired_date)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = mysqli_prepare($database_connection, $sql)) {
        // Bind parameters for the query
        mysqli_stmt_bind_param($stmt, "ssssssssssssss", 
            $data['uuid'], $data['khmer_name'], $data['latin_name'], $data['father_name'], $data['mother_name'],
            $data['date_of_birth'], $data['place_of_birth'], $data['original_email'], $data['school_email'], 
            $data['phone_number'], $data['profile'], $data['major'], $data['gender'], $data['expired_date']
        );

        // Execute the query
        if (mysqli_stmt_execute($stmt)) {
            echo json_encode(['message' => 'User created successfully']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to create user']);
        }

        // Close statement
        mysqli_stmt_close($stmt);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to prepare statement']);
    }
}

// Function to update a user's details
function updateUser($stu_id, $data) {
    global $database_connection;

    // SQL query to update a user's details
    $sql = "UPDATE students SET 
                khmer_name = ?, latin_name = ?, father_name = ?, mother_name = ?, date_of_birth = ?, 
                place_of_birth = ?, original_email = ?, school_email = ?, phone_number = ?, profile = ?, 
                major = ?, gender = ?, expired_date = ? 
            WHERE stu_id = ?";

    if ($stmt = mysqli_prepare($database_connection, $sql)) {
        // Bind parameters for the query
        mysqli_stmt_bind_param($stmt, "ssssssssssssss", 
            $data['khmer_name'], $data['latin_name'], $data['father_name'], $data['mother_name'], 
            $data['date_of_birth'], $data['place_of_birth'], $data['original_email'], $data['school_email'], 
            $data['phone_number'], $data['profile'], $data['major'], $data['gender'], 
            $data['expired_date'], $stu_id
        );

        // Execute the query
        if (mysqli_stmt_execute($stmt)) {
            echo json_encode(['message' => 'User updated successfully']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to update user']);
        }

        // Close statement
        mysqli_stmt_close($stmt);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to prepare statement']);
    }
}

// Check the HTTP method and perform corresponding action
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['read'])) {
    // Perform the read operation
    getAllUsers();
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['create'])) {
    // Perform the create operation
    $data = $_POST; // You would sanitize and validate these inputs
    createUser($data);
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update']) && isset($_POST['stu_id'])) {
    // Perform the update operation
    $stu_id = $_POST['stu_id'];
    $data = $_POST; // You would sanitize and validate these inputs
    updateUser($stu_id, $data);
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete']) && isset($_POST['stu_id'])) {
    // Perform the delete operation
    $stu_id = $_POST['stu_id'];
    deleteUser($stu_id);
}

?>
