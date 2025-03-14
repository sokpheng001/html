<?php
    require_once './model/User.php';
    require_once './utils/customize_hashing.php';
    require_once './utils/database_connect.php';
    require_once './utils/email_generator_config.php';
    require_once'./utils/mail_sender.php';

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

        // Age validation
        $today = new DateTime();
        $dob = new DateTime($date_of_birth);
        $age = $today->diff($dob)->y;

        if ($age < 18) {
            echo "<script>alert('⚠️ You must be at least 18 years old to register.'); 
            window.location.href='../pages/register.html';</script>";
            exit();
        }

        // Generate user credentials
        $uuid = uniqid('', true);
        $user_password = generatePassword();
        $hash_password = hashPassword($user_password);
        $school_email = schoolEmailGenerator($latin_name);
        $account_expired_date = date("Y-m-d", strtotime("+4 years"));
        $stu_id = "RUPP-IT-".rand(10,10000);

        $uploadDir = "../uploads/";
        // Check if the upload directory exists, if not, create it
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true); // Creates the directory with proper permissions
        }
        // read base url
        $env_location =  __DIR__ . '/../.env';
        $env = parse_ini_file($env_location);
        $base_url = $env["WEB_URL"];

        $filePath = null;
        if (!empty($_FILES["student-photo"]["name"])) {
            // Generate a unique filename using UUID
            $uuidFileName = uniqid('', true) . "." . strtolower(pathinfo($_FILES["student-photo"]["name"], PATHINFO_EXTENSION));
            $targetFile = $uploadDir . $uuidFileName;
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
            $allowedTypes = ["jpg", "jpeg", "png"];

            if (in_array($imageFileType, $allowedTypes)) {
                if (move_uploaded_file($_FILES["student-photo"]["tmp_name"], $targetFile)) {
                    $filePath = $base_url. "/uploads/". $uuidFileName; // Store file path for database insertion
                } else {
                    echo "Error uploading the file.";
                    exit();
                }
            } else {
                echo "Invalid file type! Only JPG, JPEG, and PNG are allowed.";
                exit();
            }
        }
        // Insert into database
        $conn = $database_connection;
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        $sql = "INSERT INTO students (password, uuid, latin_name, khmer_name, father_name, mother_name, 
                date_of_birth, place_of_birth, gender, school_email, original_email, phone_number, 
                major, expired_date, profile, stu_id) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)";

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
                setcookie("student_email", $school_email, time() + 900, "/");
                setcookie("student_password", $user_password, time() + 900, "/");
                        // send mail
                header("Location: ../success.html");
                sendMail($email,"Student Credentail for Login to student account",$school_email,$user_password);
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
