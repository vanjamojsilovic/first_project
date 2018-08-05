<?php
require 'dbFunctions.php';
require 'utilFunctions.php';
$response="No action!";

if ($_SERVER["REQUEST_METHOD"] == "POST"){     
    var_dump($_POST['first_name']);
    $first_name = sanatize_input($_POST['first_name']);
    $last_name = sanatize_input($_POST['last_name']);    
    
    $db_data = new dbFunctions();

    $sql_response = $db_data->insert_employee($first_name, $last_name);  
    
    if ($sql_response === TRUE){
                header("HTTP/1.1 200 OK");
                $response="Succesfully!";
    } 
    else {
        $response="Error!";
    }   
}


echo $response;