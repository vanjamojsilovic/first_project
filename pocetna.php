<?php




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


            $sql = "SELECT ime FROM zaposleni  LIMIT 2";

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
      include_once 'pocetna.html';




