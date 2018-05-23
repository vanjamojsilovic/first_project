<?php

session_start();

$_SESSION['employees_list_page'] = 0;

include_once 'website_layout.html';

include_once 'pocetna.html';

echo "<div class='column right'>";
include_once 'right_side.html';
echo'</div>';




