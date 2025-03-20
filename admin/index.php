<?php
    // Get the current URL path
    $requestUri = $_SERVER['REQUEST_URI'];
    
    // Check if the path is '/admin' or '/admin/'
    if ($requestUri === '/admin' || $requestUri === '/admin/') {
        // Redirect to '/admin/index.html'
        header('Location: /admin/index.html');
        exit(); // Always call exit after a header redirect to prevent further code execution
    }
?>
