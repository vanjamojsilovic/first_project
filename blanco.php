<?php

session_start();
$_SESSION['full_data_array']['ime'] = '';
$_SESSION['full_data_array']['prezime'] = "";
$_SESSION['full_data_array']['srednje_ime'] = "";
$_SESSION['full_data_array']['jmbg'] = "";
$_SESSION['full_data_array']['datum_rodjenja_od'] = "";
$_SESSION['full_data_array']['datum_rodjenja_do'] = "";

$_SESSION['filter_data_array']=array();
$_SESSION['full_filter_list_page']=0;

$_SESSION['full_search_male_checked']="";
$_SESSION['full_search_female_checked']="";

$_SESSION['div_display']='none';
$_SESSION['button_display']='Show more';


header("Location: full_search.php");
