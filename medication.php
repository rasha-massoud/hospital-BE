<?php
    include("connection.php"); 
    session_start();
    // $_SESSION['id'] = $id;

    $medications = [];
    $query = $mysqli->prepare("SELECT * FROM medications");
    $query->execute();
    $query->bind_result($id, $name, $cost);

    while ($query->fetch()) {
        $medication = [
            "id" => $id,
            "name" => $name,
            "cost" => $cost,
        ];
        $medications[] = $medication;
    }

    echo json_encode($medications);
?>