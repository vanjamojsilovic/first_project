<?php

session_start();
 $_SESSION['full_data_array']['ime'] = '';
 $_SESSION['full_data_array']['prezime'] = "";
 $_SESSION['full_data_array']['srednje_ime'] = "";
 $_SESSION['full_data_array']['jmbg'] = "";
 $_SESSION['full_data_array']['datum_rodjenja_od'] = "";
 $_SESSION['full_data_array']['datum_rodjenja_do'] = "";
 
 $_SESSION['filter_data_array']=array();
 $_SESSION['limit']=10;
 
 header("Location: full_search.php");
