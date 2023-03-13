<?php
    include("connection.php"); 
    session_start();
    // $_SESSION['id'] = $id;

    if (!isset($_SESSION['id'])) {
        header('Location: /Hospital_FrontEnd/HTML/login.html');
        exit;
    }

    $hospitals = [];
    $query = $mysqli->prepare("SELECT * FROM hospitals");
    $query->execute();
    $query->bind_result($id, $name, $address, $phone_number, $email, $facebook_url);

    while ($query->fetch()) {
        $hospital = [
            "id" => $id,
            "name" => $name,
            "address" => $address,
            "phone_number" => $phone_number,
            "email" => $email,
            "facebook_url" => $facebook_url,
        ];
        $hospitals[] = $hospital;
    }

    echo json_encode($hospitals);
?>