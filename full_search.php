<?php
session_start();
include_once 'website_layout.html';

require('libs/db_methods.php');
//$datum_err = $ime_err  = $prezime_err= '';




// cuvanje prethodno unetih vrednosti cak i kad nisu sve unete

if ($_SERVER["REQUEST_METHOD"] == "POST"){     
    $data_array=array();
    $filter_array = array();
    $_SESSION['full_filter_list_page']=0;
    
    if(!empty($_POST['ime']) && isset($_POST['ime'])){
        //only one row
        $criteria_array = array(
                                "fType" => 'text', 
                                "fName" => 'ime', 
                                "fValue" => $_POST['ime']
                                );
       $_SESSION['data_array']['ime'] = $_POST['ime'];
    }
    else{
        $criteria_array = array(
                                "fType" => 'none'
                                );
        $_SESSION['data_array']['ime'] = '';
    }
    $filter_array[] = $criteria_array;
    
    if(!empty($_POST['prezime']) && isset($_POST['prezime'])){
        $criteria_array = array(
                                "fType" => 'text', 
                                "fName" => 'prezime', 
                                "fValue" => $_POST['prezime']
                                );
        $_SESSION['data_array']['prezime'] = $_POST['prezime'];
    }
    else{
        $criteria_array = array(
                                "fType" => 'none'
                                );
        $_SESSION['data_array']['prezime'] = "";
    }
    $filter_array[] = $criteria_array;
<<<<<<< HEAD
    
=======
>>>>>>> efac4fa29280c526a8bad079754a2fd90b7495b6
    if(!empty($_POST['srednje_ime']) && isset($_POST['srednje_ime'])){
           $criteria_array = array(
                                   "fType" => 'text', 
                                   "fName" => 'srednje_ime', 
                                   "fValue" => $_POST['srednje_ime']
                                   );
<<<<<<< HEAD
           $_SESSION['data_array']['srednje_ime'] = $_POST['srednje_ime'];
=======
           $data_array['srednje_ime'] = $_POST['srednje_ime'];
>>>>>>> efac4fa29280c526a8bad079754a2fd90b7495b6
       }
       else{
           $criteria_array = array(
                                   "fType" => 'none'
                                   );
<<<<<<< HEAD
           $_SESSION['data_array']['srednje_ime'] = "";
       }
       $filter_array[] = $criteria_array;  
       
       if(!empty($_POST['jmbg']) && isset($_POST['jmbg'])){
           $criteria_array = array(
                                   "fType" => 'text', 
                                   "fName" => 'jmbg', 
                                   "fValue" => $_POST['srednje_ime']
                                   );
           $_SESSION['data_array']['jmbg'] = $_POST['jmbg'];
       }
       else{
           $criteria_array = array(
                                   "fType" => 'none'
                                   );
           $_SESSION['data_array']['jmbg'] = "";
       }
       $filter_array[] = $criteria_array;  
=======
           $data_array['srednje_ime'] = "";
       }
       $filter_array[] = $criteria_array;   
>>>>>>> efac4fa29280c526a8bad079754a2fd90b7495b6

    
    if(!empty($_POST['bDateFrom']) && isset($_POST['bDateFrom'])){
        $criteria_array = array(
                                "fType" => 'date', 
                                "fName" => 'datum_rodjenja', 
                                "fValue" => $_POST['bDateFrom'] . ' 00:00:00',
                                "fSign" => '>='
                                );
        $_SESSION['data_array']['datum_rodjenja_od'] = $_POST['bDateFrom'];
    }
    else{
        $criteria_array = array(
                                "fType" => 'none'
                                );
        $_SESSION['data_array']['datum_rodjenja_od'] = "";
    }
    $filter_array[] = $criteria_array;
    
    if(!empty($_POST['bDateTo']) && isset($_POST['bDateTo'])){
        $criteria_array = array(
                                "fType" => 'date', 
                                "fName" => 'datum_rodjenja', 
                                "fValue" => $_POST['bDateTo'] . ' 23:59:59',
                                "fSign" => '<='
                                );
        $_SESSION['data_array']['datum_rodjenja_do']=$_POST['bDateTo'];
    }
    else{
        $criteria_array = array(
                                "fType" => 'none'
                                );
        $_SESSION['data_array']['datum_rodjenja_do'] = "";
    }
    $filter_array[] = $criteria_array;
    if(!empty($_POST['pol']) && isset($_POST['pol'])){
        $criteria_array = array(
                                "fType" => 'enum_text', 
                                "fName" => 'pol', 
                                "fValue" => $_POST['pol'],
                           
                                );
        $_SESSION['data_array']['pol'] = $_POST['pol'];
    }
    else{
        $criteria_array = array(
                                "fType" => 'none'
                                );
        $_SESSION['data_array']['pol'] = "";
    }
    $filter_array[] = $criteria_array;
    $_SESSION['filter_data_array']=$filter_array;
    
<<<<<<< HEAD
    $_SESSION['filter_data_array']=$filter_array;
    
    
=======
    $_SESSION['data_array'] = $data_array;
>>>>>>> efac4fa29280c526a8bad079754a2fd90b7495b6
    
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
<<<<<<< HEAD
//                             
                            
    $variable=new data_management();
    $employees_list =$variable->get_employees_list_filter_full('zaposleni',$filter_array,$_SESSION['full_filter_list_page'],$_SESSION['limit']);
=======
                             var_dump($_SESSION['filter_data_array']);
                            var_dump(array_key_exists('fType',$_SESSION['filter_data_array'][0]));
                            
    $variable=new data_management();
    $employees_list =$variable->get_employees_list_filter_full('zaposleni',$_SESSION['filter_data_array'],$_SESSION['full_filter_list_page'],10);
>>>>>>> efac4fa29280c526a8bad079754a2fd90b7495b6
 
}
// load page on the beginning
else{
<<<<<<< HEAD

 

//    $filter_array =array();
                        
     
         
=======
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
    
>>>>>>> efac4fa29280c526a8bad079754a2fd90b7495b6
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
<<<<<<< HEAD
                                                     
    $variable=new data_management();
    $employees_list =$variable->get_employees_list_filter_full('zaposleni',$_SESSION['filter_data_array'],$_SESSION['full_filter_list_page'],$_SESSION['limit']);
=======
                                
    $variable=new data_management();
    $employees_list =$variable->get_employees_list_filter_full('zaposleni',$_SESSION['filter_data_array'],$_SESSION['full_filter_list_page'],10);
>>>>>>> efac4fa29280c526a8bad079754a2fd90b7495b6
}


include_once 'full_search.html';

//include_once 'small_search.html';


echo "</div>";

include_once 'right_side.html';