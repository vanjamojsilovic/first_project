<?php



$select_output = ['id_zaposleni', 'ime', 'prezime', 'srednje_ime'];

// od niza pravi veliki string
$sql = "SELECT " . implode(', ', $select_output);
var_dump($sql);