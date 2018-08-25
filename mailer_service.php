<?php

require "PHPMailer.php";
require 'dbFunctions.php';
require 'utilFunctions.php';

$GLOBALS['disable_ssl_for_gmail'] = TRUE;

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

    $mail->Subject = 'Your New Password'; //subject
//    $emailAttachmentPath = 'upload/PythagorasB2+.pdf';
    $mail->AddAttachment($emailAttachmentPath);
    
    if ($_SERVER["REQUEST_METHOD"] == "POST"){ 
        
        $users_email = sanatize_input($_POST['email']);
        $mail->AddAddress($users_email, 'Vanja Mojsilovic');
//    $mail->addCC('profesor.vanja.mojsilovic@gmail.com', 'Profesor Vanja Mojsilovic');
        
        $db_data = new dbFunctions();        
              
       
        $response="";
       
                $emailBody = "Hello!"
                    . "<br>"             
                    . "Your new password is:"
                    . "<br>"
                    . $new_password
                    . "<br>"
                    . "You can now log-in!";
                $mail->MsgHTML($emailBody);

                $result = $mail->Send();
                if($result){
                    header("HTTP/1.1 200 OK");
                    $response=array('successful'=>TRUE,'message_code'=>1000, 'message'=>'Email sent!');
                }
                
               
            }
        echo $response;
    