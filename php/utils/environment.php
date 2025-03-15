<?php
    $env_location =  __DIR__ . '/../../.env';
    $env = parse_ini_file($env_location);
    // 
    $web_url = $env["WEB_URL"];
    //
    
    $db_servername= $env['DB_HOST'];
    $db_username =  $env['DB_USER'];
    $db_password =  $env['DB_PASSWORD'];
    $database_name =  $env['DB_NAME'];
    $sender_email =  $env['SENDER_EMAIL'];
    $email_app_pass =  $env['SENDER_EMAIL_APP_PASS'];
?>