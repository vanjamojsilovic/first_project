<?php

$employees = [];

if (isset($_GET['pageSize']) && isset($_GET['pageNum'])){
    require 'dbFunctions.php';
    require 'utilFunctions.php';
    
    $pageNum = sanatize_input($_GET['pageNum']);
    $pageSize = sanatize_input($_GET['pageSize']);
    
    if ($pageNum >= 0 AND $pageSize >=0){
        $db_data = new dbFunctions();

        $employees = $db_data->send_csv($pageNum, $pageSize);        
    }
}

$response = json_encode($employees);

$header = array
(
"Name",
"Vocation",
"Address",
"Phone"
);

$file = fopen("tmp/employees.csv","w");

fputcsv($file,$header);

foreach ($employees as $line)
  {
  fputcsv($file,array($line['name']." ".$line['lastname'],$line['vocation'],$line['address'],$line['phone']));
  }

fclose($file);

echo $response;

