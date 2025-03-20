<?php
    require_once './model/User.php';
    require_once './utils/customize_hashing.php';
    require_once './utils/database_connect.php';
    require_once './utils/email_generator_config.php';
    require_once __DIR__. '/./utils/environment.php';
    require_once './utils/mail_sender.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $latin_name = $_POST['latin-name'];
        $khmer_name = $_POST['khmer-name'];
        $father_name = $_POST['father-name'];
        $mother_name = $_POST['mother-name'];
        $date_of_birth = $_POST['birth-date'];
        $place_of_birth = $_POST['place-of-birth'];
        $gender = $_POST['gender'];
        $email = $_POST['email'] ?? null;
        $phone = $_POST['phone'];
        $major = $_POST['major'];

        // Database connection
        $conn = $database_connection;
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // ✅ **Check if email already exists**
        $check_email_stmt = $conn->prepare("SELECT id FROM students WHERE original_email = ?");
        $check_email_stmt->bind_param("s", $email);
        $check_email_stmt->execute();
        $result = $check_email_stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<script>alert('⚠️ អ៊ីមែលនេះត្រូវបានប្រើរួចហើយ! សូមប្រើអ៊ីមែលផ្សេងទៀត។'); 
            window.location.href='../pages/register.html';</script>";
            exit();
        }
        $check_email_stmt->close();

        // ✅ **Validate Age**
        $today = new DateTime();
        $dob = new DateTime($date_of_birth);
        $age = $today->diff($dob)->y;
        if ($age < 18) {
            echo "<script>alert('⚠️ អ្នកត្រូវមានអាយុយ៉ាងហោចណាស់ 18 ឆ្នាំដើម្បីចុះឈ្មោះ!'); 
            window.location.href='../pages/register.html';</script>";
            exit();
        }

        // ✅ **Generate User Credentials**
        $uuid = uniqid('', true);
        $user_password = generatePassword();
        $hash_password = hashPassword($user_password);
        $school_email = schoolEmailGenerator($latin_name);
        $account_expired_date = date("Y-m-d", strtotime("+4 years"));
        // random student id
        $stu_id = "RUPP-IT-" . rand(10, 10000);

        // ✅ **Handle File Upload**
        $uploadDir = "../uploads/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $filePath = null;
        if (!empty($_FILES["student-photo"]["name"])) {
            $uuidFileName = uniqid('', true) . "." . strtolower(pathinfo($_FILES["student-photo"]["name"], PATHINFO_EXTENSION));
            $targetFile = $uploadDir . $uuidFileName;
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
            $allowedTypes = ["jpg", "jpeg", "png"];

            if (in_array($imageFileType, $allowedTypes)) {
                if (move_uploaded_file($_FILES["student-photo"]["tmp_name"], $targetFile)) {
                    $filePath = $web_url . "/uploads/" . $uuidFileName;
                } else {
                    echo "Error uploading the file.";
                    exit();
                }
            } else {
                echo "Invalid file type! Only JPG, JPEG, and PNG are allowed.";
                exit();
            }
        }

        // ✅ **Insert into Database**
        $sql = "INSERT INTO students (password, uuid, latin_name, khmer_name, father_name, mother_name, 
                date_of_birth, place_of_birth, gender, school_email, original_email, phone_number, 
                major, expired_date, profile, stu_id) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param(
                $stmt,
                "ssssssssssssssss",
                $hash_password,
                $uuid,
                $latin_name,
                $khmer_name,
                $father_name,
                $mother_name,
                $date_of_birth,
                $place_of_birth,
                $gender,
                $school_email,
                $email,
                $phone,
                $major,
                $account_expired_date,
                $filePath,
                $stu_id
            );

            if (mysqli_stmt_execute($stmt)) {
                header("Location: ../success.html");
                sendMail($email, "Student Credentials for Login", $school_email, $user_password);
                exit();
            } else {
                echo "Error: " . mysqli_error($conn);
            }
            mysqli_stmt_close($stmt);
        } else {
            echo "Error preparing statement: " . mysqli_error($conn);
        }
        mysqli_close($conn);
    } else {
        header("Location: ./register.html");
        exit();
    }
?>
