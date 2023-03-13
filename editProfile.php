<?php
    include("connection.php"); 

    $id= $_POST['id'];
    $name= $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $dob = $_POST['dob'];

    $response = [];

    if (!isset($_SESSION['id'])) {
        header('Location: /Hospital_FrontEnd/HTML/login.html');
        exit;
    }
    
    if(filter_var($email, FILTER_VALIDATE_EMAIL)){
        $response["email_status"] = "The Email Format is Valid!";
    } else {
        $response["email_status"] = "Sorry! Invalid Email Format!";
    }

    if(preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[^a-zA-Z\d]).{8,}$/', $password)) {
        $response["password_status"] = "Strong password.";
    } else {
        $response["password_status"] = "Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.";
    }

    $response["status"] = filter_var($email, FILTER_VALIDATE_EMAIL) && preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[^a-zA-Z\d]).{8,}$/', $password);

    if($response['status']){
        $check_id = $mysqli->prepare('select id from users where id=?');
        $check_id->bind_param('i', $id);
        $check_id->execute();
        $check_id->store_result();
        $id_exists = $check_id->num_rows();

        $check_patient = $mysqli->prepare('select user_id from patients_info where user_id=?');
        $check_patient->bind_param('i', $id);
        $check_patient->execute();
        $check_patient->store_result();
        $patient_exists = $check_patient->num_rows();

        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        if ($id_exists > 0 && $patient_exists > 0) {
            $user_type_id=1;
            $query = $mysqli->prepare('update users set id=?, name=?, email=?, password=?, dob=?, user_type_id=? where id=?');
            $query->bind_param('issssii', $id, $name, $email, $password, $dob, $user_type_id ,$id);
            $query->execute();
            $response['status'] = "success";
        } else {
            $response['status'] = "failed";
        }
    }
    echo json_encode($response);

?>


