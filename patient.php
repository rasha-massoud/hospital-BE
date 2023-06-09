<?php
    include("connection.php"); 
    session_start();
    // $_SESSION['id'] = $id;

    if (!isset($_SESSION['id'])) {
        header('Location: /Hospital_FrontEnd/HTML/login.html');
        exit;
    }
    
    $hospitals = [];
    $query = $mysqli->prepare("SELECT * FROM patients_info");
    $query->execute();
    $query->bind_result($id, $user_id, $blood_type, $EHR);

    while ($query->fetch()) {
        $hospital = [
            "id" => $id,
            "user_id" => $user_id,
            "blood_type" => $blood_type,
            "EHR" => $EHR,
        ];
        $hospitals[] = $hospital;
    }

    echo json_encode($hospitals);
?>