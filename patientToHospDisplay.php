<?php
    include("connection.php"); 
    session_start();
    // $_SESSION['id'] = $id;

    if (!isset($_SESSION['id'])) {
        header('Location: /Hospital_FrontEnd/HTML/login.html');
        exit;
    }
    
    $links = [];
    $query = $mysqli->prepare("SELECT * FROM hospital_users");
    $query->execute();
    $query->bind_result($hospital_id, $user_id, $is_active, $date_joined, $date_left);

    while ($query->fetch()) {
        $link = [
            "hospital_id" => $hospital_id,
            "user_id" => $user_id,
            "is_active" => $is_active,
            "date_joined" => $date_joined,
            "posidate_lefttion" => $date_left,
        ];
        $links[] = $link;
    }

    echo json_encode($links);
?>