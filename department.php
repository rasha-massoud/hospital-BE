<?php
    include("connection.php"); 

    $user_id= $_POST['user_id'];
    $department_id = $_POST['department_id'];
    $hospital_id = $_POST['hospital_id'];
    $room_id = $_POST['room_id'];
    $datetime_entered = $_POST['datetime_entered'];
    $datetime_left = $_POST['datetime_left'];
    $bed_number = $_POST['bed_number'];

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

    $check_department_id = $mysqli->prepare('select id from departments where id=?');
    $check_department_id->bind_param('i', $department_id);
    $check_department_id->execute();
    $check_department_id->store_result();
    $department_id_exists = $check_department_id->num_rows();
    
    $check_room_id = $mysqli->prepare('select id from rooms where id=?');
    $check_room_id->bind_param('i', $room_id);
    $check_room_id->execute();
    $check_room_id->store_result();
    $room_id_exists = $check_room_id->num_rows();

    $check_bed_number = $mysqli->prepare('select number_beds from rooms where id=?');
    $check_bed_number->bind_param('i', $room_id);
    $check_bed_number->execute();
    $check_bed_number->store_result();
    $bed_id_exists = $check_bed_number->num_rows();

    if($bed_id_exists){
        $check_bed_number->bind_result($number_beds);
        $check_bed_number->fetch();
        if ($number_beds < $bed_number) {
            $response['status'] = "fail";
        }elseif ($room_id_exists > 0 && $department_id_exists > 0 && $user_id_exists > 0 && $hospital_id_exists > 0){

            $query = $mysqli->prepare('insert into user_departments(user_id, department_id ,hospital_id ) values(?,?,?)');
            $query->bind_param('iii', $user_id, $department_id, $hospital_id);
            $query->execute();

            $query = $mysqli->prepare('insert into user_rooms(user_id, room_id, datetime_entered, datetime_left, bed_number) values(?,?,?,?,?)');
            $query->bind_param('iisss', $user_id, $room_id, $datetime_entered, $datetime_left, $bed_number);
            $query->execute();

            $response['status'] = "success";
        } else {
            $response['status'] = "failed";
        }
    }
    echo json_encode($response);

?>