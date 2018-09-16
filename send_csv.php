<?php

require 'dbFunctions.php';
require 'utilFunctions.php';
require 'config.php';
require "PHPMailer.php";
require 'mailer_class.php';

$employees = [];

if (isset($_GET['pageSize']) && isset($_GET['pageNum'])){
    $pageNum = sanatize_input($_GET['pageNum']);
    $pageSize = sanatize_input($_GET['pageSize']);
    
    if ($pageNum >= 0 AND $pageSize >=0){
        $db_data = new dbFunctions();

        $employees = $db_data->send_csv($pageNum, $pageSize);        
    }
}



$header = array
(
"Name",
"Vocation",
"Address",
"Phone"
);
$file_path="tmp/employees.csv";
$file = fopen($file_path,"w");
fputcsv($file,$header);
foreach ($employees as $line){
    fputcsv($file,array($line['name']." ".$line['lastname'],$line['vocation'],$line['address'],$line['phone']));
}
fclose($file);

$mailer_class= new mailer_class();
$email_to='vanja.mojsilovic@gmail.com';
$subject = "CSV file";
$email_body = "Hello!<br> Your CSV file is sent!";
$attachment_file=$file_path;
$result_sent=$mailer_class->send_email($email_to,$subject,$email_body,$attachment_file);

$db_data = new dbFunctions();
$sql_response_check = $db_data->check_email($email_to);  
$found="?";
$sent='?';
if($sql_response_check['found']){
    $found='Username is found!';
    if($result_sent){
        $sent='Email is sent!';
        header("HTTP/1.1 200 OK");
//            $response=array('found'=>$found,'id'=>$sql_response_check['id'],'sent'=>$sent);

    }
    else{
        header("HTTP/1.1 401");
        $sent='Email is not sent!';
        $code=1003;
        $response=array('code'=>$code, 'found'=>$found,'id'=>$sql_response_check['id'],'sent'=>$sent);
    }
}
else{
    header("HTTP/1.1 401");
    $found='Username is not found!';
    $code=1001;
    $response=array('code'=>$code, 'found'=>$found,'id'=>$sql_response_check['id'],'sent'=>$sent);
    }
unlink($file_path);   
$response = json_encode($employees);
echo $response;


