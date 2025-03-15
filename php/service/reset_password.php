<?php
    session_start();
    require '../utils/database_connect.php'; // Include database connection

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = trim($_POST['email']);
        $new_password = trim($_POST['new_password']);
        $confirm_password = trim($_POST['confirm_password']);

        if (empty($email) || empty($new_password) || empty($confirm_password)) {
            echo "<script>alert('សូមបំពេញព័ត៌មានទាំងអស់!'); window.location.href='../../pages/account/reset-password.html';</script>";
            exit();
        }

        // Check if new password and confirm password match
        if ($new_password !== $confirm_password) {
            echo "<script>alert('ពាក្យសម្ងាត់ថ្មីនិងការបញ្ជាក់ពាក្យសម្ងាត់មិនត្រូវគ្នា!'); window.location.href='../../pages/account/reset-password.html';</script>";
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
                echo "<script>alert('ពាក្យសម្ងាត់ត្រូវបានអាប់ដេតដោយជោគជ័យ!'); window.location.href='../../pages/login.html';</script>";
            } else {
                echo "<script>alert('មានកំហុសក្នុងការអាប់ដេតពាក្យសម្ងាត់!'); window.location.href='../../pages/account/reset-password.html';</script>";
            }
            $update_stmt->close();
        } else {
            echo "<script>alert('មានកំហុសក្នុងការអាប់ដេតពាក្យសម្ងាត់!'); window.location.href='../../pages/account/reset-password.html';</script>";
        }

        $stmt->close();
        $database_connection->close();
    } else {
        // Redirect to the update password page if accessed directly
        header("Location: ../../pages/account/reset-password.html");
        exit();
    }
?>
