<?php
session_start();
include_once 'website_layout.html';

require('libs/db_methods.php');



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
           $_SESSION['full_data_array']['ime'] = $_POST['ime'];
        }
        else{
            $criteria_array = array(
                                    "fType" => 'none'
                                    );
            $_SESSION['full_data_array']['ime'] = '';
        }
        $filter_array[] = $criteria_array;

        if(!empty($_POST['prezime']) && isset($_POST['prezime'])){
            $criteria_array = array(
                                    "fType" => 'text', 
                                    "fName" => 'prezime', 
                                    "fValue" => $_POST['prezime']
                                    );
            $_SESSION['full_data_array']['prezime'] = $_POST['prezime'];
        }
        else{
            $criteria_array = array(
                                    "fType" => 'none'
                                    );
            $_SESSION['full_data_array']['prezime'] = "";
        }
        $filter_array[] = $criteria_array;

        if(!empty($_POST['srednje_ime']) && isset($_POST['srednje_ime'])){
               $criteria_array = array(
                                       "fType" => 'text', 
                                       "fName" => 'srednje_ime', 
                                       "fValue" => $_POST['srednje_ime']
                                       );
               $_SESSION['full_data_array']['srednje_ime'] = $_POST['srednje_ime'];
           }
           else{
               $criteria_array = array(
                                       "fType" => 'none'
                                       );
               $_SESSION['full_data_array']['srednje_ime'] = "";
           }
           $filter_array[] = $criteria_array;  

           if(!empty($_POST['jmbg']) && isset($_POST['jmbg'])){
               $criteria_array = array(
                                       "fType" => 'text', 
                                       "fName" => 'jmbg', 
                                       "fValue" => $_POST['srednje_ime']
                                       );
               $_SESSION['full_data_array']['jmbg'] = $_POST['jmbg'];
           }
           else{
               $criteria_array = array(
                                       "fType" => 'none'
                                       );
               $_SESSION['full_data_array']['jmbg'] = "";
           }
           $filter_array[] = $criteria_array;  


        if(!empty($_POST['bDateFrom']) && isset($_POST['bDateFrom'])){
            $criteria_array = array(
                                    "fType" => 'date', 
                                    "fName" => 'datum_rodjenja', 
                                    "fValue" => $_POST['bDateFrom'] . ' 00:00:00',
                                    "fSign" => '>='
                                    );
            $_SESSION['full_data_array']['datum_rodjenja_od'] = $_POST['bDateFrom'];
        }
        else{
            $criteria_array = array(
                                    "fType" => 'none'
                                    );
            $_SESSION['full_data_array']['datum_rodjenja_od'] = "";
        }
        $filter_array[] = $criteria_array;

        if(!empty($_POST['bDateTo']) && isset($_POST['bDateTo'])){
            $criteria_array = array(
                                    "fType" => 'date', 
                                    "fName" => 'datum_rodjenja', 
                                    "fValue" => $_POST['bDateTo'] . ' 23:59:59',
                                    "fSign" => '<='
                                    );
            $_SESSION['full_data_array']['datum_rodjenja_do']=$_POST['bDateTo'];
        }
        else{
            $criteria_array = array(
                                    "fType" => 'none'
                                    );
            $_SESSION['full_data_array']['datum_rodjenja_do'] = "";
        }
        $filter_array[] = $criteria_array;
        if(!empty($_POST['pol']) && isset($_POST['pol'])){
            $criteria_array = array(
                                    "fType" => 'enum_text', 
                                    "fName" => 'pol', 
                                    "fValue" => $_POST['pol'],

                                    );
            $_SESSION['full_data_array']['pol'] = $_POST['pol'];
            if($_POST['pol']=='m'){
                $_SESSION['full_search_male_checked']="checked";
            }
            if($_POST['pol']=='z'){
                $_SESSION['full_search_female_checked']="checked";
            }
        }
        else{
            $criteria_array = array(
                                    "fType" => 'none'
                                    );
            $_SESSION['full_data_array']['pol'] = "";
        }
        $filter_array[] = $criteria_array;

        $_SESSION['filter_data_array']=$filter_array;



         // next,  previous
        if (isset($_GET['size'])){
            $_SESSION['limit']=$_GET['size'];
            }
             
        $variable=new data_management();
        $employees_list =$variable->get_employees_list_filter_full('zaposleni',$filter_array,$_SESSION['full_filter_list_page'],$_SESSION['limit']);

}
    // load page on the beginning
    else{
        if (isset($_GET['delete'])){         
            $employees_data = new data_management();
            $employees_list = $employees_data->Delete_row_method($_GET['delete']);
        }

        // next,  previous
        if (isset($_GET['size'])){
            $_SESSION['limit']=$_GET['size'];
        }

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
        $employees_list =$variable->get_employees_list_filter_full('zaposleni',$_SESSION['filter_data_array'],$_SESSION['full_filter_list_page'],$_SESSION['limit']);
    }
var_dump($_SESSION['full_search_male_checked']);
var_dump($_SESSION['full_search_female_checked']);
include_once 'full_search.html';




echo "</div>";

include_once 'right_side.html';