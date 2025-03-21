<?php
    require_once __DIR__. '/./environment.php';

    // Use getter methods to retrieve the credentials
    $database_connection = mysqli_connect(
        $db_servername,
        $db_username,
        $db_password,
        $database_name,
    );
    // Check connection
    if (!$database_connection) {
        die("Connection failed: " . mysqli_connect_error());
    }
    // echo "Connected successfully!";
?>