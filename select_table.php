<?php

session_start();

include_once 'website_layout.html';

require('libs/db_methods.php');

if (isset($_GET['page'])){
    if($_GET['page']==1){
        if($_SESSION['employees_list_page']>=0){
            $_SESSION['employees_list_page'] = $_SESSION['employees_list_page'] + $_GET['page'];
                                                }
                        }
    elseif($_GET['page']==-1){
        if($_SESSION['employees_list_page']>0){
            $_SESSION['employees_list_page'] = $_SESSION['employees_list_page'] + $_GET['page'];
                                              }
                            }
}

$employees_data = new data_management();

$employees_list = $employees_data->get_employees_list($_SESSION['employees_list_page'], 10);
    

include_once 'select_table.html';

//echo "<div class='column right'>";
include_once 'right_side.html';
//echo'</div>';