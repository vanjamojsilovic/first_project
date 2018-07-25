<?php
session_start();
$_SESSION['pageSize']=10;
$_SESSION['pageNum']=1;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function sanatize_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));;
}

function db_connect(){

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "agencija";   
    
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    return $conn;
}
function db_disconnect($db_conection){
    $db_conection->close();
}

// adress function
function employee_address($employee_id){
    
    $result = [];
    $sql = "SELECT id_adresa AS id, vrsta AS type, opstina AS area, mesto AS city, CONCAT(ulica, ' ', broj) AS address, napomena AS note, status FROM zaposleni_adresa WHERE id_zaposleni = " . $employee_id;

    $conn = db_connect();
    $sqlResult = $conn->query($sql);

    if ($sqlResult->num_rows > 0) {
        while($row = $sqlResult->fetch_assoc()) {
            $row = array_map('utf8_encode', $row);
            $result[] = $row; 
        }
    }
    
    db_disconnect($conn);

    return $result;
}
// education function
function employee_education($employee_id){
    
    $result = [];
    $sql = "SELECT zaposleni_obrazovanje.id_obrazovanje AS id, zaposleni_obrazovanje.vrsta AS type, zaposleni_obrazovanje.godina AS year, ustanova.naziv AS istitution, zvanje.naziv AS vocation "
            . "FROM zaposleni_obrazovanje  "
            . "INNER JOIN ustanova ON zaposleni_obrazovanje.ustanova_id=ustanova.id_ustanova "
            . "INNER JOIN zvanje ON zaposleni_obrazovanje.zvanje_id=zvanje.id_zvanje "
            . "WHERE id_zaposleni = " . $employee_id;

    $conn = db_connect();
    $sqlResult = $conn->query($sql);

    if ($sqlResult->num_rows > 0) {
        while($row = $sqlResult->fetch_assoc()) {
            $row = array_map('utf8_encode', $row);
            $result[] = $row;
        }
    }
    
    db_disconnect($conn);

    return $result;
}

// phone function
function employee_phone($employee_id){
    
    $result = [];
    $sql = "SELECT IF(area IS NOT NULL, CONCAT(area, SUBSTRING(pozivni,2), broj), CONCAT(pozivni, broj)) AS number FROM zaposleni_telefon WHERE id_zaposleni = " . $employee_id;

    $conn = db_connect();
    $sqlResult = $conn->query($sql);

    if ($sqlResult->num_rows > 0) {
        while($row = $sqlResult->fetch_assoc()) {
            $row = array_map('utf8_encode', $row);
            $result[] = $row;
        }
    }
    
    db_disconnect($conn);

    return $result;
}


// response
if (isset($_GET['pageSize'])&&isset($_GET['pageNum'])){
    $_SESSION['pageSize']=$_GET['pageSize'];
    $_SESSION['pageNum']=$_GET['pageNum'];
    $sql = "SELECT id_zaposleni AS id, ime AS firstName, prezime AS lastName, srednje_ime AS midName, jmbg, datum_rodjenja AS dateBirth, pol AS sex, napomena AS note, status FROM zaposleni WHERE id_zaposleni > ".($_SESSION['pageNum'] * $_SESSION['pageSize'])." LIMIT ".$_SESSION['pageSize'];

    $conn = db_connect();

    $result = $conn->query($sql);

    $emplooyes = [];

    if ($result->num_rows > 0) {
        $i = 0;
        while($row = $result->fetch_assoc()) {
            $row = array_map('utf8_encode', $row);

            $emplooyes[] = $row; 
            $emplooyes[$i]['address'] = employee_address($emplooyes[$i]['id']);
            $emplooyes[$i]['education'] = employee_education($emplooyes[$i]['id']);
            $emplooyes[$i]['phone'] = employee_phone($emplooyes[$i]['id']);

            $i = $i + 1;
        }
    }

    db_disconnect($conn);

    $response = json_encode($emplooyes);

echo $response;
}