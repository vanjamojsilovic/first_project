<?php
session_start();
include_once 'website_layout.html';

require('libs/db_methods.php');
$datum_err = $ime_err  = $prezime_err= '';




// cuvanje prethodno unetih vrednosti cak i kad nisu sve unete

if ($_SERVER["REQUEST_METHOD"] == "POST"){
//    $dan= (!empty($_POST['bday'])? '' :0);
//    $mesec= (!empty($_POST['bday'])?'':0);
//    $godina= (!empty($_POST['bday'])?'':0);
    
    $data_array=array();
    $filter_array = array();
    if(!empty($_POST['ime']) && isset($_POST['ime'])){
        $criteria_array = array(
                                "fType" => 'text', 
                                "fName" => 'ime', 
                                "fValue" => $_POST['ime']
                                );
        $data_array['ime'] = $_POST['ime'];
    }
    else{
        $criteria_array = array(
                                "fType" => 'none'
                                );
        $data_array['ime'] = '';
    }
    $filter_array[] = $criteria_array;
    
    if(!empty($_POST['prezime']) && isset($_POST['prezime'])){
        $criteria_array = array(
                                "fType" => 'text', 
                                "fName" => 'prezime', 
                                "fValue" => $_POST['prezime']
                                );
        $data_array['prezime'] = $_POST['prezime'];
    }
    else{
        $criteria_array = array(
                                "fType" => 'none'
                                );
        $data_array['prezime'] = "";
    }
    $filter_array[] = $criteria_array;
    
//    if(!empty($_POST['srednje_ime']) && isset($_POST['srednje_ime'])){
//        $data_array['srednje_ime']=$_POST['srednje_ime'];
//    }
//    else{
//        $data_array['srednje_ime'] = "";
//    }
    
    if(!empty($_POST['bDateFrom']) && isset($_POST['bDateFrom'])){
        $criteria_array = array(
                                "fType" => 'date', 
                                "fName" => 'datum_rodjenja', 
                                "fValue" => $_POST['bDateFrom'] . ' 00:00:00',
                                "fSign" => '>='
                                );
        $data_array['datum_rodjenja_od'] = $_POST['bDateFrom'];
    }
    else{
        $criteria_array = array(
                                "fType" => 'none'
                                );
        $data_array['datum_rodjenja_od'] = "";
    }
    $filter_array[] = $criteria_array;
    
    if(!empty($_POST['bDateTo']) && isset($_POST['bDateTo'])){
        $criteria_array = array(
                                "fType" => 'date', 
                                "fName" => 'datum_rodjenja', 
                                "fValue" => $_POST['bDateTo'] . ' 23:59:59',
                                "fSign" => '<='
                                );
        $data_array['datum_rodjenja_do']=$_POST['bDateTo'];
    }
    else{
        $criteria_array = array(
                                "fType" => 'none'
                                );
        $data_array['datum_rodjenja_do'] = "";
    }
    $filter_array[] = $criteria_array;
    
   
//     if (empty($_POST['ime']) || empty($_POST['prezime'])){
//        $ime_err = (empty($_POST['ime']) ? 'Required!' : '');
//        $prezime_err = (empty($_POST['prezime']) ? 'Required!' : '');
//        $datum_err = (empty($_POST['bday'])  ? 'Required!' :  '');
        

// dodeljivanje null vrednosti
//    $globalArray = array (
//                            'ime' => $_POST['ime'],
//                            'prezime' => $_POST['prezime'],
//                            'dan_rodjenja' => $dan,
//                            'mesec_rodjenja' => $mesec,
//                            'godina_rodjenja' => $godina
//                            );
    $_SESSION['data_array'] = $data_array;
                                
    $variable=new data_management();
    $employees_list =$variable->get_employees_list_filter_full($filter_array);
}
// ako je sve uneto kako treba
else{
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

    $_SESSION['data_array'] =array('ime'=>$ime_zaposleni, 
                               'prezime'=>$prezime_zaposleni,
                               'srednje_ime'=>$srednje_ime_zaposleni,
                               'jmbg'=>$jmbg_zaposleni,
                               'datum_rodjenja'=>$datum_rodjenja_zaposleni,
                               'pol'=>$pol);

    $variable=new data_management();
    $employees_list =$variable->get_employees_list($_SESSION['employees_list_page'], 10);
}

if (isset($_SESSION['data_array']) && !empty($_SESSION['data_array'])){
    extract($_SESSION['data_array']);
}
else{
    // kada se prvi put otvara strana
    $ime = '';
    $prezime = '';
    $dan_rodjenja = '';
    $mesec_rodjenja = '';
    $godina_rodjenja = '';
}

include_once 'full_search.html';

include_once 'small_search.html';

echo "</div>";

include_once 'right_side.html';