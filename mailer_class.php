<?php

//require 'PHPMailer.php';
//        require 'utilFunctions.php';

class mailer_class{
    
    function __construct(){
    }
    
    function send_email($email_to,$subject,$email_body,$attachment_file){
        include 'config.php';
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
        $mail->SetFrom($email_from, $Name);
        $mail->Subject = $subject;
        
        
        $mail->AddAttachment($attachment_file);
        $mail->AddAddress($email_to, 'Vanja Mojsilovic');
        
        $mail->MsgHTML($email_body);
        $result = $mail->Send();
        
        return $result;
    }
}

