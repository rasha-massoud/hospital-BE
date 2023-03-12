<?php
    include("connection.php"); 

    $user_id= $_POST['user_id'];
    $medication_id = $_POST['medication_id'];
    $quantity = $_POST['quantity'];

    $response = [];

    $check_patient_id = $mysqli->prepare('select user_id from patients_info where user_id=?');
    $check_patient_id->bind_param('i', $user_id);
    $check_patient_id->execute();
    $check_patient_id->store_result();
    $user_id_exists = $check_patient_id->num_rows();

    $check_medication_id = $mysqli->prepare('select id from medications where id=?');
    $check_medication_id->bind_param('i', $medication_id);
    $check_medication_id->execute();
    $check_medication_id->store_result();
    $medication_id_exists = $check_medication_id->num_rows();

    if ($medication_id_exists > 0 && $user_id_exists > 0) {
        $query = $mysqli->prepare('insert into users_medications(user_id ,medication_id , quantity) values(?,?,?)');
        $query->bind_param('iii', $user_id, $medication_id, $quantity);
        $query->execute();
        $response['status'] = "success";

    } else {
        $response['status'] = "failed";
    }
    
    echo json_encode($response);

?>