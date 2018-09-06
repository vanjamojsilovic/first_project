<?php

$employees = [];

if (isset($_GET['pageSize']) && isset($_GET['pageNum'])){
    require 'dbFunctions.php';
    require 'utilFunctions.php';
    require 'config.php';
    require "PHPMailer.php";
    
    
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

$file = fopen("tmp/employees.csv","w");
fputcsv($file,$header);
foreach ($employees as $line){
    fputcsv($file,array($line['name']." ".$line['lastname'],$line['vocation'],$line['address'],$line['phone']));
}
fclose($file);

$mail = new PHPMailer();
$mail->IsSMTP();
//        $mail->SMTPDebug = 3;
//        $mail->Debugoutput = 'html';
$mail->SMTPAuth   = $SMTPAuth;
$mail->SMTPSecure = $SMTPSecure;
$mail->Host       = $Host;
$mail->Username   = $Username;
$mail->Password   = $Password;
$mail->Port       = $Port;
$mail->SMTPDebug = $SMTPDebug;
$mail->SetFrom($Email, $Name);
$mail->Subject = "CSV file";
$email = $my_email;
$emailAttachmentPath = $attachment_file;
$mail->AddAttachment($emailAttachmentPath);
$db_data = new dbFunctions();


$sql_response_check = $db_data->check_email($email);  
$found="?";
$sent='?';
if($sql_response_check['found']){
    $found='Username is found!';
        $mail->AddAddress($email, 'Vanja Mojsilovic');
        $emailBody = "Hello!"
                ."<br>"
               . "Your Report has been sent!";
        $mail->MsgHTML($emailBody);
        $result = $mail->Send();
        if($result){
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
delete($file);   
$response = json_encode($employees);
echo $response;


