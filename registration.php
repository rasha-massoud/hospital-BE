<?php
    include("connection.php"); 

    $name= $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $dob = $_POST['dob'];
    $user_type_id = $_POST['user_type_id'];

    if (!isset($_SESSION['id'])) {
        header('Location: /Hospital_FrontEnd/HTML/login.html');
        exit;
    }
    
    $response = [];

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
        $check_email = $mysqli->prepare('select email from users where email=?');
        $check_email->bind_param('s', $email);
        $check_email->execute();
        $check_email->store_result();
        $email_exists = $check_email->num_rows();

        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        if ($email_exists > 0) {
            $response['status'] = "failed";
        } else {
            $check_user_type = $mysqli->prepare('select id from user_types where id=?');
            $check_user_type->bind_param('i', $user_type_id);
            $check_user_type->execute();
            $check_user_type->store_result();
            $user_type_exists = $check_user_type->num_rows();
            
            if ($user_type_exists > 0) {
                $query = $mysqli->prepare('insert into users(name,email,password,dob,user_type_id) values(?,?,?,?,?)');
                $query->bind_param('ssssi', $name, $email, $hashed_password, $dob, $user_type_id);
                $query->execute();
                $response['status'] = "success";
            } else {
                $response['status'] = "failed";
            }
        }
    }
    echo json_encode($response);

?>