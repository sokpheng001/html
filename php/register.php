

<?php
    require_once './model/User.php';
    $db = new User($con);
    $con = mysqli_connect("localhost","root","123");
?>