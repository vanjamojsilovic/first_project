<?php

session_start();
$_SESSION['data_array']['ime'] = '';
$_SESSION['data_array']['prezime'] = "";
$_SESSION['data_array']['srednje_ime'] = "";
$_SESSION['data_array']['jmbg'] = "";
$_SESSION['data_array']['datum_rodjenja_od'] = "";
$_SESSION['data_array']['datum_rodjenja_do'] = "";

$_SESSION['filter_data_array']=array();
$_SESSION['employees_list_page']=0;

$_SESSION['full_search_male_checked']="";
$_SESSION['full_search_female_checked']="";


header("Location: select_table.php");