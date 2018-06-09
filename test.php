<?php
require('libs/db_methods.php');

$test_data_management = new data_management();

$array=array('ime'=>'Nikola', 'prezime'=>'Petrovic', 'srednje_ime'=>'Nikolaj','jmbg'=>'1212965770123','datum_rodjenja'=>'1965-12-12','pol'=>'m','napomena'=>'proba!','status'=>1);

$test_data_management->insert_data('zaposleni', $array);