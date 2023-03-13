<?php
    include("connection.php"); 

    session_start();
    $user_type_id = $_POST['user_type_id'];
    
    if (!isset($_SESSION['id'])) {
        header('Location: /Hospital_FrontEnd/HTML/login.html');
        exit;
    }
    
    if ($user_type_id == 1) { // user is a patient
        $query = $mysqli->prepare('SELECT COUNT(*) FROM users WHERE user_type_id = ?');
        $query->bind_param('i', $user_type_id);
        $query->execute();
        $query->bind_result($num_patients);
        $query->fetch();
    
        $response['status']= "There are " . $num_patients . " patients.";
    } else if ($user_type_id == 2) { // user is an employee
        $query = $mysqli->prepare('SELECT COUNT(*) FROM users WHERE user_type_id = 2');
        $query->execute();
        $query->bind_result($num_employees);
        $query->fetch();
    
        $response['status']= "There are " . $num_employees . " employees.";
    }
    echo json_encode($response);
?>