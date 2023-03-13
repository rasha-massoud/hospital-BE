<?php
    session_start();
    unset($_SESSION['jwt_token']);
    session_destroy();
    header("Location: index.php"); // or wherever you want to redirect after logout
?>