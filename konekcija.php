<?php

        
      

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "agencija";

$ime_zaposleni ="";
$prezime_zaposleni="";
$srednje_ime_zaposleni="";
$jmbg_zaposleni="";
$godina_rodjenja="";
$mesec_rodjenja="";
$dan_rodjenja="";
$crta="-";
$datum_rodjenja_zaposleni="";
$pol="";

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}



if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $ime_zaposleni =test_input($_POST["ime"]);
  $prezime_zaposleni= test_input($_POST["prezime"]);
  $srednje_ime_zaposleni= test_input($_POST["srednje_ime"]);
  $jmbg_zaposleni= test_input($_POST["jmbg"]);
  $godina_rodjenja=$_POST["godina_rodjenja"];
  $mesec_rodjenja=$_POST["mesec_rodjenja"];
  $dan_rodjenja=$_POST["dan_rodjenja"];
  $datum_rodjenja_zaposleni=$godina_rodjenja.$crta.$mesec_rodjenja.$crta.$dan_rodjenja;
  if($_POST["pol"]=="muski")
      {$pol="m";}
      else
      {$pol="z";};
 }




// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "INSERT INTO zaposleni (ime, prezime, srednje_ime, jmbg, datum_rodjenja,pol) "
        . "VALUES ('$ime_zaposleni',"
        . "'$prezime_zaposleni',"
        . "'$srednje_ime_zaposleni',"
        . "'$jmbg_zaposleni',"
        . "'$datum_rodjenja_zaposleni',"
        . "'$pol')";

if ($conn->query($sql) === TRUE) {
    echo "Успешно унети подаци!";
    include_once 'ponovo.html';
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
   


