// logout.php
<?php
    // Clear the session cookie by setting expiry to past
    setcookie("session", "", time() - 3600, "/", "", true, true);
    // Redirect to home page
    header("Location: /");
    exit();
?>