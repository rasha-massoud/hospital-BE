<?php
    include("connection.php"); 
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

    if ($num_rows == 0) {
        $response['response'] = "user not found";
    } else {
        if (password_verify($password, $hashed_password)) {
            $_SESSION['loggedIn'] = true;
            $_SESSION['name'] = $name;
            $_SESSION['email'] = $email;
            $_SESSION['user_id'] = $id;
            $response['status']='user logged in';
            $response['name']='name';
        } else {
            $response["status"] = 'Incorrect password';
        }
    }
    
    echo json_encode($response);
?>
