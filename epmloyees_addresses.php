<?php

$addresses = [];

if (isset($_GET['pageSize']) && isset($_GET['pageNum'])){
    require 'dbFunctions.php';
    require 'utilFunctions.php';
    
    $pageNum = sanatize_input($_GET['pageNum']);
    $pageSize = sanatize_input($_GET['pageSize']);
    
    if ($pageNum >= 0 AND $pageSize >=0){
        $db_data = new dbFunctions();

        $addresses = $db_data->addresses($pageNum, $pageSize);
    }
}

$response = json_encode($addresses);

echo $response;