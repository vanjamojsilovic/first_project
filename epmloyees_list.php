<?php

$employees = [];

if (isset($_GET['pageSize']) && isset($_GET['pageNum'])){
    require 'dbFunctions.php';
    require 'utilFunctions.php';
    
    $pageNum = sanatize_input($_GET['pageNum']);
    $pageSize = sanatize_input($_GET['pageSize']);
    
    if ($pageNum >= 0 AND $pageSize >=0){
        $db_data = new dbFunctions();

        $employees = $db_data->employees($pageNum, $pageSize);

        if (Count($employees) > 0) {
            for ($i=0; $i<Count($employees); $i++){
                $employees[$i]['address'] = $db_data->employee_address($employees[$i]['id']);
                $employees[$i]['education'] = $db_data->employee_education($employees[$i]['id']);
                $employees[$i]['phone'] = $db_data->employee_phone($employees[$i]['id']);
            }
        }
    }
}

$response = json_encode($employees);

echo $response;