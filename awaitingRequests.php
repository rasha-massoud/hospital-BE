<?php
    include("connection.php"); 
    session_start();
    // $_SESSION['id'] = $id;

    if (!isset($_SESSION['id'])) {
        header('Location: /Hospital_FrontEnd/HTML/login.html');
        exit;
    }
    
    $requests = [];
    $query = $mysqli->prepare("SELECT * FROM services");
    $query->execute();
    $query->bind_result($id, $employee_id  , $patient_id , $description, $cost, $department_id, $approved);

    while ($query->fetch()) {
        $request = [
            "id"=>$id ,
            "employee_id " => $employee_id ,
            "patient_id" => $patient_id,
            "description" => $description,
            "cost" => $cost,
            "department_id" => $department_id,
            "approved" => $approved,
        ];
        $requests[] = $request;
    }

    echo json_encode($requests);
?>