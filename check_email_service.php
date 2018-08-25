<?php
require "PHPMailer.php";
$GLOBALS['disable_ssl_for_gmail'] = TRUE;
require 'dbFunctions.php';
require 'utilFunctions.php';


$mail = new PHPMailer();

$mail->IsSMTP();
//        $mail->SMTPDebug = 3;
//        $mail->Debugoutput = 'html';
$mail->SMTPAuth   = true;
$mail->SMTPSecure = 'ssl';
$mail->Host       = 'smtp.gmail.com';
$mail->Username   = 'vanjatest38@gmail.com';
$mail->Password   = 'mki876tg';
$mail->Port       = '465';
$mail->SMTPDebug = 0;    

$mail->SetFrom('vanjatest38@gmail.com', 'admin');     

$mail->Subject = 'Your New Password'; 

if ($_SERVER["REQUEST_METHOD"] == "POST"){    
      $found="?";
      $changed='?';
      $sent='?';
      
    $email = sanatize_input($_POST['email']);   
    
    $db_data = new dbFunctions();
    
    $sql_response_check = $db_data->check_email($email);  
    
    if($sql_response_check['found']){
        $found='Username is found!';
        $new_password=$db_data->password_creator(10);
        $sql_response_update=$db_data->update_password($sql_response_check['id'], $new_password);
        if($sql_response_update){
            $changed='Password is changed!';
            $mail->AddAddress($email, 'Vanja Mojsilovic');
            $emailBody = "Hello!"
                   . "Your new password is:"
                    . "<br>"
                   . $new_password
                    . "<br>"
                    . "You can now log-in!";
            $mail->MsgHTML($emailBody);
            $result = $mail->Send();
            if($result){
                $sent='Email is sent!';
                header("HTTP/1.1 200 OK");
                $response=array('found'=>$found,'id'=>$sql_response_check['id'],'changed'=>$changed,'sent'=>$sent);
               
            }
            else{
                header("HTTP/1.1 401");
                $sent='Email is not sent!';
                $response=array('found'=>$found,'id'=>$sql_response_check['id'],'changed'=>$changed,'sent'=>$sent);
            }
        }
        else{
           header("HTTP/1.1 401");
           $changed='Password is not changed!';
           $response=array('found'=>$found,'id'=>$sql_response_check['id'],'changed'=>$changed,'sent'=>$sent);
        }
    }
    else{
        header("HTTP/1.1 401");
        $found='Username is not found!';
        $response=array('found'=>$found,'id'=>$sql_response_check['id'],'changed'=>$changed,'sent'=>$sent);
    }
    echo json_encode($response);
}

   
               

