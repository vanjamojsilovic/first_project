<?php

session_start();
 $_SESSION['data_array']['ime'] = '';
 $_SESSION['data_array']['prezime'] = "";
 $_SESSION['data_array']['srednje_ime'] = "";
 $_SESSION['data_array']['jmbg'] = "";
 $_SESSION['data_array']['datum_rodjenja_od'] = "";
 $_SESSION['data_array']['datum_rodjenja_do'] = "";
 
 $_SESSION['filter_data_array']=array();
 $_SESSION['limit']=10;
 
 header("Location: select_table.php");