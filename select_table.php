<?php

session_start();

include_once 'website_layout.html';

require('libs/db_methods.php');

if (isset($_GET['page'])){
    $_SESSION['employees_list_page'] = $_SESSION['employees_list_page'] + $_GET['page'];
}

$employees_data = new data_management();

$employees_list = $employees_data->get_employees_list($_SESSION['employees_list_page'], 10);
    
echo "<div class='column middle'>";
include_once 'select_table.html';
echo'</div>';
echo "<div class='column right'>";
include_once 'right_side.html';
echo'</div>';