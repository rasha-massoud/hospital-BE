<?php
    include("connection.php"); 

    $employee_id= $_POST['employee_id'];
    $patient_id = $_POST['patient_id'];
    $description = $_POST['description'];
    $cost = $_POST['cost'];
    $department_id = $_POST['department_id'];
    $approved=1;

    if (!isset($_SESSION['id'])) {
        header('Location: /Hospital_FrontEnd/HTML/login.html');
        exit;
    }
    
    $response = [];

    $check_patient_id = $mysqli->prepare('select user_id from patients_info where user_id=?');
    $check_patient_id->bind_param('i', $patient_id);
    $check_patient_id->execute();
    $check_patient_id->store_result();
    $user_id_exists = $check_patient_id->num_rows();

    $check_employee_id = $mysqli->prepare('select user_id from employees_info where user_id=?');
    $check_employee_id->bind_param('i', $employee_id);
    $check_employee_id->execute();
    $check_employee_id->store_result();
    $employee_id_exists = $check_employee_id->num_rows();

    $check_department_id = $mysqli->prepare('select id from departments where id=?');
    $check_department_id->bind_param('i', $department_id);
    $check_department_id->execute();
    $check_department_id->store_result();
    $department_id_exists = $check_department_id->num_rows();

    if($user_id_exists > 0 && $employee_id_exists > 0 && $department_id_exists > 0 ){
        $query = $mysqli->prepare('insert into services(employee_id, patient_id ,description, cost, department_id, approved) values(?,?,?,?,?,?)');
        $query->bind_param('iisiii', $employee_id, $patient_id, $description, $cost, $department_id, $approved);
        $query->execute();

        $response['status'] = "success";
    } else {
        $response['status'] = "failed";
    }
    echo json_encode($response);

?>