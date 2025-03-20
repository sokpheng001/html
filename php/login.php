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
        $stmt = $database_connection->prepare("SELECT id, uuid, expired_date, school_email, password FROM students WHERE school_email = ? AND is_deleted = 0");
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
                // set data in cookie
                setcookie("student_email", $user['school_email'], time() + 3600, "/", false, true);
                setcookie("student_password", $password, time() + 3600, "/", false, true);
                setcookie("student_uuid", $user["uuid"], time() + 3600, "/", false, true);
                setcookie("generated_hash", password_hash('123', PASSWORD_DEFAULT), time() + 3600, "/",false,true);
                setcookie("generate_uuid",uniqid('', true), time() + 3600, "/",false,true);
                echo "<script> window.location.href='../pages/account/profile.html?id={$user['uuid']}';</script>";
            } else {
                echo "<script>alert('ពាក្យសម្ងាត់ ឬ អុីម៉ែល មិនត្រឹមត្រូវ!'); window.location.href='../pages/login.html';</script>";

            }
        } else {
            setcookie("student_email", "", time() - 3600, "/"); // Expire the cookie
            setcookie("student_password", "", time() - 3600, "/"); // Expire the cookie
            setcookie("student_uuid", "", time() - 3600, "/"); // Expire the cookie
            echo "<script>alert('គណនីមិនមាន!'); window.location.href='../pages/login.html';</script>"; 
            // echo "<script>alert('គណនីមិនមាន!');</script>"; 


        //     // echo "<script> window.location.href='../pages/login.html';</script>";

        }

        $stmt->close();
        $database_connection->close();
    } else {
        header("Location: ../pages/login.html");
        exit();
    }
?>
