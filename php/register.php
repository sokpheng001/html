<?php
require_once './model/User.php'; // Assuming you have a User class for DB interaction
require_once './utils/customize_hashing.php'; // If you have a custom hashing utility
require_once './utils/database_connect.php';
require_once './utils/email_generator_config.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the data from the form
    $latin_name = $_POST['latin-name'];
    $khmer_name = $_POST['khmer-name'];
    $father_name = $_POST['father-name'];
    $mother_name = $_POST['mother-name'];
    $date_of_birth = $_POST['birth-date'];
    $place_of_birth = $_POST['place-of-birth'];
    $gender = $_POST['gender'];
    $email = $_POST['email']; // Optional
    $phone = $_POST['phone'];
    $major = $_POST['major'];

    // create a user
    $u_id = rand(1,99999);// id
        // Generate a UUID in PHP
    $uuid = uniqid('', true);
        // generate password and hash it for student
    $user_password = generatePassword();
    $hash_password = hashPassword($user_password);
    // random school email for student
    $school_email = schoolEmailGenerator($latin_name);
    //  
    $expire = new DateTime();
    $user = new User($u_id,$uuid,
     $khmer_name,
     $latin_name, 
     $father_name,
      $mother_name, 
      $date_of_birth, $place_of_birth,
      $email, $school_email, $phone, $hash_password,
      "",$major,new DateTime($expire->format('Y-m-d H:i:s')));

    // Create a connection
    $conn = $database_connection;
    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    // echo "Connected successfully!";

    // Prepare the SQL query to insert the data into the database
    $sql = "INSERT INTO students (password,uuid,latin_name, khmer_name, 
    father_name, mother_name, 
    date_of_birth, place_of_birth, 
    gender, school_email, phone_number, major)
            VALUES (?,?,?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";


    // Prepare the statement
    if ($stmt = mysqli_prepare($conn, $sql)) {
        // Bind the parameters to the query
        mysqli_stmt_bind_param($stmt, "ssssssssssss",
        $hash_password,
        $uuid,$latin_name , 
        $khmer_name, $father_name,
         $mother_name, $date_of_birth,
          $place_of_birth, $gender,
           $school_email, $phone, $major);

        // Execute the statement
        if (mysqli_stmt_execute($stmt)) {
            // echo "Your email: ".$school_email."<br/>";
            // echo "Your password: ".$user_password."<br/>";
            // Set cookies BEFORE any output
            setcookie("student_email", $school_email, time() + 900, "/"); // Expires in 15 minutes (900 seconds)
            setcookie("student_password", $user_password, time() + 900, "/"); // Expires in 15 minutes (900 seconds)

            // redirect to success page
            header("Location: ../success.html");
            exit();
        } else {
            echo "Error: " . mysqli_error($conn);
        }
        // Close the statement
        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing statement: " . mysqli_error($conn);
    }

    // Close the connection
    mysqli_close($conn);

} else {
    // If the form is not submitted, redirect to the form page
    header("Location: ./register.html");
    exit();
}
?>
