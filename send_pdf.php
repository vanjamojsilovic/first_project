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

$pdf->AddPage('L');

$pdf->SetFillColor(255,0,0);
$pdf->SetTextColor(255);
$pdf->SetDrawColor(128,0,0);
$pdf->SetLineWidth(.3);
$pdf->SetFont('Arial','','9');
$w = array(15, 40, 40, 65, 25);
$table_height=0;
$header_height=7;
for($i=0;$i<count($header);$i++){
    $pdf->Cell($w[$i],$header_height,$header[$i],1,0,'C',true);
}
$table_height=$table_height+$header_height;
$pdf->Ln();

$data = $employees;
$pdf->SetFillColor(224,235,255);
$pdf->SetTextColor(0);
$pdf->SetFont('Arial','','9');
// Data
$fill = false;

for($i=0;$i<count($data);$i++){
    $max_height=5;
    
    $h_array=array(count($data[$i]['vocation']),count($data[$i]['address']),count($data[$i]['phone']));
    if(max($h_array)>1){
        $max_height=(max($h_array))*5;
    }
    $table_height=$table_height+$max_height;
    
    $x = $pdf->GetX();
    $y = $pdf->GetY();
    $id=$data[$i]['id_zaposleni']." \n ";
    for($j=1;$j<max($h_array);$j++){
        $id=$id."  \n ";
    }
    $id=substr($id, 0, -3);
    $pdf->MultiCell($w[0],5,$id,1,'L',$fill);
    $pdf->SetAutoPageBreak(FALSE);
    $pdf->SetXY($x+$w[0], $y);
    
    $full_name=$data[$i]['name'].' '.$data[$i]['lastname']." \n ";
    for($j=1;$j<max($h_array);$j++){
        $full_name=$full_name."  \n ";
    }
    $full_name=substr($full_name, 0, -3);
    $x = $pdf->GetX();
    $y = $pdf->GetY();
    $pdf->MultiCell($w[1],5,$full_name,1,'L',$fill);
    
    $pdf->SetXY($x+$w[1], $y);
    $vocations=' ';
    if(count($data[$i]['vocation']>0)){
        for($j=0;$j<max($h_array);$j++){
            if(!empty($data[$i]['vocation'][$j])){
                $vocations=$vocations.$data[$i]['vocation'][$j]." \n ";
            }
            else{
                $vocations=$vocations."  \n ";
            }
        }
        $vocations=substr($vocations, 0, -3);
    }
    $x = $pdf->GetX();
    $y = $pdf->GetY();
    $pdf->MultiCell($w[2],5,$vocations,1,'L',$fill);
    
    $pdf->SetXY($x+$w[2], $y);
    
    $addresses=' ';
    if(count($data[$i]['address']>0)){
        for($j=0;$j<max($h_array);$j++){
            if(!empty($data[$i]['address'][$j])){
                $addresses=$addresses.$data[$i]['address'][$j]." \n ";
            }
            else{
                $addresses=$addresses."  \n ";
            }
        }
        $addresses=substr($addresses, 0, -3);
    }
    $x = $pdf->GetX();
    $y = $pdf->GetY();
    $pdf->MultiCell($w[3],5,$addresses,1,'L',$fill);
    
    $pdf->SetXY($x+$w[3], $y);
    
    $phones=' ';
    if(count($data[$i]['phone']>0)){
        for($j=0;$j<max($h_array);$j++){
            if(!empty($data[$i]['phone'][$j])){
                $phones=$phones.$data[$i]['phone'][$j]." \n ";
            }
            else{
                $phones=$phones."  \n ";
            }
        }
        $phones=substr($phones, 0, -3);
    }
    $x = $pdf->GetX();
    $y = $pdf->GetY();
    $pdf->MultiCell($w[4],5,$phones,1,'L',$fill);
    
    $pdf->SetY($y);
    $pdf->Ln($max_height);
    $fill = !$fill;
    $page_height=$pdf->GetPageHeight();
    if($table_height>($page_height-20)){
        $pdf->AddPage('L');
        $table_height=0;
    }
}
//$pdf->Cell(array_sum($w),0,'','T');
     
       
        

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