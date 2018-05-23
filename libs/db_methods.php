<?php

class data_management
{
    protected $db_host = "localhost";
    protected $db_user = "root";
    protected $db_pass = "";
    protected $db_database = "agencija";
    
    protected $db_connection = NULL;
    
    private function db_connect(){

        $this->db_connection = new mysqli($this->db_host, $this->db_user, $this->db_pass, $this->db_database);
    }
    
    private function db_disconnect(){
        $this->db_connection->close();
    }
    
    private function table_count($table_name){        
        $sql = "SELECT Count(*) AS recordCount FROM " . $table_name;
        
        $this->db_connect();
        $result = $this->db_connection->query($sql);
        $row = $result->fetch_assoc();
        $result = $row['recordCount'];
        $this->db_disconnect();
        
        return $result;
    }
    function get_employees_list($sql_offset = 0, $row_count = 20){
        $sql = "SELECT id_zaposleni, ime, prezime, srednje_ime FROM zaposleni LIMIT " . $sql_offset . ", " . $row_count;

        $this->db_connect();

        $result = $this->db_connection->query($sql);
        $names = [];

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $row = array_map('utf8_encode', $row);

                $names[] = $row; 

            }
        }
        
        $this->db_disconnect();
        
        $employee_list = array(
                                "names" => $names,
                                "offset" => $sql_offset,
                                "row_count" => $row_count,
                                "total" => $this->table_count('zaposleni')
                            );
        
        return $employee_list;
    }
}