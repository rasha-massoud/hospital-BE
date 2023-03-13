<?php
    include("connection.php"); 

    $user_id= $_POST['user_id'];
    
    if ( $_SESSION['id'] == $user_id){
        $check_patient_id = $mysqli->prepare('select user_id from patients_info where user_id=?');
        $check_patient_id->bind_param('i', $user_id);
        $check_patient_id->execute();
        $check_patient_id->store_result();
        $patient_id_exists = $check_patient_id->num_rows();
    
    
        if ($patient_id_exists > 0) {
    
        $approved=1;
            $servicequery = $mysqli->prepare("select id, employee_id, patient_id, description, cost, department_id, approved from services where patient_id=? and approved=?");
            $servicequery->bind_param('ii', $user_id, $approved);
            $servicequery->execute();
            $servicequery->bind_result($id, $employee_id, $patient_id, $description, $cost, $department_id, $approved);
    
            while ($servicequery->fetch()) {
                $services[] = [
                    'id' => $id,
                    'employee_id' => $employee_id,
                    'patient_id' => $patient_id,
                    'description' => $description,
                    'cost' => $cost,
                    'department_id' => $department_id,
                    'approved' => $approved,
                ];
            }
    
            $response['services'] = $services;
        }
        else{
            $response['status']= "Not found patient id";
        } 
    }
    else{
        $response['status']= "You are not allowed";
    }
    
    echo json_encode($response);

?>

