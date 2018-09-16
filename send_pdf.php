<?php

require 'dbFunctions.php';
require 'utilFunctions.php';
require 'config.php';
require "PHPMailer.php";
require 'mailer_class.php';
//require 'fpdf.php';
require 'pdf_class.php';

$employees = [];

if (isset($_GET['pageSize']) && isset($_GET['pageNum'])){
    
    
    $pageNum = sanatize_input($_GET['pageNum']);
    $pageSize = sanatize_input($_GET['pageSize']);
    
    if ($pageNum >= 0 AND $pageSize >=0){
        $db_data = new dbFunctions();

        $employees = $db_data->send_pdf($pageNum, $pageSize);        
    }
}

$file_path="tmp/employees.pdf";

$pdf = new PDF("L", "mm","A5");

$header = array('ID', 'Name', 'Vocation', 'Address','Phone');
$pdf->SetFont('Arial','',9);
$pdf->AddPage();
$pdf->SetFillColor(255,0,0);
$pdf->SetTextColor(255);
$pdf->SetDrawColor(128,0,0);
$pdf->SetLineWidth(.3);
$pdf->SetFont('','B','9');
// Header
$w_id=15;
$w_name=40;
$w_voc=40;
$w_add=30;
$w_ph=30;

$w = array($w_id, $w_name, $w_voc, $w_add, $w_ph);
for($i=0;$i<count($header);$i++){
    $pdf->Cell($w[$i],7,$header[$i],1,0,'C',true);
}
$pdf->Ln();

$data = $employees;
$pdf->SetFillColor(224,235,255);
$pdf->SetTextColor(0);
$pdf->SetFont('Arial','','11');
// Data
$fill = false;
for($i=0;$i<count($data);$i++){
    $max_height=6;
    $h_array=array(count($data[$i]['vocation']),count($data[$i]['address']),count($data[$i]['phone']));
    if(max($h_array)>1){
        $max_height=$max_height*6;
    }
  
  
    $pdf->Cell($w[0],$max_height,$data[$i]['id_zaposleni'],'LR',0,'L',$fill);
    $full_name=$data[$i]['name'].' '.$data[$i]['lastname'];
    $pdf->Cell($w[1],$max_height,$full_name,'LR',0,'L',$fill);
    $vocations='';
    if(count($data[$i]['vocation']>0)){
        for($j=0;$j<count($data[$i]['vocation']);$j++){
            $vocations=$vocations.$data[$i]['vocation'][$j]." \n ";
        }
    }
    $x = $pdf->GetX();
    $y = $pdf->GetY();
    $pdf->MultiCell($w[2],6,$vocations,'LR','L',$fill);
    $pdf->SetXY($x+$w[2], $y);
    $pdf->Cell($w[3],$max_height,'','LR',0,'L',$fill);
    $pdf->Cell($w[4],$max_height,'','LR',0,'L',$fill);
    $pdf->SetFillColor(224,235,255);
    $pdf->SetTextColor(0);
    $pdf->SetFont('');
        //            $this->Cell($w[2],6,number_format($row[2]),'LR',0,'R',$fill);
        //            $this->Cell($w[3],6,number_format($row[3]),'LR',0,'R',$fill);
    $pdf->Ln();
    $fill = !$fill;
    }
$pdf->Cell(array_sum($w),0,'','T');
     
       
        

$pdf->Output("F",$file_path);

//$file = fopen($file_path,"w");

$mailer_class= new mailer_class();
$email_to='vanja.mojsilovic@gmail.com';
$subject = "PDF file";
$email_body = "Hello!<br> Your PDF file is sent!";
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

//$header = array
//(
//"Name",
//"Vocation",
//"Address",
//"Phone"
//);
$response = json_encode($employees);

echo $response;