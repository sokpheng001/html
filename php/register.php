

<?php
    require_once './model/User.php';
    // $db = new User();
    // $con = mysqli_connect("localhost","root","123");
    //
    // Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the data from the form
    $latin_name = $_POST['latin-name'];
    $khmer_name = $_POST['khmer-name'];
    $father_name = $_POST['father-name'];
    $mother_name = $_POST['mother-name'];
    $birth_date = $_POST['birth-date'];
    $place_of_birth = $_POST['place-of-birth'];
    $gender = $_POST['gender'];
    $email = $_POST['email']; // Optional
    $phone = $_POST['phone'];
    $major = $_POST['major'];

    // For example, just print the data for now
    echo "<h1>Form Data Received:</h1>";
    echo "<p>Latin Name: $latin_name</p>";
    echo "<p>Khmer Name: $khmer_name</p>";
    echo "<p>Father's Name: $father_name</p>";
    echo "<p>Mother's Name: $mother_name</p>";
    echo "<p>Birth Date: $birth_date</p>";
    echo "<p>Place of Birth: $place_of_birth</p>";
    echo "<p>Gender: $gender</p>";
    echo "<p>Email: $email</p>";
    echo "<p>Phone: $phone</p>";
    echo "<p>Major: $major</p>";

    // You would typically process and save this data to a database here
        // Redirect to success page after processing
    header("Location: ../success.html");
    exit(); // Make sure no further code is executed after the redirect

} else {
    // If the form is not submitted, redirect to the form page
    header("Location: ./register.html");
    exit();
}
?>