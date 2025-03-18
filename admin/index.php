<?php
  session_start();
  // Check if the user is logged in by checking the session variable
  if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
      // Redirect to the login page if not logged in
      header('Location: /admin/status/login.html');
      exit();
  }
?>
