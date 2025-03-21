<?php
    $env_location =  __DIR__ . '/../../.env';
    $env = parse_ini_file($env_location);
    // Check if the file is loaded correctly
    // if ($env === false) {
    //     die("Failed to load environment variables from the .env file.");
    // }
    //
    
    $db_servername= $env['DB_HOST'];
    $db_username =  $env['DB_USER'];
    $db_password =  $env['DB_PASSWORD'];
    $database_name =  $env['DB_NAME'];
?>