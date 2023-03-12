<?php
    include("connection.php"); 

    $user_id= $_POST['user_id'];
    $hospital_id = $_POST['hospital_id'];
    $is_active = $_POST['is_active'];
    $date_joined = $_POST['date_joined'];
    $date_left = $_POST['date_left'];

    $response = [];

        $check_patient_id = $mysqli->prepare('select user_id from patients_info where user_id=?');
        $check_patient_id->bind_param('i', $user_id);
        $check_patient_id->execute();
        $check_patient_id->store_result();
        $user_id_exists = $check_patient_id->num_rows();

        $check_hospital_id = $mysqli->prepare('select id from hospitals where id=?');
        $check_hospital_id->bind_param('i', $hospital_id);
        $check_hospital_id->execute();
        $check_hospital_id->store_result();
        $hospital_id_exists = $check_hospital_id->num_rows();

        if ($user_id_exists > 0 && $hospital_id_exists > 0) {
            $query = $mysqli->prepare('insert into hospital_users(hospital_id ,user_id , is_active, date_joined, date_left) values(?,?,?,?,?)');
            $query->bind_param('iiiss', $hospital_id, $user_id, $is_active, $date_joined, $date_left);
            $query->execute();
            $response['status'] = "success";
        } else {
            $response['status'] = "failed";
        }
    
    echo json_encode($response);

?>