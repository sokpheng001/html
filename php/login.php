<?php
session_start();
include './utils/database_connect.php'; // Include database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {
        echo "<script>alert('សូមបំពេញព័ត៌មានអ៊ីមែល និងពាក្យសម្ងាត់!'); window.location.href='../pages/login.html';</script>";
        exit();
    }
    // Prepare and execute the SQL query
    $stmt = $database_connection->prepare("SELECT id, uuid, expired_date, school_email, password FROM students WHERE school_email = ? AND id_deleted = 0");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Check if the account is expired
        $current_date = date("Y-m-d");
        $expired_date = $user['expired_date'];

        if ($expired_date < $current_date) {
            echo "<script>alert('គណនីនេះបានផុតកំណត់!'); window.location.href='../pages/login.html';</script>";
            exit();
        }

        // Check if the password is correct
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['school_email'];
            echo "<script>alert('ចូលបានជោគជ័យ!'); window.location.href='../pages/account/profile.html?id={$user['uuid']}';</script>";
        } else {
            echo "<script>alert('ពាក្យសម្ងាត់មិនត្រឹមត្រូវ!'); window.location.href='../pages/login.html';</script>";
        }
    } else {
        echo "<script>alert('គណនីមិនមាន!'); window.location.href='../pages/login.html';</script>";
    }

    $stmt->close();
    $database_connection->close();
} else {
    header("Location: ../html/login.html");
    exit();
}
?>
