<?php
require 'dbFunctions.php';
require 'utilFunctions.php';
$response="Not a post method!";

if ($_SERVER["REQUEST_METHOD"] == "POST"){     
    
    $email = sanatize_input($_POST['email']);
    $password = sanatize_input($_POST['password']);
        
    $db_data = new dbFunctions();

    $sql_response = $db_data->login($email, $password);  
    
    if ($sql_response === TRUE){
                header("HTTP/1.1 200 OK");
                $response="Succesfully!";
    } 
    else {
        $response="Error!";
    }   
}

echo $response;