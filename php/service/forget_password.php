<?php
session_start();
require '../utils/database_connect.php'; // Include database connection

header('Content-Type: application/json'); // Ensure JSON response

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $new_password = trim($_POST['new_password']);
    $confirm_password = trim($_POST['confirm_password']);

    if (empty($email) || empty($new_password) || empty($confirm_password)) {
        echo json_encode(["success" => false, "message" => "សូមបំពេញព័ត៌មានទាំងអស់!"]);
        exit();
    }

    // Check if new password and confirm password match
    if ($new_password !== $confirm_password) {
        echo json_encode(["success" => false, "message" => "ពាក្យសម្ងាត់ថ្មីនិងការបញ្ជាក់ពាក្យសម្ងាត់មិនត្រូវគ្នា!"]);
        exit();
    }

    // Prepare and execute the SQL query to fetch the user by email
    $stmt = $database_connection->prepare("SELECT id FROM students WHERE school_email = ? AND is_deleted = 0");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Hash the new password
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        // Update the password in the database
        $update_stmt = $database_connection->prepare("UPDATE students SET password = ? WHERE school_email = ?");
        $update_stmt->bind_param("ss", $hashed_password, $email);

        if ($update_stmt->execute()) {
            echo json_encode(["success" => true, "message" => "ពាក្យសម្ងាត់ត្រូវបានអាប់ដេតដោយជោគជ័យ!"]);
        } else {
            echo json_encode(["success" => false, "message" => "មានកំហុសក្នុងការអាប់ដេតពាក្យសម្ងាត់!"]);
        }
        $update_stmt->close();
    } else {
        echo json_encode(["success" => false, "message" => "អ៊ីមែលមិនមាននៅក្នុងប្រព័ន្ធ!"]);
    }

    $stmt->close();
    $database_connection->close();
} else {
    echo json_encode(["success" => false, "message" => "Invalid request method"]);
}
