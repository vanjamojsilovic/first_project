<?php

session_start();

$_SESSION['employees_list_page'] = 0;
$_SESSION['employees_filter_list_page'] = 0;
$_SESSION['data_array']=array();
 $_SESSION['data_array']['ime'] = '';
 $_SESSION['data_array']['prezime'] = "";
 $_SESSION['data_array']['srednje_ime'] = "";
 $_SESSION['data_array']['jmbg'] = "";
 $_SESSION['data_array']['datum_rodjenja_od'] = "";
 $_SESSION['data_array']['datum_rodjenja_do'] = "";

$_SESSION['full_filter_list_page'] = 0;
$_SESSION['filter_data_array']=array();
$_SESSION['full_employees_list_page']=0;
$_SESSION['limit']=10;

include_once 'website_layout.html';

include_once 'pocetna.html';

//echo "<div class='column right'>";
include_once 'right_side.html';
//echo'</div>';




