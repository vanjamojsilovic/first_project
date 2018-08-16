<?php
require 'dbFunctions.php';
require 'utilFunctions.php';
$response="Not a post method!";

if ($_SERVER["REQUEST_METHOD"] == "POST"){     
    
    $email = sanatize_input($_POST['email']);
    $password = sanatize_input($_POST['password']);
        
    $db_data = new dbFunctions();

    $sql_response = $db_data->login($email, $password);  
    
    switch ($sql_response) {
    case 1000:
        header("HTTP/1.1 200 OK");
        $response=array('message'=>'Correct!','successful'=>TRUE,'message_code'=>1000);
        break;
    case 1001:
        header("HTTP/1.1 401");
        $response=array('message'=>'Incorrect password! Try again!','successful'=>FALSE );
        break;
    case 1002:
        header("HTTP/1.1 401");
        $response=array('message'=>'User doesn\'t exsist! Please check the email!','successful'=>FALSE );
        break;
    }
    
    echo json_encode($response);
               
}

