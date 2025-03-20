<?php
// Include the database connection
require_once '../utils/database_connect.php';

// Use the global database connection
global $database_connection;

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get email and password from form
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // SQL query to check if the email exists
    $sql = "SELECT * FROM admins WHERE email = ?";

    // Prepare the SQL query
    $stmt = mysqli_prepare($database_connection, $sql);

    if (!$stmt) {
        // If preparation fails, display the error
        die("Query preparation failed: " . mysqli_error($database_connection));
    }

    // Bind the parameter (email) to the query
    mysqli_stmt_bind_param($stmt, "s", $email);

    // Execute the statement
    mysqli_stmt_execute($stmt);

    // Get the result
    $result = mysqli_stmt_get_result($stmt);

    // Fetch the admin's data
    $admin = mysqli_fetch_assoc($result);

    // Check if the admin exists and verify the password
    if ($admin && password_verify($password, urldecode($admin['password']))) {
        // Store login data in cookies for 1 day (86400 seconds)
        setcookie('admin_id', $admin['uuid'], time() + 86400, "/");  // Cookie for admin ID
        setcookie('admin_logged_in', true, time() + 86400, "/");  // Cookie for admin logged-in status
        header('Location: ../../pages/dashboard.html');
        exit();
    } else {
        // Display the error message in a JavaScript alert
        echo "<script type='text/javascript'>alert('⚠️ អុីម៉៉ែល ឬ លេខសម្ងាត់មិនត្រឹមត្រូវ'); window.location.href = '../../index.html';</script>";
        exit();
    }

    // Close the statement
    mysqli_stmt_close($stmt);
}
?>
