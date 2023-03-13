<?php
    include("connection.php"); 
    require_once 'path/to/JWT/library/JWT.php';
    session_start();

    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = $mysqli->prepare('select id, email, password, name, dob, user_type_id from users where email=?');
    $query->bind_param("s", $email);
    $query->execute();

    $query->store_result();
    $num_rows = $query->num_rows();
    $query->bind_result($id, $email, $hashed_password, $name, $dob, $user_type_id);
    $query->fetch();
    $response =[];

    if ($num_rows > 0) {
        if (password_verify($password, $hashed_password)) {
            $jwt_secret = 'I_AM_THE_SECRET_KEY';
            $jwt_payload = array(
                "id" => $id,
                "email" => $email,
                "user_type_id" => $user_type_id
            );
            $jwt_token = JWT::encode($jwt_payload, $jwt_secret);
            $_SESSION['jwt_token'] = $jwt_token;
            $response['status']='user logged in';
            $response['email']=$email;
            $response['user_type_id']=$user_type_id;
            $response['jwt_token']=$jwt_token;
        } else {
            $response["status"] = 'Incorrect password';
        }
    } else{
        $response['status'] = "user not found";
    }
    
    echo json_encode($response);
?>
