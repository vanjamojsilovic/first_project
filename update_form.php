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
                                'dan_rodjenja' => $dan,
                                'mesec_rodjenja' => $mesec,
                                'godina_rodjenja' => $godina
                                );
        $GLOBALS['form_values'] = $globalArray;
    }
    // ako je sve uneto kako treba
    else{ 
     
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "agencija";

        $ime_zaposleni ="";
        $prezime_zaposleni="";
        $srednje_ime_zaposleni="";
        $jmbg_zaposleni="";
        $godina_rodjenja="";
        $mesec_rodjenja="";
        $dan_rodjenja="";
        $crta="-";
        $datum_rodjenja_zaposleni="";
        $pol="";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
          $ime_zaposleni =test_input($_POST["ime"]);
          $prezime_zaposleni= test_input($_POST["prezime"]);
          $srednje_ime_zaposleni= test_input($_POST["srednje_ime"]);
          $jmbg_zaposleni= test_input($_POST["jmbg"]);
//         
          $datum_rodjenja_zaposleni=$_POST["bday"];
          if($_POST["pol"]=="muski")
              {$pol="m";}
              else
              {$pol="z";};
         }

        $insert_data=array('ime'=>$ime_zaposleni, 
                           'prezime'=>$prezime_zaposleni,
                           'srednje_ime'=>$srednje_ime_zaposleni,
                           'jmbg'=>$jmbg_zaposleni,
                           'datum_rodjenja'=>$datum_rodjenja_zaposleni,
                           'pol'=>$pol);
        
        $variable=new data_management();
        $update_result=$variable->Update_post('zaposleni', $insert_data,$_SESSION['update_selected_id']);       
        var_dump($update_result);
        if ($update_result === TRUE) {
            header('Location: ponovo.php');

        } else {
            echo "ERROR! <br>" ;
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
    $pol='';
    $gender_male='';
    $gender_female='';
    
    
    $employee_row=array();
    if (isset($_GET['update'])){         
        $employees_data = new data_management();        
        $employee_row = $employees_data->Update_select($_GET['update']);
        $ime = $employee_row['ime'];
        $prezime = $employee_row['prezime'];
        $srednje_ime=$employee_row['srednje_ime'];
        $jmbg=$employee_row['jmbg'];
        $datum_rodjenja=$employee_row['datum_rodjenja'];
        $pol=$employee_row['pol'];
        $gender_male=Checked_male($pol);
        $gender_female=Checked_female($pol);
        $_SESSION['update_selected_id']=$_GET['update'];
        
        
    }
    
}
echo '<div class="column middle">';
include_once 'update_form.html';

echo '</div>';

include_once 'right_side.html';
