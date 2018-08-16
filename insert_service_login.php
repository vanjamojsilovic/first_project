<?php
require 'dbFunctions.php';
require 'utilFunctions.php';
$response="Not a post method!";

if ($_SERVER["REQUEST_METHOD"] == "POST"){     
    $first_name = sanatize_input($_POST['first_name']);
    $last_name = sanatize_input($_POST['last_name']);
    $email = sanatize_input($_POST['email']);
    $password = sanatize_input($_POST['password']);
    $confirm = sanatize_input($_POST['confirm']);
        
    $db_data = new dbFunctions();

    $sql_response = $db_data->insert_employee_login($first_name, $last_name, $email, $password, $confirm);  
    
    if ($sql_response === TRUE){
                header("HTTP/1.1 200 OK");
                $response="Succesfully!";
    } 
    else {
        $response="Error!";
    }   
}

echo $response;