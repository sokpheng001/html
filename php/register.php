

<?php
    require_once './model/User.php';
    $user = new User();
    $user->setId(12);
    echo $user->getId()
    // $con = mysqli_connect("localhost","root","123");
?>