<?php
    include("connection.php"); 
    session_start();
    // $_SESSION['id'] = $id;

    $hospitals = [];
    $query = $mysqli->prepare("SELECT * FROM employees_info");
    $query->execute();
    $query->bind_result($id, $user_id, $SSN, $date_joined, $position, $hospital_id);

    while ($query->fetch()) {
        $hospital = [
            "id" => $id,
            "user_id" => $user_id,
            "SSN" => $SSN,
            "date_joined" => $date_joined,
            "position" => $position,
            "hospital_id" => $hospital_id,
        ];
        $hospitals[] = $hospital;
    }

    echo json_encode($hospitals);
?>