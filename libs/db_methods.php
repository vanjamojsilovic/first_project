<?php

function test_input($data) {
          $data = trim($data);
          $data = stripslashes($data);
          $data = htmlspecialchars($data);
          return $data;
        }
function Checked_male($gender){
        $result="";
        if($gender=="m"){
            $result="checked";
        }
        else{
            $result="";
        }
        return $result;
    }
    
    function Checked_female($gender){
        $result="";
        if($gender=="z"){
            $result="checked";
        }
        else{
            $result="";
        }
        return $result;
    }

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
        $sql = "SELECT Count(*) AS recordCount FROM ".$table_name." AS TABLE_COUNT";
        
        $this->db_connect();
        $result = $this->db_connection->query($sql);
        $row = $result->fetch_assoc();
        $result = $row['recordCount'];
        $this->db_disconnect();
        
        return $result;
    }
    
    function get_employees_list($sql_offset = 0, $row_count = 20){
        $sql = "SELECT id_zaposleni, ime, prezime, srednje_ime FROM zaposleni LIMIT " . ($sql_offset*$row_count) . ", " . $row_count;

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
                                "total" => $this->table_count('zaposleni'),
                                "sql"=>$sql
                            );
        
        return $employee_list;
    }
    
    function get_employees_list_filter($search_data){
    
        $sql = "SELECT id_zaposleni, ime, prezime, srednje_ime FROM zaposleni WHERE ";
        foreach ($search_data as $key => $value) {
           $sql =$sql.$key." LIKE '".$value."%' AND ";
        }
        $sql = substr($sql, 0, strlen($sql) - 4);
       
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
                                "sql"=>$sql
//                                "offset" => $sql_offset,
//                                "row_count" => $row_count,
//                                "total" => $this->table_count('zaposleni')
                            );
        
        return $employee_list;
    }
    
    function update_data($table_name, $column_id , $row_id, $new_data){
        
        $sql = "UPDATE ". $table_name ." SET ";
        foreach ($new_data as $key => $value) {
            $sql=$sql.$key."='".$value."', ";
             
            }
        $sql = substr($sql, 0, strlen($sql) - 2);
        $sql=$sql." WHERE ". $column_id."=".$row_id;
        
      
        
        $this->db_connect();
        $result = $this->db_connection->query($sql);
        
        $this->db_disconnect();
        
        return $result;
    }
    
    function insert_data($table_name, $new_values){
        $sql = "INSERT INTO ". $table_name ."(";
        foreach ($new_values as $key => $value) {
            $sql=$sql.$key.", "; 
            }
        $sql = substr($sql, 0, strlen($sql) - 2);
        
        $sql=$sql.") VALUES (";
                
        foreach ($new_values as $key => $value) {
             $sql=$sql." '".$value."', ";
        }
        $sql = substr($sql, 0, strlen($sql) - 2);
        
        $sql=$sql.")";
        $this->db_connect();
        $result = $this->db_connection->query($sql);
       
        $this->db_disconnect();
        
        return $result;
    }
    
    function search_data($table_name, $search_data, $sql_offset = 0, $row_count = 20){
        if(!empty($search_data)){
            
            $sql = "SELECT id_zaposleni, ime, prezime, srednje_ime FROM ".$table_name." WHERE ";
            foreach ($search_data as $key => $value) {
               $sql =$sql.$key." LIKE '".$value."%' AND ";
            }
            $sql = substr($sql, 0, strlen($sql) - 4);
            $sql_count="( ".$sql." )";
            $sql =$sql." LIMIT " . ($sql_offset*$row_count) . ", " . $row_count;

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
                                    "total" => $this->table_count($sql_count)
                                );

            return $employee_list;
        }
        else{
           
            return array();
        }
    }
    
    function get_employees_list_filter_full($table_name,$search_data,$sql_offset = 0,$row_count = 20){
        
        $sql = "SELECT id_zaposleni, ime, prezime, srednje_ime FROM ".$table_name. " WHERE ";
        
        if(empty($search_data)){
            $sql = substr($sql, 0, strlen($sql) - 6);
            $sql_count="( ".$sql." )";
            $sql =$sql." LIMIT " . ($sql_offset*$row_count) . ", " . $row_count;
            
        }
        else{
            foreach ($search_data as $criteria) {

                        if ($criteria['fType'] == 'text'){
                            $sql = $sql . $criteria['fName'] . " LIKE '" . $criteria['fValue'] . "%' AND ";
                        }
                        elseif ($criteria['fType'] == 'date') {
                            $sql = $sql . $criteria['fName']  . $criteria['fSign'] . " '" . $criteria['fValue'] . "' AND ";
                        }
                        elseif ($criteria['fType'] == 'enum_text') {
                            $sql = $sql . $criteria['fName'] . " = '" . $criteria['fValue'] . "' AND ";
                        }

                }
            


            $sql = substr($sql, 0, strlen($sql) - 4);
            $sql_count="( ".$sql." )";
            $sql =$sql." LIMIT " . ($sql_offset*$row_count) . ", " . $row_count;
            
        }
        
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
                                "sql" => $sql,
                                "offset" => $sql_offset,
                                "row_count" => $row_count,
                                "total" => $this->table_count($sql_count)
                            );
        
        return $employee_list;
    }
    
    function Delete_row_method($selected_id){
        $sql="DELETE FROM zaposleni WHERE id_zaposleni=".$selected_id;
        $this->db_connect();
        $this->db_connection->query($sql);
        $this->db_disconnect();
    }
    
    function Update_select($selected_id){
        $sql="SELECT * FROM zaposleni WHERE id_zaposleni=".$selected_id;
        $this->db_connect();
        $result = $this->db_connection->query($sql);
        $this->db_disconnect();
        $row=array();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $row = array_map('utf8_encode', $row);
        }
        return $row;
    }
    
    function Update_post($table_name,$array_values,$selected_id){
        
        $sql="UPDATE ".$table_name." SET ime='".$array_values['ime']."', prezime='".$array_values['prezime']."', srednje_ime='".$array_values['srednje_ime']."', jmbg='".$array_values['jmbg']."', `datum_rodjenja`='".$array_values['datum_rodjenja']."', pol='".$array_values['pol']."' WHERE id_zaposleni='".$selected_id."'";
        var_dump($sql);
        $this->db_connect();
        $result =$this->db_connection->query($sql);
        $this->db_disconnect();
        
        return $result;
    }
    
}