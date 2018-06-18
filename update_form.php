<?php

session_start();

include_once 'website_layout.html';
 
require('libs/db_methods.php');
$datum_err = $ime_err  = $prezime_err= '';

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    // check whether it's empty
    $dan= (!empty($_POST['bday'])? '' :0);
    $mesec= (!empty($_POST['bday'])?'':0);
    $godina= (!empty($_POST['bday'])?'':0);    
   
    if (empty($_POST['ime']) || empty($_POST['prezime'])){
        $ime_err = (empty($_POST['ime']) ? 'Required!' : '');
        $prezime_err = (empty($_POST['prezime']) ? 'Required!' : '');
        $datum_err = (empty($_POST['bday'])  ? 'Required!' :  '');        

        // dodeljivanje null vrednosti
        $globalArray = array (
                                'ime' => $_POST['ime'],
                                'prezime' => $_POST['prezime'],                                
                                );
        $GLOBALS['form_values'] = $globalArray;
    }
    // ako je sve uneto kako treba
    else{
        $ime_zaposleni ="";
        $prezime_zaposleni="";
        $srednje_ime_zaposleni="";
        $jmbg_zaposleni="";       
        $datum_rodjenja_zaposleni="";
        $pol="";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $ime_zaposleni =test_input($_POST["ime"]);
            $prezime_zaposleni= test_input($_POST["prezime"]);
            $srednje_ime_zaposleni= test_input($_POST["srednje_ime"]);
            $jmbg_zaposleni= test_input($_POST["jmbg"]);       
            $datum_rodjenja_zaposleni=$_POST["bday"];
            
            if(isset($_POST["pol"])){
                $pol=$_POST["pol"];                      
            }             
         }
        
        $_SESSION['update_data']=array('ime'=>$ime_zaposleni, 
                           'prezime'=>$prezime_zaposleni,
                           'srednje_ime'=>$srednje_ime_zaposleni,
                           'jmbg'=>$jmbg_zaposleni,
                           'datum_rodjenja'=>$datum_rodjenja_zaposleni,
                           'pol'=>$pol);
        
        $variable=new data_management();
        $update_result=$variable->Update_post('zaposleni',$_SESSION['update_data'],$_SESSION['update_selected_id']);       
        var_dump($update_result);
        if ($update_result === TRUE) {//ovde je problem, zasto je null?
            header('Location: ponovo.php');
            echo "Successfully!<br>" ;
        } 
        else {
            echo "ERROR!<br>" ;
        }     
        // posle unosenja vrednosti u bazu, dodeljujemo prazne stringove
        // da bi smo imali novi unos - reset    
    }
}
// cuvanje prethodno unetih vrednosti cak i kad nisu sve unete
if (isset($GLOBALS['form_values']) && !empty($GLOBALS['form_values'])){
    extract($GLOBALS['form_values']);
    
}
else{
    // kada se prvi put otvara strana
    
    $dan_rodjenja = '';
    $mesec_rodjenja = '';
    $godina_rodjenja = '';
    
    $ime = '';
    $prezime = '';    
    $srednje_ime='';
    $jmbg='';
    $datum_rodjenja='';
    
    
    
    $employee_row=array();
    if (isset($_GET['update'])){         
        $employees_data = new data_management();        
        $employee_row = $employees_data->Update_select($_GET['update']);
        $_SESSION['update_data']= $employees_data->Update_select($_GET['update']);
        
        $ime = $employee_row['ime'];
        $prezime = $employee_row['prezime'];
        $srednje_ime=$employee_row['srednje_ime'];
        $jmbg=$employee_row['jmbg'];
        $datum_rodjenja=$employee_row['datum_rodjenja'];
        $_SESSION['pol']=$employee_row['pol'];
        
        $_SESSION['update_selected_id']=$_GET['update'];              
    }
    
    $_SESSION['gender_male']=Checked_male($_SESSION['update_data']['pol']);
    $_SESSION['gender_female']=Checked_female($_SESSION['update_data']['pol']);  
    
}
echo '<div class="column middle">';
include_once 'update_form.html';

echo '</div>';

include_once 'right_side.html';
