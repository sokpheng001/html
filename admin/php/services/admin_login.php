<?php
// using PDO
    // Include environment variables for database connection
    require_once __DIR__.'/../utils/environment_variable.php';


    // Check if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Get email and password from form
        $email = trim($_POST['email']);
        $password =trim($_POST['password']);

        // Database connection
        try {
            $pdo = new PDO("mysql:host=$db_servername;dbname=$database_name", $db_username, $db_password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION    );

            // Check if the email exists in the database
            $stmt = $pdo->prepare("SELECT * FROM admins WHERE email = :email");
            $stmt->execute(['email' => $email]);
            $admin = $stmt->fetch(PDO::FETCH_ASSOC  );

            // If the email exists, verify the password
            if ($admin && password_verify($password, $admin['password'])) {
                 // Store login data in cookies for 1 day (86400 seconds)
                setcookie('admin_id', $admin['uuid'], time() + 86400, "/");  // Cookie for admin ID
                setcookie('admin_logged_in', true, time() + 86400, "/");  // Cookie for admin logged-in status
                header('Location: ../../pages/dashboard.html');
                exit();
            } else {
                // Display the error message in a JavaScript alert
                echo "<script type='text/javascript'>alert('⚠️ អុីម៉៉ែល ឬ លេខសម្ងាត់មិនត្រឹមត្រូវ'); window.location.href = '../../status/login.html';</script>";
                exit();
            }
        } catch (PDOException $e) {
            // Display the error message in a JavaScript alert
            echo "<script type='text/javascript'>
                    alert('មានបញ្ហាក្នុងការតភ្ជាប់ទៅកាន់មូលដ្ឋានទិន្នន័យ: " . $e->getMessage() . "');
                    window.location.href = '../../status/login.html';
                </script>";
        }
    }
?>
