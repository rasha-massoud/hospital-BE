<?php
    include("connection.php"); 

    $user_id= $_POST['user_id'];

    $check_patient_id = $mysqli->prepare('select user_id from patients_info where user_id=?');
    $check_patient_id->bind_param('i', $user_id);
    $check_patient_id->execute();
    $check_patient_id->store_result();
    $patient_id_exists = $check_patient_id->num_rows();

    if ($patient_id_exists > 0) {
        $query = $mysqli->prepare("select id, user_id, blood_type, EHR from patients_info where user_id=?");
        $query->bind_param('i', $user_id);
        $query->execute();
        $query->bind_result($id, $user_id, $blood_type, $EHR);

        if ($query->fetch()){
            $response = [
                "id" => $id,
                "user_id" => $user_id,
                "blood_type" => $blood_type,
                "EHR" => $EHR,
            ];
        }

        echo json_encode($response);
    } 
?>

