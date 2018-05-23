<?php

include_once 'website_layout.html';


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


            $sql = "SELECT ime, prezime, srednje_ime FROM zaposleni";

            $conn = db_connect();

            $result = $conn->query($sql);
            $names = [];
            
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $row = array_map('utf8_encode', $row);
                    
                    $names[] = $row; 
                    
                }
            }

       

      db_disconnect($conn);
echo "<div class='column middle'>";
include_once 'select_table.html';
echo'</div>';
echo "<div class='column right'>";
include_once 'right_side.html';
echo'</div>';