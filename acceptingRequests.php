<?php
    include("connection.php"); 
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization");

    if (!isset($_SESSION['id'])) {
        header('Location: /Hospital_FrontEnd/HTML/login.html');
        exit;
    }
    
    session_start();
    if( isset($_POST['employee_id']) || isset($_POST['patient_id']) || isset($_POST['description']) || isset($_POST['cost']) || isset($_POST['department_id']) || isset($_POST['approved'])){
        $employee_id= $_POST['employee_id'];
        $patient_id = $_POST['patient_id'];
        $description = $_POST['description'];
        $cost = $_POST['cost'];
        $department_id = $_POST['department_id'];
        $approved = $_POST['approved'];

        $response = [];

        $check_patient_id = $mysqli->prepare('select user_id from patients_info where user_id=?');
        $check_patient_id->bind_param('i', $patient_id);
        $check_patient_id->execute();
        $check_patient_id->store_result();
        $user_id_exists = $check_patient_id->num_rows();

        $check_employer_id = $mysqli->prepare('select user_id from employees_info where user_id=?');
        $check_employer_id->bind_param('i', $employee_id);
        $check_employer_id->execute();
        $check_employer_id->store_result();
        $employer_id_exists = $check_employer_id->num_rows();

        if ($user_id_exists > 0 && $employer_id_exists > 0) {
            $query = $mysqli->prepare('update services set approved=? where employee_id=? and patient_id=? and description=? and cost=? and department_id=?');
            $query->bind_param('iiisii', $approved, $employee_id, $patient_id, $description, $cost, $department_id);
            $query->execute();
            $response['status'] = "success";
        } else {
            $response['status'] = "failed";
        }
        echo json_encode($response);
        
    }


?>