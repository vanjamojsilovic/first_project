<?php

session_start();

$_SESSION['employees_list_page'] = 0;
$_SESSION['employees_filter_list_page'] = 0;
$_SESSION['data_array']=array();
$_SESSION['full_filter_list_page'] = 0;
$_SESSION['filter_data_array']=array();

include_once 'website_layout.html';

include_once 'pocetna.html';

//echo "<div class='column right'>";
include_once 'right_side.html';
//echo'</div>';




