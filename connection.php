<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization");
    
    $host= "localhost";
    $db_user="root";
    $db_pass=null;
    $db_name="hospital_db";
    $mysqli=new mysqli($host,$db_user,$db_pass,$db_name);
?>