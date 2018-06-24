 <?php

session_start();

$_SESSION['employees_list_page'] = 0;
$_SESSION['employees_filter_list_page'] = 0;
// select_table.php search_list.php
$_SESSION['data_array']=array();
 $_SESSION['data_array']['ime'] = "";
 $_SESSION['data_array']['prezime'] = "";
 $_SESSION['data_array']['srednje_ime'] = "";
 $_SESSION['data_array']['jmbg'] = "";
 $_SESSION['data_array']['datum_rodjenja_od'] = "";
 $_SESSION['data_array']['datum_rodjenja_do'] = "";
 
// full_search.php
 $_SESSION['full_data_array']=array();
 $_SESSION['full_data_array']['ime'] = "";
 $_SESSION['full_data_array']['prezime'] = "";
 $_SESSION['full_data_array']['srednje_ime'] = "";
 $_SESSION['full_data_array']['jmbg'] = "";
 $_SESSION['full_data_array']['datum_rodjenja_od'] = "";
 $_SESSION['full_data_array']['datum_rodjenja_do'] = "";
 
$_SESSION['full_filter_list_page'] = 0;
$_SESSION['filter_data_array']=array();
$_SESSION['full_employees_list_page']=0;
$_SESSION['limit']=10;

$_SESSION['update_selected_id']="";
$_SESSION['update_data']=array('ime'=>'', 
                               'prezime'=>'',
                               'srednje_ime'=>'',
                               'jmbg'=>'',
                               'datum_rodjenja'=>'',
                               'pol'=>'');
$_SESSION['gender_male']='';
$_SESSION['gender_female']='';

$_SESSION['div_display']='"none"';

$_SESSION['full_search_male_checked']="";
$_SESSION['full_search_female_checked']="";


include_once 'website_layout.html';

include_once 'pocetna.html';


include_once 'right_side.html';





