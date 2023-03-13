<?php
    session_start();
    unset($_SESSION['jwt_token']);
    session_destroy();
    // header("Location: login.php"); // or wherever you want to redirect after logout
    header('Location: /Hospital_FrontEnd/HTML/login.html');

?>