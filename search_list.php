<?php

session_start();


include_once 'website_layout.html';

require('libs/db_methods.php');
// search
if(isset($_POST['ime']) || isset($_POST['prezime'])|| isset($_POST['srednje_ime'])){
    $data_array=array();
    if(!empty($_POST['ime']) && isset($_POST['ime'])){
        $data_array['ime']=$_POST['ime'];
    }
    
    if(!empty($_POST['prezime']) && isset($_POST['prezime'])){
        $data_array['prezime']=$_POST['prezime'];
    }
    
    if(!empty($_POST['srednje_ime']) && isset($_POST['srednje_ime'])){
        $data_array['srednje_ime']=$_POST['srednje_ime'];
    }
    
    $_SESSION['data_array']=$data_array;
    
    $employees_data = new data_management();
    $employees_list = $employees_data->search_data('zaposleni',$_SESSION['data_array'],$_SESSION['employees_filter_list_page'],$_SESSION['limit']);
    
    
}
else{
    if (isset($_GET['delete'])){         
        $employees_data = new data_management();
        $employees_list = $employees_data->Delete_row_method($_GET['delete']);
    }
    
    //show hide form
    if (isset($_GET['display'])){
        $_SESSION['div_display']=$_GET['display'];       
    }
    
    // ako kliknemo na next ili na previous
    if (isset($_GET['size']) || isset($_GET['page'])){
        $_SESSION['limit']=$_GET['size'];    
    
        if($_GET['page']==1){
            if($_SESSION['employees_filter_list_page']>=0){
                $_SESSION['employees_filter_list_page'] = $_SESSION['employees_filter_list_page'] + $_GET['page'];
            }
        }
        elseif($_GET['page']==-1){
            if($_SESSION['employees_filter_list_page']>0){
                $_SESSION['employees_filter_list_page'] = $_SESSION['employees_filter_list_page'] + $_GET['page'];
            }
        }
        
    }
    $employees_data = new data_management();
    $employees_list = $employees_data->search_data('zaposleni',$_SESSION['data_array'],$_SESSION['employees_filter_list_page'], $_SESSION['limit']);    
}
include_once 'search_list.html';

include_once 'right_side.html';

