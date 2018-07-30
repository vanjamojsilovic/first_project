<?php

$educations = [];

if (isset($_GET['pageSize']) && isset($_GET['pageNum'])){
    require 'dbFunctions.php';
    require 'utilFunctions.php';
    
    $pageNum = sanatize_input($_GET['pageNum']);
    $pageSize = sanatize_input($_GET['pageSize']);
    
    if ($pageNum >= 0 AND $pageSize >=0){
        $db_data = new dbFunctions();

        $educations = $db_data->educations($pageNum, $pageSize);
    }
}

$response = json_encode($educations);

echo $response;
