<?php
session_start();
include_once 'website_layout.html';

require('libs/db_methods.php');
//$datum_err = $ime_err  = $prezime_err= '';




// cuvanje prethodno unetih vrednosti cak i kad nisu sve unete

if ($_SERVER["REQUEST_METHOD"] == "POST"){     
    $data_array=array();
    $filter_array = array();
    if(!empty($_POST['ime']) && isset($_POST['ime'])){
        //only one row
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
    if(!empty($_POST['srednje_ime']) && isset($_POST['srednje_ime'])){
           $criteria_array = array(
                                   "fType" => 'text', 
                                   "fName" => 'srednje_ime', 
                                   "fValue" => $_POST['srednje_ime']
                                   );
           $data_array['srednje_ime'] = $_POST['srednje_ime'];
       }
       else{
           $criteria_array = array(
                                   "fType" => 'none'
                                   );
           $data_array['srednje_ime'] = "";
       }
       $filter_array[] = $criteria_array;   

    
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
    $_SESSION['filter_data_array']=$filter_array;
    
    $_SESSION['data_array'] = $data_array;
    
     // ako kliknemo na next ili na previous
    if (isset($_GET['page'])){
        if($_GET['page']==1){
            if($_SESSION['full_filter_list_page']>=0){
                $_SESSION['full_filter_list_page'] = $_SESSION['full_filter_list_page'] + $_GET['page'];
                                                    }
                            }
        elseif($_GET['page']==-1){
            if($_SESSION['full_filter_list_page']>0){
                $_SESSION['full_filter_list_page'] = $_SESSION['full_filter_list_page'] + $_GET['page'];
                                                  }
                                }
                            }
                             var_dump($_SESSION['filter_data_array']);
                            var_dump(array_key_exists('fType',$_SESSION['filter_data_array'][0]));
                            
    $variable=new data_management();
    $employees_list =$variable->get_employees_list_filter_full('zaposleni',$_SESSION['filter_data_array'],$_SESSION['full_filter_list_page'],10);
 
}
// load page on the beginning
else{
    $ime_zaposleni ="";
    $prezime_zaposleni="";
    $srednje_ime_zaposleni="";
    $jmbg_zaposleni="";
    $godina_rodjenja="";
    $mesec_rodjenja="";
    $dan_rodjenja="";
   
    $datum_rodjenja_zaposleni="";
    $pol="";

    $filter_array =array(
                        'ime'=>$ime_zaposleni, 
                        'prezime'=>$prezime_zaposleni,
                        'srednje_ime'=>$srednje_ime_zaposleni,
                        'jmbg'=>$jmbg_zaposleni,
                        'datum_rodjenja'=>$datum_rodjenja_zaposleni,
                        'pol'=>$pol);
     $_SESSION['data_array']=$filter_array;
     $_SESSION['filter_data_array']=$filter_array;
    
    // ako kliknemo na next ili na previous
    if (isset($_GET['page'])){
        if($_GET['page']==1){
            if($_SESSION['full_filter_list_page']>=0){
                $_SESSION['full_filter_list_page'] = $_SESSION['full_filter_list_page'] + $_GET['page'];
                                                    }
                            }
        elseif($_GET['page']==-1){
            if($_SESSION['full_filter_list_page']>0){
                $_SESSION['full_filter_list_page'] = $_SESSION['full_filter_list_page'] + $_GET['page'];
                                                  }
                                }
                            }
                                
    $variable=new data_management();
    $employees_list =$variable->get_employees_list_filter_full('zaposleni',$_SESSION['filter_data_array'],$_SESSION['full_filter_list_page'],10);
}


include_once 'full_search.html';

//include_once 'small_search.html';


echo "</div>";

include_once 'right_side.html';