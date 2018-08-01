<?php

class dbFunctions
{
    protected $db_host = NULL;
    protected $db_user = NULL;
    protected $db_pass = NULL;
    protected $db_name = NULL;
    protected $db_conn = NULL;

    function __construct()
    {
        include 'config.php';

        $this->db_host = $CFG_hostname;
        $this->db_user = $CFG_username;
        $this->db_pass = $CFG_password;
        $this->db_name = $CFG_dbname;

        $this->db_conn = mysqli_connect($this->db_host, $this->db_user, $this->db_pass, $this->db_name);
    }

    function employees($pageNum = 1, $pageSize = 10){

        $result = [];
        $sql = "SELECT id_zaposleni AS id, ime AS firstName, prezime AS lastName, srednje_ime AS midName, jmbg, datum_rodjenja AS dateBirth, pol AS sex, napomena AS note, status 
                FROM zaposleni 
                LIMIT " . ($pageNum - 1)*$pageSize . ", " . $pageSize;
        $sqlResult = mysqli_query($this->db_conn, $sql);
//        var_export($sql);
        
        if (mysqli_num_rows($sqlResult) > 0){
            while($row = mysqli_fetch_assoc($sqlResult)) {
                $row = array_map('utf8_encode', $row);
                $result[] = $row; 
            }
        }

        return $result;
    }
    // adress function
    function employee_address($employee_id){

        $result = [];
        $sql = "SELECT id_adresa AS id, vrsta AS type, opstina AS area, mesto AS city, CONCAT(ulica, ' ', broj) AS address, napomena AS note, status FROM zaposleni_adresa WHERE id_zaposleni = " . $employee_id;

        $sqlResult = mysqli_query($this->db_conn, $sql);
        
        if (mysqli_num_rows($sqlResult) > 0){
            while($row = mysqli_fetch_assoc($sqlResult)) {
                $row = array_map('utf8_encode', $row);
                $result[] = $row; 
            }
        }

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

        $sqlResult = mysqli_query($this->db_conn, $sql);

        if (mysqli_num_rows($sqlResult) > 0) {
            while($row = mysqli_fetch_assoc($sqlResult)) {
                $row = array_map('utf8_encode', $row);
                $result[] = $row;
            }
        }

        return $result;
    }

    // phone function
    function employee_phone($employee_id){

        $result = [];
        $sql = "SELECT IF(area IS NOT NULL, CONCAT(area, SUBSTRING(pozivni,2), broj), CONCAT(pozivni, broj)) AS number FROM zaposleni_telefon WHERE id_zaposleni = " . $employee_id;

        $sqlResult = mysqli_query($this->db_conn, $sql);

        if (mysqli_num_rows($sqlResult) > 0) {
            while($row = mysqli_fetch_assoc($sqlResult)) {
                $row = array_map('utf8_encode', $row);
                $result[] = $row;
            }
        }

        return $result;
    }
    // adress function
    function addresses($pageNum = 1, $pageSize = 10){

        $result = [];
        $sql = "SELECT id_adresa AS id, vrsta AS type, opstina AS area, mesto AS city, CONCAT(ulica, ' ', broj) AS address, napomena AS note, status 
                FROM zaposleni_adresa 
                LIMIT " . ($pageNum - 1)*$pageSize . ", " . $pageSize;
        
        $sqlResult = mysqli_query($this->db_conn, $sql);
       
        if (mysqli_num_rows($sqlResult) > 0){
            while($row = mysqli_fetch_assoc($sqlResult)) {
                $row = array_map('utf8_encode', $row);
                $result[] = $row; 
            }
        }

        return $result;
    }
    function educations($pageNum = 1, $pageSize = 10){

        $result = [];
        $sql = "SELECT id_obrazovanje AS id, vrsta AS type, "
               ."(SELECT naziv  FROM ustanova WHERE ustanova.id_ustanova=zaposleni_obrazovanje.ustanova_id) AS institution, "
               ."(SELECT naziv FROM zvanje WHERE zvanje.id_zvanje=zaposleni_obrazovanje.zvanje_id) AS vocation "
               ."FROM agencija.zaposleni_obrazovanje "
               ." LIMIT " . ($pageNum - 1)*$pageSize . ", " . $pageSize;

        $sqlResult = mysqli_query($this->db_conn, $sql);
        
        if (mysqli_num_rows($sqlResult) > 0){
            while($row = mysqli_fetch_assoc($sqlResult)) {
                $row = array_map('utf8_encode', $row);
                $result[] = $row; 
            }
        }

        return $result;
    }
    function phones($pageNum = 1, $pageSize = 10){

        $result = [];
        $sql = "SELECT id_telefon AS id, tip AS type, "
                ."IF(area IS NOT NULL, CONCAT(area, SUBSTRING(pozivni,2), broj), CONCAT(pozivni, broj)) AS number "
                ." FROM agencija.zaposleni_telefon "
               ." LIMIT " . ($pageNum - 1)*$pageSize . ", " . $pageSize;

        $sqlResult = mysqli_query($this->db_conn, $sql);
        
        if (mysqli_num_rows($sqlResult) > 0){
            while($row = mysqli_fetch_assoc($sqlResult)) {
                $row = array_map('utf8_encode', $row);
                $result[] = $row; 
            }
        }

        return $result;
    }
    
    function empl_with_adr($pageNum = 1, $pageSize = 10){

        $result = [];
        $sql = "SELECT zaposleni.id_zaposleni, zaposleni_adresa.id_adresa, zaposleni.ime AS firstName, zaposleni.prezime AS lastName, "
                ."zaposleni_adresa.opstina AS area, zaposleni_adresa.mesto AS city, zaposleni_adresa.ulica AS address "
                ."FROM zaposleni INNER JOIN zaposleni_adresa ON zaposleni.id_zaposleni=zaposleni_adresa.id_zaposleni "
                ."ORDER BY id_zaposleni " 
                ."LIMIT " . ($pageNum - 1)*$pageSize . ", " . $pageSize;

        $sqlResult = mysqli_query($this->db_conn, $sql);
        
        if (mysqli_num_rows($sqlResult) > 0){
            while($row = mysqli_fetch_assoc($sqlResult)) {
                $row = array_map('utf8_encode', $row);
                $result[] = $row; 
            }
        }

        return $result;
    }
    
    function empl_with_phones($pageNum = 1, $pageSize = 10){

        $result = [];
        $sql = "SELECT zaposleni.id_zaposleni AS id_zaposleni, zaposleni_telefon.id_telefon, zaposleni.ime AS firstName, zaposleni.prezime AS lastName, "
                ."IF(zaposleni_telefon.area IS NOT NULL, CONCAT(zaposleni_telefon.area, SUBSTRING(zaposleni_telefon.pozivni,2), zaposleni_telefon.broj), CONCAT(zaposleni_telefon.pozivni, broj)) AS number  "
                ."FROM zaposleni LEFT JOIN zaposleni_telefon ON zaposleni.id_zaposleni=zaposleni_telefon.id_zaposleni "
                ."UNION "
                ."SELECT zaposleni.id_zaposleni AS id_zaposleni,zaposleni_telefon.id_telefon ,zaposleni.ime AS firstName, zaposleni.prezime AS lastName, "
                ."IF(zaposleni_telefon.area IS NOT NULL, CONCAT(zaposleni_telefon.area, SUBSTRING(zaposleni_telefon.pozivni,2), zaposleni_telefon.broj), CONCAT(zaposleni_telefon.pozivni, broj)) AS number  "
                ."FROM zaposleni RIGHT JOIN zaposleni_telefon ON zaposleni.id_zaposleni=zaposleni_telefon.id_zaposleni "
                ."ORDER BY id_zaposleni " 
                ."LIMIT " . ($pageNum - 1)*$pageSize . ", " . $pageSize;

        $sqlResult = mysqli_query($this->db_conn, $sql);
        
        if (mysqli_num_rows($sqlResult) > 0){
            while($row = mysqli_fetch_assoc($sqlResult)) {
                $row = array_map('utf8_encode', $row);
                if($row['number']!=''){
                    $result[] = $row;
                }
            }
        }

        return $result;
    }
    
    function empl_with_edu($pageNum = 1, $pageSize = 10){

        $result = [];
        $sql = "SELECT zaposleni.id_zaposleni AS id_zaposleni, zaposleni_obrazovanje.id_obrazovanje,  zaposleni.ime AS firstName, zaposleni.prezime AS lastName, "
               ."(SELECT ustanova.naziv  FROM ustanova WHERE ustanova.id_ustanova=zaposleni_obrazovanje.ustanova_id) AS institution, "
               ."(SELECT zvanje.naziv FROM zvanje WHERE zvanje.id_zvanje=zaposleni_obrazovanje.zvanje_id) AS vocation "
               ."FROM zaposleni INNER JOIN zaposleni_obrazovanje ON zaposleni.id_zaposleni=zaposleni_obrazovanje.id_zaposleni "
               ."ORDER BY id_zaposleni " 
               ."LIMIT " . ($pageNum - 1)*$pageSize . ", " . $pageSize;

        $sqlResult = mysqli_query($this->db_conn, $sql);
        
        if (mysqli_num_rows($sqlResult) > 0){
            while($row = mysqli_fetch_assoc($sqlResult)) {
                $row = array_map('utf8_encode', $row);
                $result[] = $row; 
            }
        }

        return $result;
    }
}
